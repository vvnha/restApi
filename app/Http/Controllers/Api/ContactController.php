<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Gate;
use App\Model\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;

class ContactController extends Controller
{
  public function index(Request $request){
    $contact= Contact::all();
    return response()->json(['success' => true, 'code' => '200', 'data' => $contact]);
  }
  public function store(Request $request){
    $validator = Validator::make($request->all(), [ 
      //'userID' => 'required', 
      'mess' => 'required'
    ]);
    if ($validator->fails()) { 
        return response()->json(['error'=>$validator->errors()], 401);            
    }
      //date('Y-m-d H:i:s')
      $contact = new Contact();
      
      $contact->userID=Auth::user()->id;
      $contact->mess =$request->mess;
      $contact->time =$request->time;

      $contact->save();
      return response()->json(['success' => true, 'code' => 201]);
  }

  public function show(Request $request, $id){
      $data= Contact::find((integer)$id);
      if($data==true){
        return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
      }else{
        return response()->json(['success' => false, 'code' => '404']);
      }
  }
  public function update(Request $request, $id){
    $contact= Contact::find((integer)$id);
    
    // $contact->userID=$request->userID;
    // $contact->mess =$request->mess;
    // $contact->time =$request->time;
    if($contact==true){
      $contact->fill($request->all());
      $validator = Validator::make(json_decode($contact,TRUE), [ 
        //'userID' => 'required', 
        'mess' => 'required'
      ]);
      if ($validator->fails()) { 
          return response()->json(['error'=>$validator->errors()], 401);            
      }
      if (Gate::allows('admin-user', $contact->userID)) {
        $contact->save();
        return response()->json(['success' => true, 'code' => '200']);
      } else {
        return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
      }
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }

    // $contact->save();
    // return response()->json(['success' => true, 'code' => 200]);
  }
  public function destroy(Request $request, $id){
    $contact= Contact::find((integer)$id);
    if($contact==true){
      if (Gate::allows('admin')) {
        $def = $contact->delete();
        return response()->json(['success' => true, 'code' => '200']);
      }else{
        return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
      }
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
  public function getParentUser(Request $request, $id){
    $data = Contact::find((integer)$id);
    if($data==true){
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->user]);
    }else{
      return response()->json(['success' => false, 'code' => '404']);
  }
}

}
