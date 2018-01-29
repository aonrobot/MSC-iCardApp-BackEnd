<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Library;
use GDText\Box;
use GDText\Color;

use App\Http\Controllers\ICardController;

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
        return view('card', ['id' => $id]);  
    }

    public function cardImage($id){
        
        $card = DB::connection('iCard')->table('cards')->where('id', $id)->get();

        $iCardController = new ICardController;
        $card = $iCardController->get($id);

        $card = json_decode($card->content(), true);


        /*$app = app();
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
        $fakeData->email = 'pusitkit@metrosystems.co.th';*/

        header("Content-type: image/png");
        $string = "Metrosystems";
        $im     = imagecreatefrompng('./images/bg_card.png');

        /////////////////////////////////// Text ////////////////////////////////////

        //Init
        $box = new Box($im);

        if(count($card['data']) <= 0){
            $box->setFontFace('./fonts/THSarabunNew Bold.ttf');
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
        $box->setFontFace('./fonts/THSarabunNew.ttf');
        $box->setFontColor(new Color(73, 73, 73));
        $box->setFontSize(80);
        $box->setBox(145, 120, 1200, 460);
        $box->draw($card['nameTH'] . ' ' . $card['lastnameTH']);
        
        //Name English
        $box->setFontFace('./fonts/THSarabunNew Bold.ttf');
        $box->setBox(145, 200, 1200, 460);
        $box->draw($card['nameEN'] . ' ' . $card['lastnameEN']);

        //Position
        $box->setFontColor(new Color(0, 102, 178));
        $box->setFontFace('./fonts/THSarabunNew Bold.ttf');
        $box->setBox(145, 280, 1200, 460);
        $box->draw($card['position']);

        //////////////////////////////////////////////////////////////////////////////

        //Set font size and color to this section
        $box->setFontFace('./fonts/THSarabunNew.ttf');
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
        $box->setFontFace('./fonts/THSarabunNew Bold.ttf');
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
