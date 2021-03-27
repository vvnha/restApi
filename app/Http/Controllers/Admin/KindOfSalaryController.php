<?php

namespace App\Http\Controllers\Admin;

use App\Model\KindOfSalary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class KindOfSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KindOfSalary::orderBy('id', 'DESC')->paginate(8);
        $collection = KindOfSalary::count();
        return view('admin.salary.index',['data'=>$data,'collection'=>$collection]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [ 
            'type' => 'required',
            'coeficient' => 'required', 
            'salary' => 'required|integer'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }
        $kSalary = new KindOfSalary();
        $kSalary->type = $request->type;
        $kSalary->coeficient = $request->coeficient;
        $kSalary->salary = $request->salary;
        $kSalary->note = $request->note;
        $kSalary->save();
        return response()->json([
            'error' => false,
            'data'  => 'ok',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\KindOfSalary  $kindOfSalary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $kSalary = KindOfSalary::find((integer)$id);
        return response()->json([
            'error' => false,
            'data'  => $kSalary
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\KindOfSalary  $kindOfSalary
     * @return \Illuminate\Http\Response
     */
    public function edit(KindOfSalary $kindOfSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\KindOfSalary  $kindOfSalary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [ 
            'type' => 'required',
            'coeficient' => 'required', 
            'salary' => 'required|integer'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }
        $kSalary = KindOfSalary::find((integer)$id);
        $kSalary->fill($request->all());
        $kSalary->save();
        return response()->json([
            'error' => false,
            'data'  => $kSalary,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\KindOfSalary  $kindOfSalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = KindOfSalary::destroy($id);
        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }
}