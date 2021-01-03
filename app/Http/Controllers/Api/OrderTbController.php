<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Gate;
use App\Model\OrderTb;
use App\Model\Foods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Carbon\Carbon;
use Dotenv\Regex\Result;

class OrderTbController extends Controller
{
  public function index(Request $request)
  {
    $data = OrderTb::all();
    return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
  }
  public function store(Request $request)
  {
    //date('Y-m-d H:i:s')

    $validator = Validator::make($request->all(), [
      //'userID' => 'required', 
      'total' => 'required',
      'orderDate' => 'required',
      'perNum' => 'required',
      'dateClick' => 'required'
    ]);
    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()], 401);
    }
    $orderTable = new OrderTb();

    $orderTable->userID = Auth::user()->id;
    $orderTable->total = $request->total;
    $orderTable->orderDate = $request->orderDate;
    $orderTable->perNum = $request->perNum;
    $orderTable->service = $request->service;
    $orderTable->dateClick = $request->dateClick;

    $orderTable->save();
    return response()->json(['success' => true, 'code' => 201]);
  }

  public function show(Request $request, $id)
  {
    $data = OrderTb::find((int)$id);
    if ($data == true) {
      return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
    } else {
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
  public function update(Request $request, $id)
  {
    $orderTable = OrderTb::find((int)$id);

    //$userEdit = Auth::user();
    // $orderTable->userID=$request->userID;
    // $orderTable->total =$request->total;
    // $orderTable->orderDate =$request->orderDate;
    // $orderTable->perNum =$request->perNum;
    // $orderTable->service =$request->service;
    // $orderTable->dateClick =$request->dateClick;
    //echo $orderTable;

    if ($orderTable == true) {
      $orderTable->fill($request->all());
      $validator = Validator::make(json_decode($orderTable, TRUE), [
        'total' => 'required',
        'orderDate' => 'required',
        'perNum' => 'required'
      ]);
      if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 401);
      }
      if (Gate::allows('admin-user', $orderTable->userID)) {
        $orderTable->save();
        return response()->json(['success' => true, 'code' => '200']);
      } else {
        return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
      }
    } else {
      return response()->json(['success' => false, 'code' => '404']);
    }

    // $orderTable->save();

    // return response()->json(['success' => true, 'code' => 200]);
  }
  public function destroy(Request $request, $id)
  {
    $data = OrderTb::find((int)$id);
    $userEdit = Auth::user();
    // $def = $data->delete();
    // if($def == true){
    //   return response()->json(['success' => true, 'code' => '200']);
    // }else{
    //   return response()->json(['success' => true, 'code' => '400']);
    // }

    if ($data == true) {
      if (Gate::allows('admin-user', $data->userID)) {
        $def = $data->delete();
        return response()->json(['success' => true, 'code' => '200']);
      } else return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
    } else return response()->json(['success' => false, 'code' => '404']);
  }
  public function getParentUser(Request $request, $id)
  {
    $data = OrderTb::find((int)$id);
    if ($data == true) {
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->user]);
    } else {
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
  public function search(Request $request)
  {
    $dateInput = $request->input('date');
    $timeInput = $request->input('time');
    $year = date("Y", strtotime($dateInput));
    $month = date("m", strtotime($dateInput));
    $day = date("d", strtotime($dateInput));
    $hour = date("H", strtotime($timeInput));
    $minute = date("i", strtotime($timeInput));
    $second = date("s", strtotime($timeInput));
    $datetime = Carbon::create($year, $month, $day, $hour, $minute, $second);

    $order = OrderTb::where('orderDate', 'LIKE', '%' . $dateInput . '%')->get();
    if ($order == true) {

      $result = "";
      foreach ($order as $items) {
        $itemOrderDate = Carbon::create($items->orderDate);
        if ($datetime->diffInHours($itemOrderDate) <= 2) {
          //$result = array_push($result, $items->);
          //$result = $items->perNum + "," + $result;
          $result =  $items->perNum . "," . $result;
        }
      }
      return response()->json(['success' => true, 'code' => '200', 'data' => substr($result, -1)]);
    } else {
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
  public function getChildDetail(Request $request, $id)
  {
    $data = OrderTb::find((int)$id);
    // foreach($data->detail as $food){
    //   $name = Foods::find((integer)$food->foodID)->foodName;
    //   $food ->foodName = $name;
    // }
    // if($data==true){
    //   return response()->json(['success' => true, 'code' => '200', 'data' => $data->detail]);
    // }else{
    //   return response()->json(['success' => false, 'code' => '404']);
    // }
    if (Gate::allows('admin-user', $data->userID)) {
      if ($data == true) {
        foreach ($data->detail as $food) {
          $name = Foods::find((int)$food->foodID)->foodName;
          $food->foodName = $name;
        }
        return response()->json(['success' => true, 'code' => '200', 'data' => $data->detail]);
      } else {
        return response()->json(['success' => true, 'code' => '400']);
      }
    } else {
      return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
    }
  }
}