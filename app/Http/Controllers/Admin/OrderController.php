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
    	$foods = OrderTb::where('service', '0')->get();
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Chưa xác nhận']);
    }

    public function xacnhan()
    {
    	$collection = OrderTb::count();
    	$foods = OrderTb::where('service', '1')->get();
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Đã xác nhận']);
    }

    public function success()
    {
    	$collection = OrderTb::count();
    	$foods = OrderTb::where('service', '2')->get();
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Đã hoàn thành']);
    }

    public function allorder()
    {
    	$collection = OrderTb::count();
    	$foods = OrderTb::all();
    	return view('admin.order.orders',['foods'=>$foods,'collection'=>$collection]);
    }
   
    public function dahuy()
    {
    	$collection = OrderTb::count();
    	$foods = OrderTb::where('service', '3')->get();
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Đã hủy']);
    }

}
