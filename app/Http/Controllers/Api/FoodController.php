<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Model\Foods;
use Illuminate\Http\Request;
use Validator;
use Auth;

class FoodController extends Controller
{
  public function index(Request $request)
  {
    $food = Foods::all();
    return response()->json(['success' => true, 'code' => 'ok', 'data' => $food]);
  }
  public function store(Request $request)
  {
    //$foodName = $request->input('foodName'); 

    $validator = Validator::make($request->all(), [
      'foodName' => 'required',
      'img' => 'required',
      'rating' => 'required',
      'hits' => 'required',
      'parentID' => 'required'
    ]);
    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()], 401);
    }
    $food = new Foods();

    $food->foodName = $request->foodName;
    $food->img = $request->img;
    $food->price = $request->price;
    $food->rating = $request->rating;
    $food->hits = $request->hits;
    $food->ingres = $request->ingres;
    $food->parentID = $request->parentID;
    // $food->save();

    // return response()->json(['success' => true, 'code' => 201]);
    if (Gate::allows('admin')) {
      $food->save();
      return response()->json(['success' => true, 'code' => '201']);
    } else {
      return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to create"]);
    }
  }
  public function show(Request $request, $id)
  {
    //$food = Foods::where('foodID', (integer)$id)->get();
    $data = Foods::find((int)$id);
    if ($data == true) {
      return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
    } else {
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
  public function update(Request $request, $id)
  {
    $food = Foods::find((int)$id);

    // $food->foodName=$request->foodName;
    // $food->img=$request->img;
    // $food->price =$request->price;
    // $food->rating =$request->rating;
    // $food->hits =$request->hits;
    // $food->ingres =$request->ingres;
    // $food->parentID =$request->parentID;

    if ($food == true) {
      $food->fill($request->all());
      $validator = Validator::make(json_decode($food, TRUE), [
        'foodName' => 'required',
        'img' => 'required',
        'rating' => 'required',
        'hits' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
        'parentID' => 'required'
      ]);
      if ($validator->fails()) {
        return response()->json(['error' => $validator->errors(), 'code' => 401]);
      }
      if (Gate::allows('admin')) {
        $food->save();
        return response()->json(['success' => true, 'code' => '200']);
      } else {
        return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to update"]);
      }
    } else {
      return response()->json(['success' => false, 'code' => '404']);
    }

    // $food->save();
    // return response()->json(['success' => true, 'code' => 'ok', 'data' => $food]);
  }
  public function destroy(Request $request, $id)
  {
    $food = Foods::find((int)$id);
    // if($def == true){
    //   return response()->json(['success' => true, 'code' => '200']);
    // }else{
    //   return response()->json(['success' => true, 'code' => '400']);
    // }
    if ($food == true) {
      if (Gate::allows('admin')) {
        $def = $food->delete();
        return response()->json(['success' => true, 'code' => '200']);
      } else return response()->json(['success' => false, 'code' => '401', 'data' => "No permission to delete"]);
    } else return response()->json(['success' => false, 'code' => '404']);
  }

  public function search(Request $request)
  {
    $foodInput = $request->input('name');

    $foods = Foods::query()->where('foodName', 'LIKE', "%%%{$foodInput}%%%")->get();
    if ($foods == true) {
      return response()->json(['success' => true, 'code' => '200', 'data' => $foods]);
    } else {
      return response()->json(['success' => false, 'code' => '404']);
    }
  }

  public function getOneModel(Request $request, $id)
  {
    $data = Foods::find((int)$id);
    if ($data == true) {
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->kindOfFood]);
    } else {
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
  public function getParentDetail(Request $request, $id)
  {
    $data = Foods::find((int)$id);
    if ($data == true) {
      return response()->json(['success' => true, 'code' => '200', 'data' => $data->detail]);
    } else {
      return response()->json(['success' => false, 'code' => '404']);
    }
  }
}