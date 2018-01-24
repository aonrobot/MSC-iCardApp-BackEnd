<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB as DB;

class frontController extends Controller
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

    public function card($id){
        
        //$card = DB::connection('iCard')->table('cards')->where('id', $id)->get();

        $app = app();
        $fakeData = $app->make('stdClass');
        $fakeData->company = 'Metro Systems Corporation Public Company Limited';        
        $fakeData->nameTH = 'ภูสิทธ์';
        $fakeData->lastnameTH = 'กิติธียานุลกดฟหก';
        $fakeData->nameEN = 'Pusit';
        $fakeData->lastnameEN = 'Kittidasda';
        $fakeData->position = 'CEO Web Designer';
        $fakeData->department = 'Home';
        $fakeData->contactTel = '02-222-2548';
        $fakeData->contactFax = '02-222-2548';
        $fakeData->contactDir = '085-299-0414';
        $fakeData->email = 'pusitkit@metrosystems.co.th';

        return view('card', ['card' => $fakeData]);  
    }

    //
}
