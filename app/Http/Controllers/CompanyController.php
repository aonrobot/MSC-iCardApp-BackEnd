<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
        $data = Company::all();
        return response()->json(['status' => '200', 'event' => 'get All Company', 'result' => true, 'data' => $data], 200);
    }

    //
}
