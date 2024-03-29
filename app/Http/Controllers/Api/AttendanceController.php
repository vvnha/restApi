<?php

namespace App\Http\Controllers\Api;

use App\Model\Attendance;
use App\Model\Shift;
use App\Model\Salary;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;
use DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$attend = Attendance::all();
        //return response()->json(['success' => true, 'code' => '200', 'data' => $position]);
        $now = Carbon::now();
        return $this->updateSalary($now->month, $now->year,2,4);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'userID' => 'required', 
            'date' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data = User::find((integer)$request->userID);
        $now = Carbon::now()->toDateString();
        //$timeAttend = $request->timeAttend;
        //$datetime = Carbon::create($now. ' '.$timeAttend);
        $spec = $data->specificSalary->where('note',1)->first()->kindOfSalary;
        $hour = $spec->hour;
        $insertDate = Carbon::create($request->date);
        $timeAttend = Shift::where('position',$data->positionID)->get();
        $type = 1;
        if($data == true){
            if($type == 1){
                foreach($timeAttend as $value){
                    $checkIn = Carbon::create($insertDate->toDateString(). ' '.$value->checkIn);
                    $checkOut = Carbon::create($insertDate->toDateString(). ' '.$value->checkOut);
                    $value->checkInTime = Carbon::create($insertDate->toDateString(). ' '.$value->checkIn);
                    $value->checkOutTime = Carbon::create($insertDate->toDateString(). ' '.$value->checkOut);
                    $diff = $checkIn->diffInMinutes($checkOut);
                    $value->checkSpan = $insertDate->between($checkIn, $checkOut);
                    $value->check = $insertDate->between($checkIn->subMinutes(30), $checkOut->subMinutes($diff/2-30));
                }
                
                $result = $timeAttend->where('check',true);
                if($result->count()>0){
                    $shift = $result->first();
                    $originCheckIn = Carbon::create($insertDate->toDateString(). ' '.$shift->checkIn);
                    $checkInTime = $shift->checkInTime;
                    $checkOutTime = $shift->checkOutTime;
                    $getAttend = Attendance::where('userID','=',$data->id)->whereYear('date','=',$insertDate->year)->whereMonth('date','=',$insertDate->month)->whereDay('date','=',$insertDate->day)->get();
                    
                    if($getAttend->where('shiftID',$shift->id)->count()>0){
                        $attendResult = 0;
                        
                    }else{
                        // if($getAttend->whereNotNull('checkOut')->count()>0){
                        //     $attendResult = 2;
                        // }else{
                            $attendResult = 1;
                        // }

                    }
                    if($insertDate->isBefore($checkInTime->addMinutes(15))){
                        if($insertDate->isBefore($originCheckIn)){
                            $deduction = 0;
                            $note = '';
                            
                        }else{
                            $deduction = 20000;
                            $note = 'Đi trễ';
                        }
                    }else {
                        $deduction = 50000;
                        $note = 'Đi trễ sau giờ điểm danh quá 15 phút';
                    }
                    //truong hop diem danh lien tuc tu ca1 sang ca2 thi khong xet dieu kien tru luong doi voi ca2
                    if($getAttend->count()>0){
                        foreach($getAttend as $value){
                            $value->checkOut = $value->shift->checkOut;
                            $value->checkIn = $shift->checkIn;
                            $value->timeCheckOut = Carbon::create($insertDate->toDateString()." ".$value->checkOut)->toDateTimeString();
                            $value->check = $value->shift->checkOut == $shift->checkIn && $value->shift->id != $shift->id;
                            //$value->check = $insertDate->isAfter($shift->checkInTime);
                        }
                        //return response()->json(['success' => false, 'messages' => $getAttend ],200);
                        $resultAttend = $getAttend->where('check',true);
                        if($resultAttend->count()>0){
                            $deduction = 0;
                            $note = 'Tăng ca';
                            $attendResult = 2;
                        }
                    }
                    
                    if($attendResult == 1 ){ //neu chua diem danh hoac diem danh tiep tuc thi insert
                        $attendance = new Attendance();
                        $attendance->userID = $request->userID;
                        $attendance->date =  $request->date;
                        $attendance->hour = $hour;
                        $attendance->shiftID =  $shift->id;
                        $attendance->bonus =  0;
                        $attendance->deduction = $deduction;
                        $attendance->note = $attendance->note .', '. $note;
                        $attendance->save();
                        return $this->updateSalary($insertDate->month,$insertDate->year,$request->userID);
                    }else{
                        return response()->json(['success' => false, 'messages' => 'You have already attendance! Do you wanna check out!(2)'],208);
                    }
                }else{
                    $getAttendSpan = $timeAttend->where('checkSpan',true)->first();
                    //return response()->json(['success' => false, 'messages' => $getAttendSpan],422);
                    //$getAttend = Attendance::where('userID','=',$data->id)->whereYear('date','=',$insertDate->year)->whereMonth('date','=',$insertDate->month)->whereDay('date','=',$insertDate->day)->where('shiftID',$getAttendSpan->th)->get();
                    if($getAttendSpan!=null){
                        $getAttend = Attendance::where('userID','=',$data->id)->whereYear('date','=',$insertDate->year)->whereMonth('date','=',$insertDate->month)->whereDay('date','=',$insertDate->day)->where('shiftID',$getAttendSpan->th)->get();
                        if($getAttend->count()>0){
                            return response()->json(['success' => false, 'messages' => 'You have already attendance! Do you wanna check out!(1)'],208);
                        }else{
                            return response()->json(['success' => false, 'messages' => 'The time is over'],422);
                        }
                        //return $this->updateSalary($insertDate->month,$insertDate->year,$request->userID);
                    }else{
                         return response()->json(['success' => false, 'messages' => 'The time is over'],422);
                    }
                }
            }else{
                //khi checkout
                $checkAttend = Attendance::where('userID','=',$data->id)->whereYear('date','=',$insertDate->year)->whereMonth('date','=',$insertDate->month)->whereDay('date','=',$insertDate->day)->get();
                if($checkAttend->count()>0){
                    $attendance = $checkAttend->first();
                    $diff = $insertDate->diffInHours($attendance->date);
                    $attendance->hour = $diff;
                    $attendance->save();
                    return response()->json(['success' => false, 'messages' => $attendance ],200);
                }else{
                    return response()->json(['success' => false, 'messages' => 'You have not been attended'],422);
                }
            }
        }else{
            return response()->json(['success' => false, 'messages' => 'Error network', 404]);
        }

        // if($data == true){
        //     if($insertDate->hour<$datetime->hour || ($insertDate->hour==$datetime->hour && $insertDate->minute<=$datetime->minute + 15)){ // diem danh truoc khi ket thuc diem danh hoac sau khi do 15p
        //         $attendance = new Attendance();
        //         $attendance->userID = $request->userID;
        //         $attendance->date =  $request->date;
        //         // $attendance->save();
        //         if($checkAttend->count()>0){
        //             $newTime = Carbon::create($now. ' 12:00:00');
        //             if($data->positionID == 6 && $checkAttend->count()<2 && ($insertDate->hour > $newTime->hour|| ($insertDate->hour ==  $newTime->hour && $insertDate->minute > $datetime->minute + 10 ))){ // diem danh lan 2 doi voi part time staff (position =6) và thgian phai truoc thoi gian diem danh (bat buoc sau 12h)
        //                 if(Carbon::create($checkAttend[0]->date)->hour != $insertDate->hour){ // thoi gian diem danh khong duoc trung voi thoi gian diem danh cua ca1
        //                     $result = true;
        //                 }else{
        //                     $result = false;
        //                 }
                        
        //             }else{
        //                 $result = false;
        //             }
        //         }else{
        //             $result = true;
        //         }
        //         if($result == true){
        //             $attendance->save();
        //             return response()->json(['success' => true, 'code' => '200', 'data' => $result]);
        //         }else{
        //             return response()->json(['success' => false, 'code' => '404', 'data' => 'You have alredy had attendance('.$checkAttend->count().')']);
        //         }
        //     }else{
        //         return response()->json(['success' => false, 'code' => '404']);
        //     }
        //   }else{
        //     return response()->json(['success' => false, 'code' => '404']);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = User::find((integer)$id);
        $date = Carbon::create($request->date);
        $attend = Attendance::where('userID',$id)->whereYear('date',$date->year)->whereMonth('date',$date->month)->whereDay('date',$date->day)->get();
        return response()->json(['success' => false, 'data' => $attend->first()->date],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        // $validator = Validator::make(json_decode($request[0]), [
        //     'collect' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors(), 'code' => 401]);
        // }
        // return response()->json(json_decode($request[0]));
        
        $attendList = json_decode($request[0])->collect;
        
        if(count($attendList)>0){
            foreach($attendList as $value){
                
                $insertDate = Carbon::create($value->date);
                if($insertDate->isAfter(Carbon::create($insertDate->toDateString().' 22:00:00'))){
                    $insertDate = Carbon::create($insertDate->toDateString().' 22:00:00');
                }
                $checkAttend = Attendance::where('userID','=',$value->userID)->whereYear('date','=',$insertDate->year)->whereMonth('date','=',$insertDate->month)->whereDay('date','=',$insertDate->day)->get();
                if($checkAttend->count()>0){
                    $attendance = $checkAttend->first();
                    $diff = $insertDate->diffInHours($attendance->date);
                    $attendance->hour = $diff;
                    $attendance->checkOut = $insertDate;
                    $attendance->save();
                    $this->updateSalary($insertDate->month,$insertDate->year,$value->userID);
                }
            }
            $response = [
                    'success' => true,
                    'code' => $request,
                    'datetime' => 'OK'
                ];
            return response()->json($response);
        }else{
            $response = [
                'success' => true,
                'code' => $request,
                'message' => "no data"
            ];  
            return response()->json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function updateSalary($month,$year,$userID)
    {
        $user = User::find((integer)$userID);
        $checkSalary = $user->getSalary->where('month', $month)->where('year','=',$year);
        $spec = $user->specificSalary->where('note',1)->first();
        $ksalary = $spec->kindOfSalaryID;
        $price = $spec->kindOfSalary;
        // $totalDate = $user->attend;
        $totalDate = Attendance::where('userID','=',$userID)->whereMonth('date','=',$month)->whereYear('date','=',$year)->get();
        //$total = Attendance::select(DB::raw('sum(hour * price) as total'))->get();
        $bonus = $totalDate->sum('bonus');
        $deduction = $totalDate->sum('deduction');
        $totalTime = $totalDate->sum('hour');

        if($checkSalary->count()>0){
            $salary = Salary::find($checkSalary->first()->id);
            $salary->totalDate = $totalDate->count();
            $salary->bonus = $bonus;
            $salary->deduction = $deduction;
            $salary->total = $totalTime*$price->coeficient*$price->salary+$bonus-$deduction;
            $salary->save();
            $data=$salary;
        }else{
            $newSalary = new Salary();
            $newSalary->specificSalaryID = $spec->id;
            $newSalary->totalDate = $totalDate->count();
            $newSalary->bonus = $bonus;
            $newSalary->deduction = $deduction;
            $newSalary->total = $totalTime*$price->coeficient*$price->salary+$bonus-$deduction;
            $newSalary->month = $month;
            $newSalary->year = $year;
            $newSalary->note = '';
            $newSalary->save();
            $data = $newSalary;
        }
        return response()->json(['success' => false, 'data' => $data],200);
    }
}