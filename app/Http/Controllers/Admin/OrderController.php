<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderTb;
use App\Model\OrderDetail;
use App\Model\Foods;
use App\User;
use Validator;
use Auth;


class OrderController extends Controller
{

    public function thongke()
    {
        $collection = OrderTb::count();
        $cxn = OrderTb::where('service', '0')->get();
        $chuaxacnhan =count($cxn);
        $dxn = OrderTb::where('service', '1')->get();
        $daxacnhan = count($dxn);
        $ht = OrderTb::where('service', '2')->get();
        $hoanthanh = count($ht);
        return $data = (['collection'=>$collection,'chuaxacnhan'=>$chuaxacnhan,'daxacnhan'=>$daxacnhan,'hoanthanh'=>$hoanthanh]);
    }


    public function today()
    {
        $tk = $this->thongke();
        extract($tk);
    	$foods = OrderTb::where('service', '0')->paginate(8);
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Chưa xác nhận','chuaxacnhan'=>$chuaxacnhan,'daxacnhan'=>$daxacnhan,'hoanthanh'=>$hoanthanh]);
    }

    public function allorder()
    {
        $tk = $this->thongke();
        extract($tk);
        $ldate = date('Y-m-d');
        $order = OrderTb::orderBy('orderID', 'DESC')->whereIn('service', [0,1,2,3])->paginate(8);
        return view('admin.order.allorder',['foods'=>$order,'collection'=>$collection,'xacnhan'=>'all','chuaxacnhan'=>$chuaxacnhan,'daxacnhan'=>$daxacnhan,'hoanthanh'=>$hoanthanh]);
    }

      public function dayorder()
    {
        $tk = $this->thongke();
        extract($tk);
        $ldate = date('Y-m-d');
        $order = OrderTb::where('orderDate', 'LIKE', '%' . $ldate . '%')->paginate(8);
        return view('admin.order.allorder',['foods'=>$order,'collection'=>$collection,'xacnhan'=>'day','chuaxacnhan'=>$chuaxacnhan,'daxacnhan'=>$daxacnhan,'hoanthanh'=>$hoanthanh]);
    }

    public function xacnhan()
    {
        $tk = $this->thongke();
        extract($tk);
    	$foods = OrderTb::where('service', '1')->paginate(8);
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Đã xác nhận','chuaxacnhan'=>$chuaxacnhan,'daxacnhan'=>$daxacnhan,'hoanthanh'=>$hoanthanh]);
    }

    public function success()
    {
        $tk = $this->thongke();
        extract($tk);
    	$foods = OrderTb::where('service', '2')->paginate(8);
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Đã hoàn thành','chuaxacnhan'=>$chuaxacnhan,'daxacnhan'=>$daxacnhan,'hoanthanh'=>$hoanthanh]);
    }
   
    public function dahuy()
    {
        $tk = $this->thongke();
        extract($tk);
    	$foods = OrderTb::where('service', '3')->paginate(8);
    	return view('admin.order.order',['foods'=>$foods,'collection'=>$collection,'xacnhan'=>'Đã hủy','chuaxacnhan'=>$chuaxacnhan,'daxacnhan'=>$daxacnhan,'hoanthanh'=>$hoanthanh]);
    }
    public function vieworder($id)
    {
        $data = OrderTb::find((int)$id);
        $Namefood =Foods::all();
        $iduser = $data->userID;
        $user = User::find($iduser);
        $timeorder = $data->orderDate;
        $time = $data->dateClick;
        $total = $data->total;
        $service = $data->service;
       $perNum =$data->perNum;
        if ($data == true) {
            foreach ($data->detail as $food) {
              $name = Foods::find((int)$food->foodID)->foodName;
              $food->foodName = $name;
            }
        }
        return view('admin.order.vieworder',['foods'=>$data->detail,'userss'=>$user,'stt'=> 0,'giodat'=>$time,'datngay'=>$timeorder,'total'=>$total,'service'=>$service,'id'=>$id, 'Namefood'=>$Namefood,'perNum'=>$perNum]);
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

    public function deleteorder($id)
    {
        $ldate = date('Y-m-d H:i:s');
        $data = OrderTb::find((int)$id);
        $data->service="3";
        $data->updated_at = $ldate;
        $data->save();
        return redirect()->back();
    }

    public function thanhtoan(Request $request )
    {   
        $ldate = date('Y-m-d H:i:s');
        $data = OrderTb::find((int)$request->id);
        $data->service=$request->service;
        $data->total=$request->tongtien;
        $data->updated_at = $ldate;
        $data->save();
        return redirect()->back()->with('success', 'Đã thanh toán thành công!');
    }
// SELECT `orderID`, `userID`, `total`, `orderDate`, `perNum`, `service`, `dateClick`, `created_at`, `updated_at` FROM `ordertables` WHERE 1
    public function addfood(Request $request)
    {
         $validator = Validator::make($request->input(), array(
            'foodName' => 'required',
            'soluong' => 'required',
            'id' => 'required',
        ));
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }
            $food = new OrderDetail();
            $food->orderID=$request->id;
            $food->foodID = $request->foodName;
            $food->qty = $request->soluong;
            $prices = Foods::find((int)$food->foodID)->price;
            $food->price = $prices;
            $food->save();
        return response()->json([
            'error' => false,
            'food'  => $food,
        ], 200);
    }

    public function show($id)
    {
        $food = OrderDetail::find($id);
        $name = Foods::find((int)$food->foodID)->foodName;
        return response()->json([
            'error' => false,
            'task'  => $food,
            'namefood' =>$name
        ], 200);
    }

    public function destroy($id)
    {
        $task = OrderDetail::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'task' => 'required',
            'soluong' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $task = OrderDetail::find($id);
        $task->qty = $request->input('soluong');
        $task->save();
        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    
    public function hoadon($id)
    {
        $data = OrderTb::find((int)$id);
        $iduser = $data->userID;
        $user = User::find($iduser);
        $perNum =$data->perNum;
        if ($data == true) {
            foreach ($data->detail as $food) {
              $name = Foods::find((int)$food->foodID)->foodName;
              $food->foodName = $name;
            }
        }
        $date = date('Y-m-d H:i:s');
        $nameA = Auth::user()->name;
        return view('admin.order.hoadon',['foods'=>$data->detail,'userss'=>$user,'id'=>$id,'stt'=> 1,'tongsotien'=>0,'date'=>$date,'perNum'=>$perNum,'nameA'=>$nameA]);
    }


}
