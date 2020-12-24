<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
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
		$accounts = User::where('positionID', '=', 4)->get(); //staff
		$staff = count($accounts);
		return $data = (['all'=>$collection,'manage'=>$manage,'use'=>$use,'staff'=>$staff]);
	}
	
    public function account()
    {
    	$tk = $this->thongke();
    	extract($tk);
    	$accounts = User::where('positionID', '=', 2)->get();
        return view('admin.users.index',['accounts'=>$accounts,'all'=>$all,'manage'=>$manage,'use'=>$use,'staff'=>$staff]);
    }

    public function blocks()
    {
        $tk = $this->thongke();
        extract($tk);
        $accounts = User::where('positionID', '=', 5)->get();
        return view('admin.users.index',['accounts'=>$accounts,'all'=>$all,'manage'=>$manage,'use'=>$use,'staff'=>$staff]);
    }


    public function allusers()
    {	
    	$tk = $this->thongke();
    	extract($tk);
    	$accounts = User::paginate(8);
    	$collection = User::count();
        return view('admin.users.allusers',['accounts'=>$accounts,'all'=>$all,'manage'=>$manage,'use'=>$use,'staff'=>$staff]);
    }
    public function position(Request $request)
    {
         $validator = Validator::make($request->all(), [ 
              'id' => 'required|integer', 
              'positionID' => 'required'
            ]);
            if ($validator->fails()) { 
                return redirect()->back();        
          }
        DB::table('users')
                ->where('id', $request->id)
                ->update(['positionID' => $request->positionID]);
        return redirect()->back();
    }

    public function block($id)
    {
        DB::table('users')
                ->where('id', $id)
                ->update(['positionID' => 5]);
        return redirect()->back();
    }
}
