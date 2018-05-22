<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

use DB;

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

    public function show($id){
        $data = DB::select("SELECT DISTINCT OrgCode as 'company_code', c.company_name FROM MSCMain.dbo.EmployeeNewAllCom as ENAC LEFT JOIN iCard.dbo.company as c ON ENAC.OrgCode = c.company_code WHERE login = ?", [$id]);
        
        return response()->json(['status' => '200', 'event' => 'get Show Company', 'result' => true, 'data' => $data], 200);
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
