<?php

namespace App\Http\Controllers\Admin;

use App\Model\Shift;
use App\Model\Attendance;
use App\Model\Salary;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;
use DB;

class AttendanceController extends Controller
{
    public function index()
    {
        $data = Attendance::orderBy('id', 'DESC')->paginate(8);
        $collection = Attendance::count();
        foreach($data as $value){
            $value->userName = $value->user->name;
        }
        return view('admin.attend.index',['data'=>$data,'collection'=>$collection]);
    }
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
        
        if($data == true){
            foreach($timeAttend as $value){
                $checkIn = Carbon::create($insertDate->toDateString(). ' '.$value->checkIn);
                $checkOut = Carbon::create($insertDate->toDateString(). ' '.$value->checkOut);
                $value->checkInTime = Carbon::create($insertDate->toDateString(). ' '.$value->checkIn);
                $value->checkOutTime = Carbon::create($insertDate->toDateString(). ' '.$value->checkOut);
                $diff = $checkIn->diffInMinutes($checkOut);
                $value->check = $insertDate->between($checkIn->subMinutes(30), $checkOut->subMinutes($diff/2-30));
            }
            $result = $timeAttend->where('check',true);
            if($result->count()>0){
                $shift = $result->first();
                $originCheckIn = Carbon::create($insertDate->toDateString(). ' '.$shift->checkIn);
                $checkInTime = $shift->checkInTime;
                $checkOutTime = $shift->checkOutTime;
                $checkAttend = Attendance::where('userID','=',$data->id)->whereYear('date','=',$insertDate->year)->whereMonth('date','=',$insertDate->month)->whereDay('date','=',$insertDate->day)->where('shiftID',$shift->id)->get();
                //return response()->json(['success' => false, 'messages' => $checkAttend],422);
                if($checkAttend->count()>0){
                    $attendResult = false;
                }else{
                    $attendResult = true;
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
                if($attendResult == true){
                    $attendance = new Attendance();
                    $attendance->userID = $request->userID;
                    $attendance->date =  $request->date;
                    $attendance->hour = $hour;
                    $attendance->shiftID =  $shift->id;
                    $attendance->bonus =  0;
                    $attendance->deduction = $deduction;
                    $attendance->note = $attendance->note .', '. $note;
                    //return response()->json(['success' => false, 'code' => $checkAttend]);
                    $attendance->save();
                    return $this->updateSalary($insertDate->month,$insertDate->year,$request->userID);
                }else{
                    return response()->json(['success' => false, 'messages' => 'You have already attendance!'],422);
                }
            }else{
                return response()->json(['success' => false, 'messages' => 'The time is over'],422);
            }
        }else{
            return response()->json(['success' => false, 'messages' => 'Error network', 404]);
        }
    }
    public function show(Request $request, $id)
    {
        $data = Attendance::find((integer)$id);
        return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
    }
    public function update(Request $request, $id){
        $data = Attendance::find((integer)$id);
        $insertDate = Carbon::create($data->date);
        $dateTam = Carbon::create($data->date);
          if($data == true){
            $data->fill($request->all());
            $validator = Validator::make($request->all(), [ 
                'userID' => 'required', 
                'hour' => 'required',
                'bonus' => 'required',
                'deduction' => 'required'
            ]);
            if ($validator->fails()) { 
                return response()->json([
                    'error'    => true,
                    'messages' => $validator->errors(),
                ], 422);
            }
            $data->checkOut = $dateTam->addHours($request->hour);
            $data->save();
            $this->updateSalary($insertDate->month, $insertDate->year, $data->userID);
            return response()->json(['success' => true, 'code' => '200']);
          }else{
            return response()->json([
                'error'    => true,
                'messages' => ['404','khong tim thay du lieu'],
            ], 422);
          }
          
      
          // $cmt->save();
          // return response()->json(['success' => true, 'code' => 200]);
    }
    public function destroy(Request $request, $id)
    {
        $data = Attendance::destroy($id);
        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
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
        return response()->json(['success' => false, 'code' => '200', 'data' => $data]);
    }
    public function searchdate(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
              'dateS' => 'required'
            ]);
            if ($validator->fails()) { 
                return redirect()->back();        
        }
        $date = Carbon::create($request->dateS);


        $data = Attendance::whereYear('date',$date->year)->whereMonth('date',$date->month)->whereDay('date',$date->day)->paginate(8);
        // $data = $user->getSalary;
        $collection = $data->count();
        return view('admin.attend.index',['data'=>$data,'collection'=>$collection]);
    }
    public function searchuser(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
              'gmail' => 'required'
            ]);
            if ($validator->fails()) { 
                return redirect()->back();        
        }
        $user = User::where('email', 'LIKE' ,'%'.$request->gmail.'%')->first();
        $data = $user->attend;
        $collection = $data->count();
        return view('admin.attend.index',['data'=>$data,'collection'=>$collection]);
        
    
    }
}
