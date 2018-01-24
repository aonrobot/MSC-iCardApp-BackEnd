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
        
        $card = DB::connection('iCard')->table('cards')->where('id', $id)->get();
        return view('card', ['card' => $card[0]]);  
    }

    //
}
