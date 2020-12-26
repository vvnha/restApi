<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderTb;
use App\Model\OrderDetail;
use App\Model\Foods;
use App\User;

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
    	$foods = OrderTb::where('service','>','0')->get();
    	return view('admin.order.orders',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Hiển thị tất cả các đơn đã xác nhận service 1, đã hoàn thành service 2 và đã hủy service 3']);
    }
   
    public function dahuy()
    {
    	$collection = OrderTb::count();
    	$foods = OrderTb::where('service', '3')->get();
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Đã hủy']);
    }
    public function vieworder($id)
    {
        $user = User::find($id);
        $data = OrderTb::find((int)$id);
        $timeorder = $data->orderDate;
        $time = $data->dateClick;
        $total = $data->total;
        $service = $data->service;
        if ($data == true) {
            foreach ($data->detail as $food) {
              $name = Foods::find((int)$food->foodID)->foodName;
              $food->foodName = $name;
            }
        }
        return view('admin.order.vieworder',['foods'=>$data->detail,'userss'=>$user,'stt'=> 0,'giodat'=>$time,'datngay'=>$timeorder,'total'=>$total,'service'=>$service,'id'=>$id]);
    }

    public function editservice(Request $request)
    {
        $id = $request->id;
        $ldate = date('Y-m-d H:i:s');
        $data = OrderTb::find((int)$id);
        $data->service=$request->service;
        $data->updated_at = $ldate;
        $data->save();
        return redirect()->back();

    }
}
