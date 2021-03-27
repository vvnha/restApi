<?php

namespace App\Http\Controllers\Admin;

use App\Model\Attendance;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index()
    {
        $data = Attendance::orderBy('id', 'DESC')->paginate(8);
        $collection = Attendance::count();
        foreach($data as $value){
            $value->userName = $value->user->name;
        }
        return view('admin.attend.index',['data'=>$data,'collection'=>$collection]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'userID' => 'required', 
            'date' => 'required',
            'timeAttend' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = User::find((integer)$request->userID);
        $now = Carbon::now()->toDateString();
        $timeAttend = $request->timeAttend;
        $datetime = Carbon::create($now. ' '.$timeAttend);
        $insertDate = Carbon::create($request->date);
        $checkAttend = Attendance::where('date', 'LIKE', '%' . $now . '%')->where('userID',$request->userID)->get();

        if($data == true){
            if($insertDate->hour<$datetime->hour || ($insertDate->hour==$datetime->hour && $insertDate->minute<=$datetime->minute + 15)){ // diem danh truoc khi ket thuc diem danh hoac sau khi do 15p
                $attendance = new Attendance();
                $attendance->userID = $request->userID;
                $attendance->date =  $request->date;
                // $attendance->save();
                if($checkAttend->count()>0){
                    $newTime = Carbon::create($now. ' 12:00:00');
                    if($data->positionID == 6 && $checkAttend->count()<2 && ($insertDate->hour > $newTime->hour|| ($insertDate->hour ==  $newTime->hour && $insertDate->minute > $datetime->minute + 10 ))){ // diem danh lan 2 doi voi part time staff (position =6) và thgian phai truoc thoi gian diem danh (bat buoc sau 12h)
                        if(Carbon::create($checkAttend[0]->date)->hour != $insertDate->hour){ // thoi gian diem danh khong duoc trung voi thoi gian diem danh cua ca1
                            $result = true;
                        }else{
                            $result = false;
                        }
                        
                    }else{
                        $result = false;
                    }
                }else{
                    $result = true;
                }
                if($result == true){
                    $attendance->save();
                    return response()->json(['success' => true, 'code' => '200', 'data' => $result]);
                }else{
                    return response()->json([
                        'error'    => true,
                        'messages' => 'You have alredy had attendance('.$checkAttend->count().')',
                    ], 422);
                }
            }else{
                return response()->json([
                    'error'    => true,
                    'messages' => '404',
                ], 422);
            }
          }else{
            return response()->json([
                'error'    => true,
                'messages' => '404',
            ], 422);
        }
    }
    public function show(Request $request, $id)
    {
        $data = Attendance::find((integer)$id);
        return response()->json(['success' => true, 'code' => '200', 'data' => $data]);
    }
    public function update(Request $request, $id){
        $data = Attendance::find((integer)$id);
      
          if($data == true){
            $data->fill($request->all());
            $validator = Validator::make($request->all(), [ 
                'userID' => 'required', 
                'date' => 'required'
            ]);
            if ($validator->fails()) { 
                return response()->json([
                    'error'    => true,
                    'messages' => $validator->errors(),
                ], 422);
            }
            $data->save();
            return response()->json(['success' => true, 'code' => '200']);
          }else{
            return response()->json([
                'error'    => true,
                'messages' => ['404','khong tim thay du lieu'],
            ], 422);
          }
          
      
          // $cmt->save();
          // return response()->json(['success' => true, 'code' => 200]);
    }
    public function destroy(Request $request, $id)
    {
        $data = Attendance::destroy($id);
        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }
}