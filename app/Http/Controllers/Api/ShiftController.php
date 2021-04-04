<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Shift;

class ShiftController extends Controller
{
    public function index()
    {
        $data = Shift::all();
        return response()->json(['success' => false, 'data' => $data],200);
       
    }
}