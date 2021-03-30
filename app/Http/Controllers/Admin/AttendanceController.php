<?php

namespace App\Http\Controllers\Admin;

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
            'date' => 'required',
            'timeAttend' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = User::find((integer)$request->userID);
        $time = Carbon::now();
        $now = Carbon::now()->toDateString();
        $timeAttend = $request->timeAttend;
        $datetime = Carbon::create($now. ' '.$timeAttend);
        $insertDate = Carbon::create($request->date);
        $checkAttend = Attendance::where('userID',$data->id)->whereYear('date',$insertDate->year)->whereMonth('date',$insertDate->month)->whereDay('date',$insertDate->day)->get();
        $spec = $data->specificSalary->where('note',1)->first()->kindOfSalary;
        $hour = $spec->hour;
        $price = $spec->price;

        if($data == true){
            if($insertDate->hour<$datetime->hour || ($insertDate->hour==$datetime->hour && $insertDate->minute<=$datetime->minute + 15)){ // diem danh truoc khi ket thuc diem danh hoac sau khi do 15p
                $attendance = new Attendance();
                $attendance->userID = $request->userID;
                $attendance->hour = $hour; 
                $attendance->date =  $request->date;
                $attendance->bonus =  0;
                $attendance->deduction =  0;
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
                    $this->updateSalary($insertDate->month,$insertDate->year,$request->userID);
                    return response()->json(['success' => true, 'code' => '200', 'data' => $result]);
                }else{
                    return response()->json([
                        'error'    => true,
                        'messages' => 'You have alredy had attendance('.$checkAttend->count().')',
                    ], 422);
                }
            }else{
                return response()->json([
                    'error'    => true,
                    'messages' => "The time is over.",
                ], 422);
            }
          }else{
            return response()->json([
                'error'    => true,
                'messages' => '404',
            ], 422);
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