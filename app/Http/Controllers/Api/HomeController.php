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
            'userID' => 'required',
            'date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401]);
        }
        $attendList = json_decode($request->date);
        $ii="";
        if(count($attendList)>0){
            $ii = 0;
            foreach($attendList as $value){
                
                $ii = $ii+ $value->userID;
            }
            return response()->json($ii);
            $response = [
                    'success' => true,
                    'code' => $request->userID,
                    'datetime' => $attendList
                ];
            return response()->json($response);
        }else{
            $response = [
                'success' => true,
                'code' => $request->userID,
                'message' => "no data"
            ];  
        }

        // $response = [
        //     'success' => true,
        //     'code' => $request->userID,
        //     'datetime' => count(json_decode($request->date))
        // ];

        return response()->json($response);
    }
}