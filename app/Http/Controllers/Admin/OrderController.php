<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderTb;
use App\Model\EatTime;
use App\Model\OrderDetail;
use App\Model\Foods;
use App\User;
use Validator;
use Auth;
use Carbon\Carbon;


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
//         $order = OrderTb::orderBy('orderID', 'DESC')->whereIn('service', [0,1,2,3])->paginate(8);
        OrderTb::where('service', '>', '0')->delete();
        $order = OrderTb::paginate(15);
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
        $eatT = EatTime::where('orderID',$id)->first();

        if ($data == true) {
            foreach ($data->detail as $food) {
              $name = Foods::find((int)$food->foodID)->foodName;
              $food->foodName = $name;
            }
        }
        return view('admin.order.vieworder',['foods'=>$data->detail,'userss'=>$user,'stt'=> 0,'giodat'=>$time,'datngay'=>$timeorder,'total'=>$total,'service'=>$service,'id'=>$id, 'Namefood'=>$Namefood,'perNum'=>$perNum,'eatTime'=>$eatT]);
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

    public function edittimeeat(Request $request)
    {

        $id = $request->id;
        $ldate = date('Y-m-d H:i:s');
        $data = EatTime::find((int)$id);
        $data->eatTime=$request->eatTime;
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

    public function edittable($id)
    {
        $data = OrderTb::find((int)$id);
        $date = $data->orderDate;
        $timestamp = strtotime($date);
        $new_date = date("Y-m-d", $timestamp);
        $new_date1 = date("H:i:s", $timestamp);
        $new_date = $new_date ."T".$new_date1;
        return view('admin.order.edittable',['data'=>$data,'dateOrder'=>$new_date]);
    }

    public function searchtable(Request $request)
    {
        $datetime = Carbon::create($request->datetime);
        $data = OrderTb::find((int)$request->id);
        $date = $data->orderDate;
        $timestamp = strtotime($date);
        $new_date = date("Y-m-d", $timestamp);
        $new_date1 = date("H:i:s", $timestamp);
        $new_date = $new_date ."T".$new_date1;
        
        $order = OrderTb::whereYear('orderDate', $datetime->year)->whereMonth('orderDate',$datetime->month)->whereDay('orderDate',$datetime->day)->get();
        if ($order == true) {
            $result = array();
            $resultLabel = '';
            foreach ($order as $items) {
                $itemOrderDate = Carbon::create($items->orderDate);
                $eatT = EatTime::where('orderID',$items->orderID)->first();
                $timeTable = $eatT->eatTime;
                if ($datetime->diffInHours($itemOrderDate) <=$timeTable && ($items->service == '1' || $items->service == '0')) {
                    $resultLabel =  $items->perNum . "," . $resultLabel;
                // dd($items->perNum);
                //     $result = array_merge($result,$items->perNum);
                // }
                    $result1 = explode( ',', $items->perNum );
                    $counts = count($result1);
                    $i=0;
                    for ($i; $i < $counts; $i++) { 
                        $d = $result1[$i];
                        $t = explode( '//', $d);
                        $result = array_merge($result, $t);
                    }
                }
            }
        }
        if(isset($request->numberTable)){
            $numberTable = $request->numberTable;
            $newTable = explode( ',', $numberTable);
            $res = true;
            for ($i = 0; $i < count($newTable); $i++) { 
                
                if(in_array($newTable[$i],$result)){
                    
                    $res = false;
                }
            }
            if($res == false){
                $message = "Bàn vừa chọn đã được đặt, mời đặt lại!";
                return view('admin.order.edittable',['data'=>$data,'orderedLabel'=>$resultLabel, 'ordered'=>$result,'dateOrder'=> $request->datetime, 'messages'=>$message]);
            }else{
                $data->perNum = $request->numberTable;
                $message = "Đã sửa thành công!";
                $data->save();
                return view('admin.order.edittable',['data'=>$data,'orderedLabel'=>$resultLabel, 'ordered'=>$result,'dateOrder'=> $request->datetime, 'messages'=>$message]);
            }
        }
        if(isset($request->orderDate)){
            $orderD = Carbon::create($request->orderDate);
            $message = $orderD;
            $data->orderDate = $orderD;
            $data->save();
            return redirect()->back();
        }
        //dd($resultLabel);
        return view('admin.order.edittable',['data'=>$data,'orderedLabel'=>$resultLabel, 'ordered'=>$result,'dateOrder'=> $request->datetime]);
        
        // if ($result != "") {
        //     $result = substr($result, 0, -1);
        // }
        // return response()->json(['success' => true, 'code' => '200', 'data' => $result]);
        // } else {
        // return response()->json(['success' => false, 'code' => '404']);
        // }
    }

}
