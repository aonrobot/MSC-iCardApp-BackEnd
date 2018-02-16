<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB as DB;

class ICardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->CARD_url = 'https://fora.metrosystems.co.th/icard/card/';
        $this->QRCODE_API_url = "https://chart.googleapis.com/chart?cht=qr&chs=350x350&chl=";
        $this->QRCORD_API_charset = "&choe=UTF-8";
    }

    public function all(){
        return response()->json(Employee::all());
    }

    public function nextId(){
        $lastId = DB::connection('iCard')->table('cards')->select(['id'])->orderBy('id', 'desc')->take(1)->get()[0]->id;

        return response()->json([
            'status' => '200',
            'event' => 'Get Last Card ID',
            'result' => true,
            'data' => [
                'CARD_url' => $this->CARD_url . (intval($lastId) + 1),
                'CARD_id' => intval($lastId) + 1,
                'QRCODE_API_url' => $this->QRCODE_API_url,
                'QRCORD_API_charset' => $this->QRCORD_API_charset
            ]
        ], 200); 
    }

    private function findCompanyNameByCode($code){
        $company_name = DB::connection('iCard')->table('company')->where('company_code', $code)->select(['company_name'])->get();
        $company_name = (count($company_name) <= 0) ? $code : $company_name[0]->company_name;
        return $company_name;
    }

    public function get($id){
        $card = DB::connection('iCard')->table('cards')->where('id', $id)->get();

        foreach($card as $c){
            $c->qrcode_url = $this->QRCODE_API_url . $this->CARD_url . $c->id . $this->QRCORD_API_charset;

            $c->companyName = $this->findCompanyNameByCode($c->company);
        }

        return response()->json([
            'status' => '200',
            'event' => 'Get card detail',
            'result' => true,
            'data' => $card
        ], 200);
    }

    public function of($username){
        $cards = DB::connection('iCard')->table('cards')
                    ->where('userLogin', $username)->where('isDelete','!=',true)->get();

        foreach($cards as $card){
            $card->avatar_url = $this->QRCODE_API_url . $this->CARD_url  . $card->id . $this->QRCORD_API_charset;

            $card->companyName = $this->findCompanyNameByCode($card->company);
        }

        return response()->json([
            'status' => '200',
            'event' => 'Get Cards of this user',
            'result' => true,
            'data' => $cards
        ], 200); 
    }

    public function create(Request $request){ //$userLogin, $company, $nameTH, $lastnameTH, $nameEN, $lastnameEN, $position, $department, $contactTel, $contactDir, $contactFax, $email

        $userLogin = $request->input('u');

        $company = $request->input('c');

        $nameTH = $request->input('nT');
        $lastnameTH = $request->input('lT');
        $nameEN = $request->input('nE');
        $lastnameEN = $request->input('lE');

        $position = $request->input('p');
        $department = $request->input('d');

        $contactTel = $request->input('cT');
        $contactDir = $request->input('cD');
        $contactFax = $request->input('cF');

        $email = $request->input('e');

        $id = DB::connection('iCard')->table('cards')->insertGetId(
            [
                'userLogin' => $userLogin,
                'company' => $company,
                'nameTH' => $nameTH,
                'lastnameTH' => $lastnameTH,
                'nameEN' => $nameEN,
                'lastnameEN' => $lastnameEN,
                'position' => $position,
                'department' => $department,
                'contactTel' => $contactTel, 
                'contactDir' => $contactDir,
                'contactFax' => $contactFax,
                'email' => $email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::connection('iCard')->table('log')->insertGetId(
            [
                'event' => 'Create New Card',
                'action_table' => 'cards',
                'action_id' => $userLogin
            ]
        );

        return response()->json(['status' => '200', 'event' => 'Create New Card', 'result' => true, 'data' => ['CARD_url' => $this->CARD_url . $id, 'CARD_id' => $id]], 200);
    }

    public function delete(Request $request){ //$userLogin, $cardId

        $userLogin = $request->input('username');
        $cardId = $request->input('cardId');

        DB::connection('iCard')->table('cards')->where('id', $cardId)->where('userLogin', $userLogin)->update(['isDelete' => true]);

        DB::connection('iCard')->table('log')->insertGetId(
            [
                'event' => 'Delete Card',
                'action_table' => 'cards',
                'action_id' => $userLogin
            ]
        );

        return response()->json(['status' => '200', 'event' => 'Delete Card', 'result' => true], 200);
    }

    //
}
