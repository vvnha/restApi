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

    	//$order = OrderTb::where('orderDate', 'LIKE', '%' . $dateInput . '%')->get();
    	$order = OrderTb::where('orderDate', 'LIKE', '%' . '2021-01-07' . '%')->get();
    	if (count($order) > 0) {
    	   $result = array();
	       foreach ($order as $items) {
    	        if ($items->service == '0' || $items->service == '1') {
    	        	$result1 = explode( ',', $items->perNum );
                    $counts = count($result1);
                    $i=0;
                    for ($i; $i < $counts; $i++) { 
                        $d = $result1[$i]. "," . $items->orderID . "," . $items->orderDate;
                        $t = explode( '//', $d);
                        $result = array_merge($result, $t);
                    }      	
    	        }
	        }
	       return view('admin.index',['sb'=>$result,'datas'=>"1"]);
	    }else {
           $sb = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
           return view('admin.index',['sb'=>$sb]);
        }
    }
    public function searchOrder(Request $request)
    {
        $dateInput =  date('Y-m-d');
 
        //$order = OrderTb::where('orderDate', 'LIKE', '%' . $dateInput . '%')->get();
        $order = OrderTb::where('orderDate', 'LIKE', '%' . '2021-01-07' . '%')->get();
        if (count($order) > 0) {
           $result = array();
           foreach ($order as $items) {
                if ($items->service == '0' || $items->service == '1') {
                    $result1 = explode( ',', $items->perNum );
                    $counts = count($result1);
                    $i=0;
                    for ($i; $i < $counts; $i++) { 
                        $d = $result1[$i]. "," . $items->orderID . "," . $items->orderDate;
                        $t = explode( '//', $d);
                        $result = array_merge($result, $t);
                    }       
                }
            }
           return view('admin.index',['sb'=>$result,'datas'=>"1"]);
        }else {
           $sb = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
           return view('admin.index',['sb'=>$sb]);
        }
    }

}
