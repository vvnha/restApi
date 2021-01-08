<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Model\OrderTb;

class AdminController extends Controller
{
    public function index()
    {
    	$dateInput =  date('Y-m-d');
    	$timeInput = date('H:i:s');
 
    	//$order = OrderTb::where('orderDate', 'LIKE', '%' . $dateInput . '%')->get();
    	$order = OrderTb::where('orderDate', 'LIKE', '%' . '2021-01-07' . '%')->get();

    	if ($order == true) {
    	  $result = array();
	      foreach ($order as $items) {
	        if ($items->service == '0' || $items->service == '1') {
	        	$result1 = explode( ',', $items->perNum );
	        	$result = array_merge($result, $result1);	        	
	        }
	      }
	     return view('admin.index',['sb'=>$result]);
	   
	    }
    	$sb = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
        //return view('admin.index',['sb'=>$result]);
    }

}
