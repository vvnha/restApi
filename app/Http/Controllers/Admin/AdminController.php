<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Model\OrderTb;
use DB;
use App\Model\Contact;

class AdminController extends Controller
{
    public function index()
    {
    	$dateInput =  date('Y-m-d');

    	$order = OrderTb::where('orderDate', 'LIKE', '%' . $dateInput . '%')->get();
    	// $order = OrderTb::where('orderDate', 'LIKE', '%' . '2021-01-07' . '%')->get();

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
    	        }else{
                    $sb = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
                    return view('admin.index',['sb'=>$sb, 'datas'=>"0",'dateS'=> $dateInput]);   
                }
	        }
	       return view('admin.index',['sb'=>$result,'datas'=>"1",'dateS'=> $dateInput]);
	    }else {
           $sb = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
           return view('admin.index',['sb'=>$sb, 'datas'=>"0",'dateS'=> $dateInput]);
        }
    }
    public function seachOrder(Request $request)
    {
        $dateInput =  $request->dateS;
        $order = OrderTb::where('orderDate', 'LIKE', '%' . $dateInput . '%')->get();
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
                }else{
                    $sb = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
                    return view('admin.index',['sb'=>$sb, 'datas'=>"0",'dateS'=> $dateInput]);   
                }
            }
            return view('admin.index',['sb'=>$result,'datas'=>"1",'dateS'=> $dateInput]);
        }else {
           $sb = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
           return view('admin.index',['sb'=>$sb, 'datas'=>"0",'dateS'=> $dateInput]);
        }
    }

    public function phanhoi()
    {
        $contacts = Contact::orderBy('contactID', 'DESC')->paginate(8);
        return view('admin.ghichu',compact('contacts'));
    }


    public function week()
    {
        $range = Carbon::now()->subDays(7);
        $stats = OrderTb::where('service', 2)
          ->where('orderDate', '>=', $range)
          ->groupBy('date')
          ->orderBy('date', 'ASC')
          ->get([DB::raw('Date(orderDate) as date'),
            DB::raw('sum(total) as sums')
          ])->all();
        $counts = count($stats);
        for ($i=0; $i< $counts; $i++) {
            $cl[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }
    
        for ($i=0; $i<$counts ; $i++) { 
           $lb[] = $stats[$i]->date;
           $dt[] = $stats[$i]->sums;
        }
        if ($counts==0) {
          return view('admin.chart.nochart');
        }
        return view('admin.chart.week',compact('lb','cl','dt'));
    }
    #chart
   
    public function year()
    {
        $range = Carbon::now()->subDays(30);
        $stats = OrderTb::where('service', 2)
          ->where('updated_at', '>=', $range)
          ->groupBy('date')
          ->orderBy('date', 'ASC')
          ->get([DB::raw('Date(updated_at) as date'),
            DB::raw('sum(total) as sums')
          ])->all();

        $counts = count($stats);
        for ($i=0; $i< $counts; $i++) {
            $cl[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }
    
        for ($i=0; $i<$counts ; $i++) { 
           $lb[] = $stats[$i]->date;
           $dt[] = $stats[$i]->sums;
        }
        if ($counts==0) {
          return view('admin.chart.nochart');
        }
        
        $date1 = explode(' ',$range);
        $dateS = $date1[0];
        return view('admin.chart.year',compact('lb','cl','dt','dateS'));
    }
    public function chart(Request $request)
    {
        $dateInput =  $request->dateS;
        $stats = OrderTb::where('service', 2)
          ->where('updated_at', '>=', $dateInput)
          ->groupBy('date')
          ->orderBy('date', 'ASC')
          ->get([DB::raw('Date(updated_at) as date'),
            DB::raw('sum(total) as sums')
          ])->all();

        $counts = count($stats);
        for ($i=0; $i< $counts; $i++) {
            $cl[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }
    
        for ($i=0; $i<$counts ; $i++) { 
           $lb[] = $stats[$i]->date;
           $dt[] = $stats[$i]->sums;
        }
        if ($counts==0) {
          return view('admin.chart.nochart');
        }
        $dateS = $dateInput;
        return view('admin.chart.year',compact('lb','cl','dt','dateS'));
    }
   
}
