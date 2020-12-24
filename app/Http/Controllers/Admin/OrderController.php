<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderTb;

class OrderController extends Controller
{
    public function today()
    {
    	$collection = OrderTb::count();
    	$foods = OrderTb::all();
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection]);
    }
    public function allorder()
    {
    	$collection = OrderTb::count();
    	$foods = OrderTb::all();
    	
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection]);
    }
    public function success()
    {
    	$collection = OrderTb::count();
    	$foods = OrderTb::all();
    	
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection]);
    }
    public function dahuy()
    {
    	dd(1);
    	return view('admin.order.success');
    }

}
