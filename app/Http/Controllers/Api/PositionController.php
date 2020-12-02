<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Model\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request){
        $position = Position::all();
          
          // $user = $user->paginate(10);
           return response()->json(['success' => true, 'code' => '200', 'data' => $position]);
    }
    public function getModel(Request $request, $id){
        $data = Position::find((integer)$id);
        if($data==true){
            return response()->json(['success' => true, 'code' => '200', 'data' => $data->user]);
        }else{
            return response()->json(['success' => false, 'code' => '404']);
        }
    }
}
