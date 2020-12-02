<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

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
}

