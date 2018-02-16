<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function all(){
        return response()->json(Employee::all());
    }

    public function info($login){
        $data = Employee::where('Login', $login)->where('WorkingStatus', '1')->get();
        foreach($data as $d){
            $d['FirstNameEng'] = ucfirst(strtolower($d['FirstNameEng']));
            $d['LastNameEng'] = ucfirst(strtolower($d['LastNameEng']));
            $d['phoneDir'] = '02-089-' . substr($d['Phone3'],1);
        }
        if(count($data) <= 0){
            return response()->json(['status' => '200', 'event' => 'get User Info', 'result' => false, 'data' => $data], 200);             
        }else{
            return response()->json(['status' => '200', 'event' => 'get User Info', 'result' => true, 'data' => $data], 200); 
        }
    }

    //
}
