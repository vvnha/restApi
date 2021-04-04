<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
    	$provinces = [
    		'1' => 'Dn',
    	    '2' => 'HN'
    	];

    	$response = [
    		'success' => true,
    		'code' => 'ok', // ''
    		'data' => $provinces
    	];
    	
        return response()->json($response);
    }

    public function attendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idUser' => 'required',
            'datetime' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401]);
        }

        $response = [
            'success' => true,
            'code' => $request->idUser,
            'datetime' => $request->datetime,
        ];

        return response()->json($response);
    }
}

