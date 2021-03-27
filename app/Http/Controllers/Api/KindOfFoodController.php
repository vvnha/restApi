<?php

namespace App\Http\Controllers\Api;

use App\Model\KindOfFood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class KindOfFoodController extends Controller
{
    public function index(Request $request){
        $data = KindOfFood::all();
        return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
    }
    public function getModel(Request $request, $id){
        $data = KindOfFood::find((integer)$id);
        if($data==true){
            return response()->json(['success' => true, 'code' => '200', 'data' => $data->food]);
        }else{
            return response()->json(['success' => false, 'code' => '404']);
        }
    }
}