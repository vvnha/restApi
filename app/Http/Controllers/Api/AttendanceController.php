<?php

namespace App\Http\Controllers\Api;

use App\Model\Attendance;
use App\Model\Salary;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;

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
            'date' => 'required',
            'timeAttend' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $data = User::find((integer)$request->userID);
        $now = Carbon::now()->toDateString();
        $timeAttend = $request->timeAttend;
        $datetime = Carbon::create($now. ' '.$timeAttend);
        $insertDate = Carbon::create($request->date);
        $checkAttend = Attendance::where('date', 'LIKE', '%' . $now . '%')->where('userID',$request->userID)->get();

        if($data == true){
            if($insertDate->hour<$datetime->hour || ($insertDate->hour==$datetime->hour && $insertDate->minute<=$datetime->minute + 15)){ // diem danh truoc khi ket thuc diem danh hoac sau khi do 15p
                $attendance = new Attendance();
                $attendance->userID = $request->userID;
                $attendance->date =  $request->date;
                // $attendance->save();
                if($checkAttend->count()>0){
                    $newTime = Carbon::create($now. ' 12:00:00');
                    if($data->positionID == 6 && $checkAttend->count()<2 && ($insertDate->hour > $newTime->hour|| ($insertDate->hour ==  $newTime->hour && $insertDate->minute > $datetime->minute + 10 ))){ // diem danh lan 2 doi voi part time staff (position =6) và thgian phai truoc thoi gian diem danh (bat buoc sau 12h)
                        if(Carbon::create($checkAttend[0]->date)->hour != $insertDate->hour){ // thoi gian diem danh khong duoc trung voi thoi gian diem danh cua ca1
                            $result = true;
                        }else{
                            $result = false;
                        }
                        
                    }else{
                        $result = false;
                    }
                }else{
                    $result = true;
                }
                if($result == true){
                    $attendance->save();
                    return response()->json(['success' => true, 'code' => '200', 'data' => $result]);
                }else{
                    return response()->json(['success' => false, 'code' => '404', 'data' => 'You have alredy had attendance('.$checkAttend->count().')']);
                }
            }else{
                return response()->json(['success' => false, 'code' => '404']);
            }
          }else{
            return response()->json(['success' => false, 'code' => '404']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = Attendance::find((integer)$id);
        return response()->json(['success' => true, 'code' => '200', 'data' => $position]);
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
    public function update(Request $request, Attendance $attendance)
    {
        //
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

    public function updateSalary($month,$year,$userID,$hour)
    {
        $user = User::find((integer)$userID);
        $checkSalary = $user->getSalary->where('month', $month)->where('year','=',$year);
        $spec = $user->specificSalary->where('note',1)->first();
        $ksalary = $spec->kindOfSalaryID;
        $price = $spec->kindOfSalary;
        // $totalDate = $user->attend;
        $totalDate = Attendance::where('userID','=',$userID)->whereMonth('date','=',$month)->whereYear('date','=',$year)->get()->count();

        if($checkSalary->count()>0){
            $salary = Salary::find($checkSalary->first()->id);
            $salary->totalDate = $totalDate;
            $salary->total = $totalDate*$hour*$price->coeficient*$price->salary;
            //$salary->save();
            $data=$salary;
        }else{
            $newSalary = new Salary();
            $newSalary->kindOfSalaryID = $ksalary;
            $newSalary->totalDate = $totalDate;
            $newSalary->bonus = 0;
            $newSalary->deduction = 0;
            $newSalary->total = $totalDate*$hour*$price->coeficient*$price->salary;
            $newSalary->month = $month;
            $newSalary->year = $year;
            $newSalary->note = '';
            //$newSalary->save();
            $data = $newSalary;
        }
        return response()->json(['success' => false, 'code' => '200', 'data' => $data]);
    }
}