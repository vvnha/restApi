<?php

namespace App\Http\Controllers\Admin;

use App\Model\Foods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class FoodController extends Controller
{
    public function allfood()
    {	

        $foods = Foods::orderBy('foodID', 'DESC')->paginate(8);
    	$collection = Foods::count();
        return view('admin.food.allfood',['foods'=>$foods,'collection'=>$collection]);
    }

    public function doan()
    {	
    	$foods = Foods::where('parentID', '=', 1)->get();
    	$collection=10;
       return view('admin.food.doan', ['foods'=>$foods,'collection'=>$collection]);
    }

    public function drink()
    {	
    	$foods = Foods::where('parentID', '=', 2)->get();
    	$collection=10;
       return view('admin.food.doan', ['foods'=>$foods,'collection'=>$collection]);
    }

    public function addfood()
    {	
       return view('admin.food.addfood');
    }

    public function store(Request $request)
    {	

       	$foods = new Foods();
       	$foods->foodName = $request->name;
       	$foods->price = $request->price;
       	$foods->hits = $request->hits;
		$foods->ingres = $request->ingres;
		$foods->parentID = $request->parentID;
        $foods->rating = 5;

        $rules = [ 'image' => 'mimes:jpeg,jpg,png|max:5086' ]; 
        $posts = [ 'image' => $request->file('file') ];
        $valid = Validator::make($posts, $rules);
        
        if ($valid->fails()) {
            // Có lỗi, redirect trở lại
            return redirect()->back()->withErrors($valid)->withInput();
        }
        else {
            // Ko có lỗi, kiểm tra nếu file đã dc upload
            if ($request->file('file')->isValid()) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension = $request->file('file')->getClientOriginalExtension(); // Lấy . của file
                
                $fileName = time() . "_" . rand(0,9999999) . "." . $fileExtension;

                $uploadPath = public_path('img');
                $request->file('file')->move($uploadPath, $fileName);
                $foods->img = "public/img/".$fileName;
                $foods->save();
                return redirect()->back()->with('success', 'Upload files thành công!');
            }
            else {
                return redirect()->back()->with('error', 'Upload files thất bại!');
            }
        }
	
       
    }

    public function edit($id)
    {
        $food = Foods::find((integer)$id);
        // dd($id)
        return view('admin.food.edit', ['food'=>$food]);
    }

    public function update(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [ 
          'name' => 'required',
          'price' => 'required|integer', 
          'hits' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/', 
          'ingres' => 'required',
          'parentID' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ldate = date('Y-m-d H:i:s');
        $food = Foods::find($id);
        $food->foodName = $request->name;
        $food->price = $request->price;
        $food->hits = $request->hits;
        $food->ingres = $request->ingres;
        $food->parentID = $request->parentID;
        $food->updated_at = $ldate;
        $food->save();
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }


    public function upload(Request $request,$id)
    {   
        $rules = [ 'image' => 'mimes:jpeg,jpg,png|max:5086' ]; 
        $posts = [ 'image' => $request->file('file') ];
        $valid = Validator::make($posts, $rules);
        
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        else {
            // Ko có lỗi, kiểm tra nếu file đã dc upload
            if ($request->file('file')->isValid()) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension = $request->file('file')->getClientOriginalExtension(); // Lấy . của file
                
                $fileName = time() . "_" . rand(0,9999999) . "." . $fileExtension;

                $uploadPath = public_path('img');
                $request->file('file')->move($uploadPath, $fileName);

                $img = "public/img/".$fileName;
                $ldate = date('Y-m-d H:i:s');
                $food = Foods::find($id);
                $food->img = $img;
                $food->updated_at = $ldate;
                $food->save();
                return redirect()->back()->with('success', 'Upload files thành công!');
            }
            else {
                return redirect()->back()->with('error', 'Upload files thất bại!');
            }
        }
       
    }

    public function delete($id)
    {     
        $id= (integer)$id;
        $del=Foods::where('foodID', $id)->delete();
        return redirect()->back()->with('success', 'Xóa thành công!');
    }

      public function updateurl(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [ 
          'urlimg' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ldate = date('Y-m-d H:i:s');
        $food = Foods::find($id);
        $food->img = $request->urlimg;
        $food->updated_at = $ldate;
        $food->save();
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

}
