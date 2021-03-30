<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\SpecficSalary;
use App\Model\KindOfSalary;
use DB;
use Validator;

class UserController extends Controller
{
	public function thongke()
	{
		$collection = User::count(); //all
		$accounts = User::where('positionID', '=', 2)->get(); //manage
		$manage =count($accounts);
		$accounts = User::where('positionID', '=', 3)->get(); //user
		$use = count($accounts);
		$accounts = User::where('positionID', '=', 4)->orWhere('positionID', '=', 6)->get(); //staff
		$staff = count($accounts);
        $ksalary = KindOfSalary::all();
		return $data = (['all'=>$collection,'manage'=>$manage,'use'=>$use,'staff'=>$staff, 'ksalary'=>$ksalary]);
	}
	
    public function account1()
    {
    	$tk = $this->thongke();
    	extract($tk);
    	$accounts = User::orderBy('id', 'ASC')->whereIn('positionID', [1,2,4,6])->paginate(8);
        return view('admin.users.index',['accounts'=>$accounts,'all'=>$all,'manage'=>$manage,'use'=>$use,'staff'=>$staff, 'ksalary'=>$ksalary]);
    }

    public function blocks()
    {
        $tk = $this->thongke();
        extract($tk);
        $accounts = User::where('positionID', '=', 5)->paginate(8);
        return view('admin.users.index',['accounts'=>$accounts,'all'=>$all,'manage'=>$manage,'use'=>$use,'staff'=>$staff, 'ksalary'=>$ksalary]);
    }


    public function allusers()
    {	
    	$tk = $this->thongke();
    	extract($tk);
    	$accounts = User::orderBy('id', 'ASC')->paginate(8);
    	$collection = User::count();
        return view('admin.users.allusers',['accounts'=>$accounts,'all'=>$all,'manage'=>$manage,'use'=>$use,'staff'=>$staff, 'ksalary'=>$ksalary]);
    }
    public function position(Request $request)
    {
        $user = User::find($request->id);
        $validator = Validator::make($request->all(), [ 
              'id' => 'required|integer', 
              'positionID' => 'required'
            ]);
            if ($validator->fails()) { 
                return redirect()->back();        
        }
        $ps = $request->positionID;
        if($ps == 4 || $ps == 6){
            $checkSpec = SpecficSalary::where('userID',$request->id)->where('note',1)->count();
            if($checkSpec < 1 || $user->positionID != $ps){
                $spec = new SpecficSalary();
                $spec->userID = $request->id;
                if($ps == 4){
                    $spec->kindOfSalaryID = 1;
                }else{
                    $spec->kindOfSalaryID = 2;
                }
                $spec->note = 1;
                if( $user->positionID != $ps){
                    $checkSpec = SpecficSalary::where('userID',$request->id)->where('note',1)->update(['note' => 0]);
                }
                $spec->save();
            }
        }else{
            $checkSpec = SpecficSalary::where('userID',$request->id)->where('note',1)->get();
            // dd($checkSpec);
            if(count($checkSpec) >= 1){
                $checkSpec = SpecficSalary::where('userID',$request->id)->where('note',1)->update(['note' => 0]);
            }
        }
        $ldate = date('Y-m-d H:i:s');
        $user->positionID = $request->positionID;
        $user->updated_at = $ldate;
        $user->save();
        return redirect()->back();
    }

    public function block($id)
    {
        $ldate = date('Y-m-d H:i:s');
        $user = User::find($id);
        $user->positionID = 5;
        $user->updated_at = $ldate;
        $user->save();
        return redirect()->back();
    }

    public function account()
    {

        $tk = $this->thongke();
        extract($tk);
        $accounts = User::orderBy('id', 'ASC')->whereIn('positionID', [1,2,4,6])->paginate(8);

        foreach($accounts as $value ){
            if($value->positionID == 4 || $value->positionID==6){
                //$result = SpecficSalary::where('userID',$value->id)->get();
                //$value->ksalary = $result[0]['kindOfSalaryID'];
                $value->ksalary =$value->specificSalary->where('note',1)->first()->kindOfSalaryID;
            }
            
        }
        return view('admin.users.index',['accounts'=>$accounts,'all'=>$all,'manage'=>$manage,'use'=>$use,'staff'=>$staff, 'ksalary'=>$ksalary]);
    }
    public function searchuser(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
              'gmail' => 'required'
            ]);
            if ($validator->fails()) { 
                return redirect()->back();        
        }
        $users = User::where('email', 'LIKE' ,'%'.$request->gmail.'%')->paginate(8);
        $tk = $this->thongke();
    	extract($tk);
    	//$accounts = User::orderBy('id', 'ASC')->paginate(8);
        $collection = User::count();
        return view('admin.users.allusers',['accounts'=>$users,'all'=>$all,'manage'=>$manage,'use'=>$use,'staff'=>$staff, 'ksalary'=>$ksalary]);
        //return redirect()->back();
    }

    public function changetype(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
              'id' => 'required|integer', 
              'type' => 'required'
            ]);
            if ($validator->fails()) { 
                return redirect()->back();        
        }

        SpecficSalary::where('userID',$request->id)
        ->update(['kindOfSalaryID' => $request->type]);
        return redirect()->back();
    }

}