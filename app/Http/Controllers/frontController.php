<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Library;
use GDText\Box;
use GDText\Color;

use App\Http\Controllers\ICardController;

use Illuminate\Support\Facades\DB as DB;

use JeroenDesloovere\VCard\VCard;

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
        return view('card', ['id' => $id]);  
    }

    public function vcard($id){
        $card = DB::connection('iCard')->table('cards')->where('id', $id)->first();
        $info = DB::table('EmployeeNew')->where('login', $card->userLogin)->first();
        $company_name = DB::connection('iCard')->table('company')->where('company_code', $card->company)->first(['company_name'])->company_name;
        //print_r($company_name);return 0;

        $vcard = new VCard();

        $lastname =$info->LastNameEng;
        $firstname = $info->FirstNameEng;
        $additional = '';
        $prefix = $info->TitleEng;
        $suffix = '';

        // add personal data
        $vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);       
        // add work data
        $vcard->addCompany($company_name);
        $vcard->addJobtitle($card->position);
        //$vcard->addRole('Data Protection Officer');
        $vcard->addEmail(strtolower($card->email));
        $vcard->addPhoneNumber($card->contactTel, 'WORK');
        $vcard->addPhoneNumber($card->contactFax, 'FAX');
        $vcard->addPhoneNumber($card->contactDir, 'CELL');
        $vcard->addAddress('400', null, 'Chalermprakiat Rama IX Road', 'Nong Bon', 'Prawet', '10250', 'Bangkok');
        $vcard->addLabel('street, worktown, workpostcode Belgium');
        $vcard->addURL('http://www.metrosystems.co.th');

        // return vcard as a download
        return $vcard->download();

    }

    public function cardImage($id){
        
        $card = DB::connection('iCard')->table('cards')->where('id', $id)->get();

        $iCardController = new ICardController;
        $card = $iCardController->get($id);

        $card = json_decode($card->content(), true);

        header("Content-type: image/png");
        $im     = imagecreatefrompng('./images/bg_card.png');

        /////////////////////////////////// Text ////////////////////////////////////

        $font_locate = str_replace('\\app\\Http\\Controllers', '\\public\\', __DIR__);

        //Init
        $box = new Box($im);

        if(count($card['data']) <= 0){
            $box->setFontFace($font_locate . 'fonts/THSarabunNew Bold.ttf');
            $box->setFontColor(new Color(73, 73, 73));
            $box->setFontSize(180);
            $box->setBox(250, 250, 1200, 460);
            $box->draw('ไม่พบใบ card นี้');
            imagepng($im);
            imagedestroy($im);
        }else{
            $card = $card['data'][0];
        }

        //Name Thai
        $box->setFontFace($font_locate . 'fonts/THSarabunNew.ttf');
        $box->setFontColor(new Color(73, 73, 73));
        $box->setFontSize(80);
        $box->setBox(145, 120, 1200, 460);
        $box->draw($card['nameTH'] . ' ' . $card['lastnameTH']);
        
        //Name English
        $box->setFontFace($font_locate . 'fonts/THSarabunNew Bold.ttf');
        $box->setBox(145, 200, 1200, 460);
        $box->draw($card['nameEN'] . ' ' . $card['lastnameEN']);

        //Position

        $position = $card['position'];

        if(strlen($position) > 33 && strlen($position) <= 57){
            $box->setFontSize(54);
        }else if(strlen($position) > 57){
            $box->setFontSize(45);            
        }

        $box->setFontColor(new Color(0, 102, 178));
        $box->setFontFace($font_locate . 'fonts/THSarabunNew Bold.ttf');
        $box->setBox(145, 280, 1200, 460);
        $box->draw($position);

        //////////////////////////////////////////////////////////////////////////////

        //Set font size and color to this section
        $box->setFontFace($font_locate . 'fonts/THSarabunNew.ttf');
        $box->setFontColor(new Color(40, 40, 40));
        $box->setFontSize(46);
        
        //Tel and Fax        
        $box->setBox(190, 390, 1200, 460);
        $box->draw('Tel      :  ' . $card['contactDir'] . '    Fax : ' . $card['contactFax']);

        //Dir
        $box->setBox(190, 435, 1200, 460);
        $box->draw('Direct  :  ' . $card['contactTel']);

        //Email
        $box->setBox(190, 497, 1200, 460);
        $box->draw($card['email']);

        //////////////////////////////////////////////////////////////////////////////

        //Set font size and color to this section
        $box->setFontFace($font_locate . 'fonts/THSarabunNew Bold.ttf');
        $box->setFontColor(new Color(40, 40, 40));
        $box->setFontSize(48);
        
        //Company      
        $box->setBox(195, 590, 1200, 460);
        $box->draw($card['companyName']);

        /////////////////////////////////// End Text ////////////////////////////////////


        /////////////////////////////////// Logo ////////////////////////////////////

        $company = $card['company'];

        if(file_exists('./images/company/' . $company . '.png')){
            $logo_path = './images/company/' . $company . '.png';
        }else{
            $logo_path = './images/company/MSC.png';
        }

        $logo = imagecreatefrompng($logo_path);

        switch($company){
            case 'MSC' :
                $marge_right = 90;
                $marge_bottom = 90;
            break;
            case 'HIS' :
                $marge_right = 120;
                $marge_bottom = 90;
            break;
            case 'MCC' :
                $marge_right = 100;
                $marge_bottom = 140;
            break;
            case 'MID' :
                $marge_right = 120;
                $marge_bottom = 90;
            break;
            default:
                $marge_right = 90;
                $marge_bottom = 90;
            break;
        }
        
        $sx = imagesx($logo);
        $sy = imagesy($logo);

        imagecopy($im, $logo, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($logo), imagesy($logo));


        /////////////////////////////////// End Logo ////////////////////////////////////

        imagepng($im);
        imagedestroy($im);

    }

    //
}
