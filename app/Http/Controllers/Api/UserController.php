<?php
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use App\User;
use App\Model\Foods;
use App\Model\SpecficSalary;
use App\Model\KindOfSalary;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
  public function index(Request $request){
    // $data = User::all();
    // return response()->json(['success' => true, 'code' => '200', 'data' => $data]);

    if (Gate::allows('see-users', 1)) {
      $data = User::all();
      return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
    } else {
      return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to see"]);
    }
  }
  public function store(Request $request){
    $validator = Validator::make($request->all(), [ 
      'name' => 'required', 
      'email' => 'required|email', 
      'phone'=> 'required',
      'password' => 'required', 
      'positionID' => 'required'
    ]);
    if ($validator->fails()) { 
        return response()->json(['error'=>$validator->errors()], 401);            
  }
    $user = new User();
    $user->name=$request->name;
    $user->email=$request->email;
    $user->phone=$request->phone;
    $user->password =bcrypt($request->password);
    $user->positionID =$request->positionID;

    echo($user);
    $user->save();

    return response()->json(['success' => true, 'code' => 201]);
  }
  public function show(Request $request, $id){
    $data = User::find((integer)$id);

     if($data==true){
       return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
     }else{
       return response()->json(['success' => false, 'code' => '404']);
     }
  }
  public function update(Request $request, $id){
    $user = Auth::user();
    $userEdit = User::find((integer)$id);
    
    // $user = User::find((integer)$id);
    // $user->name=$request->name;
    // $user->email=$request->email;
    // $user->phone =$request->phone;
    // $user->password =bcrypt($request->password);
    // $user->positionID =$request->positionID;
    if($userEdit == true){
      $userEdit->fill($request->all());
      $validator = Validator::make(json_decode($userEdit,TRUE), [ 
        'name' => 'required', 
        'email' => 'required|email', 
        'phone'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        //'password' => 'required', 
        'positionID' => 'required'
      ]);
      if ($validator->fails()) { 
        return response()->json(['error'=>$validator->errors()], 401);            
      }
      if (Gate::allows('admin-user', $userEdit->id)) {
        $user->save();
        return response()->json(['success' => true, 'code' => '200']);
      } else {
        return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
      }
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
    

    // $user->save();
    // return response()->json(['success' => true, 'code' => 200]);
  }
  public function destroy(Request $request, $id){
    
    $data = User::find((integer)$id);
    // $def = $data->delete();
    // if($def == true){
    //   return response()->json(['success' => true, 'code' => '200']);
    // }else{
    //   return response()->json(['success' => true, 'code' => '400']);
    // }

    if($data == true){
      if (Gate::allows('admin')) {
        $def = $data->delete();
        return response()->json(['success' => true, 'code' => '200']);
      } else return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
    }else return response()->json(['success' => false, 'code' => '404']);
  }

  public function getOneModel(Request $request, $id){
    $data = User::find((integer)$id);
    if($data==true){
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->position]);
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
  public function getChildContact(Request $request, $id){
    $data = User::find((integer)$id);
    // if($data==true){
    //   return response()->json(['success' => true, 'code' => '200', 'data' => $data->contact]);
    // }else{
    //   return response()->json(['success' => false, 'code' => '404']);
    // }

    if($data == true){
      if (Gate::allows('admin-user', $data->id)) {
        return response()->json(['success' => true, 'code' => '200', 'data' => $data->contact]);
      } else {
        return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
      }
    }else{
      return response()->json(['success' => true, 'code' => '400']);
    }
    
  }
  public function getChildOrder(Request $request, $id){
    $data = User::find((integer)$id);
    // if($data==true){
    //   return response()->json(['success' => true, 'code' => '200', 'data' => $data->orderTable]);
    // }else{
    //   return response()->json(['success' => false, 'code' => '404']);
    // }
    if($data == true){
      if (Gate::allows('admin-user', $data->id)) {
        return response()->json(['success' => true, 'code' => '200', 'data' => $data->orderTable]);
      } else {
        return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
      }
    }else{
      return response()->json(['success' => true, 'code' => '400']);
    }
  }
  public function getUserOrder(Request $request){
    $data = Auth :: user();
    // if($data==true){
    //   return response()->json(['success' => true, 'code' => '200', 'data' => $data->orderTable]);
    // }else{
    //   return response()->json(['success' => false, 'code' => '404']);
    // }
    if($data == true){
      if (Gate::allows('admin-user', $data->id)) {
        return response()->json(['success' => true, 'code' => '200', 'data' => $data->orderTable]);
      } else {
        return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
      }
    }else{
      return response()->json(['success' => true, 'code' => '400']);
    }
  }
  public function getChildFood(Request $request, $id){
    $data = User::find((integer)$id);
    if($data==true){
      foreach($data->foodList as $food){
        $name = Foods::find((integer)$food->foodID)->foodName;
        $food ->foodName = $name;
      }
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->foodList]);
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
  }


  public function role(Request $request)
  {
      $ps =$request->user()->positionID;
      if($ps==1){
        $data = User::all();
        return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
      }else{
        return response()->json(false);
      }
  }
  public function getStaff(Request $request){
    $data = Auth::user();
  // return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
  
    if (Gate::allows('admin', $data->id)) {
      $data = User::where('positionID', 4)->orWhere('positionID', 6)->get();
      return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
    } else {
      return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to see"]);
    }
  }

  public function getSalary(Request $request, $id){
    $data = User::find((integer)$id);
    if($data==true){
      foreach($data->getSalary as $sal){
        
        $type = KindOfSalary::find((integer)$sal->specificSalaryID);
        $sal->name = $data->name;
        $sal->salary = $type->salary;
        $sal->coefficient = $type->coeficient;
      }
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->getSalary]);
    }else{
      return response()->json(['success' => false, 'code' => '404']);
    }
  }

}