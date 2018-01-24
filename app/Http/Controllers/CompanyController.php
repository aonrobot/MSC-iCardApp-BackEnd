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
        foreach($data as $d){
            $d->company_name = str_replace(' ', '', $d->company_name);
            $d->company_Use = str_replace(' ', '', $d->company_Use);
            $d->company_UAdj = str_replace(' ', '', $d->company_UAdj);
            $d->company_UBG = str_replace(' ', '', $d->company_UBG);
            $d->company_UJobD = str_replace(' ', '', $d->company_UJobD);
        }
        return response()->json(['status' => '200', 'event' => 'get All Company', 'result' => true, 'data' => $data], 200);
    }

    //
}
