<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Gate;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;

class OrderDetailController extends Controller
{
  public function index(Request $request){
    $data= OrderDetail::all();
    return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
  }
  public function store(Request $request){
      //date('Y-m-d H:i:s')
      $validator = Validator::make($request->all(), [ 
        'orderID' => 'required', 
        'foodID' => 'required', 
        'qty'=> 'required',
        'price' => 'required'
      ]);
      if ($validator->fails()) { 
        return response()->json(['error'=>$validator->errors()], 401);            
      }
      $orderDetail = new OrderDetail();
      
      $orderDetail->orderID=$request->orderID;
      $orderDetail->foodID =$request->foodID;
      $orderDetail->qty =$request->qty;
      $orderDetail->price =$request->price;

      $orderDetail->save();
      return response()->json(['success' => true, 'code' => 201]);
    }

  public function show(Request $request, $id){
      $data= OrderDetail::find((integer)$id);
      if($data==true){
        return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
      }else{
        return response()->json(['success' => false, 'code' => '404']);
      }
  }
  public function update(Request $request, $id){
      $orderDetail = OrderDetail::find((integer)$id);

      // $orderDetail= OrderDetail::find((integer)$id);
      // $orderDetail->orderID=$request->orderID;
      // $orderDetail->foodID =$request->foodID;
      // $orderDetail->qty =$request->qty;
      // $orderDetail->price =$request->price;

      if($orderDetail==true){
        $orderDetail->fill($request->all());
        $userEdit = Auth::user();
        $userID = $orderDetail->order->userID;

        $validator = Validator::make(json_decode($orderDetail,TRUE), [ 
          'orderID' => 'required', 
          'foodID' => 'required', 
          'qty'=> 'required',
          'price' => 'required'
        ]);
        if ($validator->fails()) { 
          return response()->json(['error'=>$validator->errors()], 401);            
        }
        if (Gate::allows('admin-user', $userID)) {
          $orderDetail->save();
          return response()->json(['success' => true, 'code' => '200']);
        } else {
          return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
        }
      }else{
        return response()->json(['success' => false, 'code' => '404']);
      }
      

      // $orderDetail->save();
      // return response()->json(['success' => true, 'code' => 200]);
  }
  public function destroy(Request $request, $id){
    $userEdit = Auth::user();
    $data= OrderDetail::find((integer)$id);
    //  $def = $data->delete();
    // if($def == true){
    //   return response()->json(['success' => true, 'code' => '200']);
    // }else{
    //   return response()->json(['success' => true, 'code' => '400']);
    // }
    if($data == true){
      $userID = $data->order->userID;
      if (Gate::allows('admin-user', $userID)) {
        $def = $data->delete();
        return response()->json(['success' => true, 'code' => '200']);
      } else return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
    }else return response()->json(['success' => false, 'code' => '404']);
  }

  public function getParentOrder(Request $request, $id){
    $data = OrderDetail::find((integer)$id);
    if($data==true){
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->order]);
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
  }

  public function getChildFood(Request $request, $id){
    $data = OrderDetail::find((integer)$id);
    if($data==true){
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->food]);
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
}
