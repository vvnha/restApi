<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Gate;
use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CommentController extends Controller
{
  public function index(Request $request){
    $cmt= Comment::all();
    return response()->json(['success' => true, 'code' => '200', 'data' => $cmt]);
}
public function store(Request $request){
  $validator = Validator::make($request->all(), [ 
    //'userID' => 'required', 
    //'userName' => 'required', 
    'mess'=> 'required',
    'foodID'=> 'required'
  ]);
  if ($validator->fails()) { 
      return response()->json(['error'=>$validator->errors()], 401);            
  }
  //date('Y-m-d H:i:s')
  $cmt = new Comment();
  
  $cmt->userID=Auth::user()->id;
  $cmt->userName =Auth::user()->name;
  $cmt->mess =$request->mess;
  $cmt->time =$request->time;
  $cmt->foodID=$request->foodID;
  $cmt->save();
  return response()->json(['success' => true, 'code' => 201]);
}

public function show(Request $request, $id){
    $data= Comment::find((integer)$id);
    if($data==true){
      return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
}
public function update(Request $request, $id){
  $cmt= Comment::find((integer)$id);
    
    // $cmt->userID=$request->userID;
    // $cmt->userName =$request->userName;
    // $cmt->mess =$request->mess;
    // $cmt->time =$request->time;
    // $cmt->foodID=$request->foodID;

    if($cmt == true){
      $cmt->fill($request->all());
      $validator = Validator::make(json_decode($cmt,TRUE), [ 
        //'userID' => 'required', 
        'userName' => 'required', 
        'mess'=> 'required',
        'foodID'=> 'required'
      ]);
      if ($validator->fails()) { 
          return response()->json(['error'=>$validator->errors()], 401);            
      }
      if (Gate::allows('admin-user', $cmt->userID)) {
        $cmt->save();
        return response()->json(['success' => true, 'code' => '200']);
      } else {
        return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
      }
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
    

    // $cmt->save();
    // return response()->json(['success' => true, 'code' => 200]);
}
  public function destroy(Request $request, $id){
      $cmt= Comment::find((integer)$id);
      //$def = $cmt->delete();
      if($cmt == true){
        if (Gate::allows('admin-user', $cmt->userID)) {
          $def = $cmt->delete();
          return response()->json(['success' => true, 'code' => '200']);
        }else{
          return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
        }
      }else{
        return response()->json(['success' => false, 'code' => '404']);
      }
  }
}
