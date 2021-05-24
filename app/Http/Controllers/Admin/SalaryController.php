<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Attendance;
use App\Model\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class SalaryController extends Controller
{
    public function index()
    {
        $data = Salary::orderBy('id', 'DESC')->paginate(8);
        $collection = Salary::count();
        foreach($data as $value){
            $value->userName = $value->specficSalary->user->name;
        }
        return view('admin.wage.index',['data'=>$data,'collection'=>$collection]);
    }
    public function store(Request $request)
    {
        //$now = Carbon::now();
        $validator = Validator::make($request->all(), [ 
            'email' => 'required', 
            'month' => 'required',
            'year' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $user = User::where('email',$request->email)->get()->first();
        if($user==true){
            if($user->positionID == 4 || $user->positionID == 6 ){
                if($user->positionID == 6)return $this->checkSalary($request->month, $request->year,$user->id,4,$request->bonus, $request->deduction, $request->note); 
                else return $this->checkSalary($request->month, $request->year,$user->id,8,$request->bonus, $request->deduction, $request->note);
            }else{
                return response()->json([
                    'error' => ['it is not a staff account']
                ], 404);
            }
            
        }else{
            return response()->json([
                'error' => true,
                'data'  => '401',
            ], 404);
        }
        
    }
    public function show(Request $request, $id)
    {
        $salary = Salary::find((integer)$id);
        $spec = $salary->specficSalary;
        $user = $salary->specficSalary->user;
        $attend = Attendance::orderBy('id', 'DESC')->where('userID',$spec->userID)->whereYear('date',$salary->year)->whereMonth('date',$salary->month)->paginate(8);
        $collection = $attend->count();
        foreach($attend as $value){
            $value->userName = $value->user->name;
        }
        return view('admin.wage.detail',['data'=>$attend,'collection'=>$collection,'user'=>$user, 'salary' =>$salary ]);
    }
    // public function update(Request $request, $id)
    // {
    //     $salary = Salary::find((integer)$id);
    //     $salary->note = $request->note;
    //     $salary->save();
    //     return response()->json([
    //         'error' => false,
    //         'task'  => $salary,
    //     ], 200);
    // }
    public function checkSalary($month,$year,$userID,$hour, $bonus, $deduction, $note)
    {
        $user = User::find((integer)$userID);
        $checkSalary = $user->getSalary->where('month', $month)->where('year','=',$year);
        $spec = $user->specificSalary->where('note',1)->first();
        $ksalary = $spec->kindOfSalaryID;
        $price = $spec->kindOfSalary;
        // $totalDate = $user->attend;
        $totalDate = Attendance::where('userID','=',$userID)->whereMonth('date','=',$month)->whereYear('date','=',$year)->get();
        $bonus = $totalDate->sum('bonus');
        $deduction = $totalDate->sum('deduction');
        $totalTime = $totalDate->sum('hour');

        if($checkSalary->count()>0){
            // $salary = Salary::find($checkSalary->first()->id);
            // $salary->totalDate = $totalDate;
            // $newSalary->total = $totalDate*$hour*$price->coeficient*$price->salary+$bonus-$deduction;
            //$salary->save();
            $data=false;
        }else{
            $newSalary = new Salary();
            $newSalary->specificSalaryID = $spec->id;
            $newSalary->totalDate = $totalDate->count();
            $newSalary->bonus = $bonus;
            $newSalary->deduction = $deduction;
            $newSalary->total = $totalTime*$hour*$price->coeficient*$price->salary+$bonus-$deduction;
            $newSalary->month = $month;
            $newSalary->year = $year;
            $newSalary->note = $note;
            $newSalary->save();
            $data = true;
        }
        if($data == true){
            return response()->json([
                'error' => false,
                'data'  => $data,
            ], 200);
        }else{
            return response()->json([
                'error' => ['Tai khoan nay da co luong']
            ], 404);
        }
    }
    public function updateSalary($month,$year,$salaryID,$hour, $bonus, $deduction, $note)
    {
        $salary = Salary::find($salaryID);
        $userID = $salary->specificSalary;
        // $totalDate = Attendance::where('userID','=',$userID)->whereMonth('date','=',$month)->whereYear('date','=',$year)->get()->count();
        // $salary->totalDate = $totalDate;
        // $newSalary->total = $totalDate*$hour*$price->coeficient*$price->salary+$bonus-$deduction;
        // //$salary->save();
        $data = $userID;

        if($salary == true){
            return response()->json([
                'error' => false,
                'data'  => $data,
            ], 200);
        }else{
            return response()->json([
                'error' => ['Tai khoan nay da co luong']
            ], 404);
        }
    }

    public function editSalary(Request $request)
    {
        $id = $request->id;
        $salary = Salary::find((integer)$id);
        $salary->note = $request->note;
        $salary->save();
        return redirect()->back();
    }
    public function getSalary(Request $request, $id)
    {
        $salary = Salary::find((integer)$id);
        return response()->json([
            'error' => false,
            'data'  => $salary
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $data = Salary::destroy($id);
        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
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
        $data = $user->getSalary;
        $collection = $data->count();
        return view('admin.wage.index',['data'=>$data,'collection'=>$collection]);
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


        $data = Salary::where('month',$date->month)->where('year',$date->year)->paginate(8);
        // $data = $user->getSalary;
        $collection = $data->count();
        foreach($data as $value){
            $value->userName = $value->specficSalary->user->name;
        }
        return view('admin.wage.index',['data'=>$data,'collection'=>$collection]);
    }
}