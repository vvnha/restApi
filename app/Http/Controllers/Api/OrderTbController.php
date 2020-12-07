<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Gate;
use App\Model\OrderTb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;

class OrderTbController extends Controller
{
  public function index(Request $request){
    $data= OrderTb::all();
    return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
  }
  public function store(Request $request){
      //date('Y-m-d H:i:s')

      $validator = Validator::make($request->all(), [ 
        //'userID' => 'required', 
        'total' => 'required', 
        'orderDate'=> 'required',
        'perNum' => 'required',
        'dateClick' =>'required'
    ]);
    if ($validator->fails()) { 
      return response()->json(['error'=>$validator->errors()], 401);            
    }
      $orderTable = new OrderTb();
      
      $orderTable->userID=Auth::user()->id;
      $orderTable->total =$request->total;
      $orderTable->orderDate =$request->orderDate;
      $orderTable->perNum =$request->perNum;
      $orderTable->service =$request->service;
      $orderTable->dateClick =$request->dateClick;

      $orderTable->save();
      return response()->json(['success' => true, 'code' => 201]);
    }

    public function show(Request $request, $id){
      $data= OrderTb::find((integer)$id);
      if($data==true){
        return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
      }else{
        return response()->json(['success' => false, 'code' => '404']);
      }
  }
  public function update(Request $request, $id){
    $orderTable = OrderTb::find((integer)$id);
      
      //$userEdit = Auth::user();
      // $orderTable->userID=$request->userID;
      // $orderTable->total =$request->total;
      // $orderTable->orderDate =$request->orderDate;
      // $orderTable->perNum =$request->perNum;
      // $orderTable->service =$request->service;
      // $orderTable->dateClick =$request->dateClick;
      //echo $orderTable;

      if($orderTable==true){
        $orderTable->fill($request->all());
        $validator = Validator::make(json_decode($orderTable,TRUE), [ 
          'userID' => 'required', 
          'total' => 'required', 
          'orderDate'=> 'required',
          'perNum' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        if (Gate::allows('admin-user', $orderTable->userID)) {
          $orderTable->save();
          return response()->json(['success' => true, 'code' => '200']);
        } else {
          return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
        }
      }else{
        return response()->json(['success' => false, 'code' => '404']);
      }

      // $orderTable->save();
      
      // return response()->json(['success' => true, 'code' => 200]);
  }
  public function destroy(Request $request, $id){
      $data = OrderTb::find((integer)$id);
      $userEdit = Auth::user();
      // $def = $data->delete();
      // if($def == true){
      //   return response()->json(['success' => true, 'code' => '200']);
      // }else{
      //   return response()->json(['success' => true, 'code' => '400']);
      // }

      if($data == true){
        if (Gate::allows('admin-user', $data->userID)) {
          $def = $data->delete();
          return response()->json(['success' => true, 'code' => '200']);
        } else return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
      }else return response()->json(['success' => false, 'code' => '404']);

  }
  public function getParentUser(Request $request, $id){
    $data = OrderTb::find((integer)$id);
    if($data==true){
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->user]);
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
  public function getChildDetail(Request $request, $id){
    $data = OrderTb::find((integer)$id);
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
      if($data == true){
        foreach($data->detail as $food){
          $name = Foods::find((integer)$food->foodID)->foodName;
          $food ->foodName = $name;
        }
        return response()->json(['success' => true, 'code' => '200']);
      }else{
        return response()->json(['success' => true, 'code' => '400']);
      }
    } else {
      return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
    }
  }
}
