<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR LAB</title>
    <link rel="stylesheet" href="{{\Library\Util::asset('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{\Library\Util::asset('\vendor\font-awesome\css\font-awesome.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <style>
      
        html, body {
            margin: 0;
            width: 100vw;
            height: 100vh;
            background: #36D1DC;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to top, #36D1DC, #5B86E5);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to top, #36D1DC, #5B86E5); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }    
        .title { 
            color : #ffffff;
            font-family: 'Quicksand', sans-serif;
            font-size : 20px;
            padding-top: 35px;
        }
        .card {
            box-shadow:0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        }
        .btn-panel {
            width :50px;
            height : 50px;
            background: #f1c40f;  /* fallback for old browsers */
           
        }
        p{
            font-family: 'Quicksand', sans-serif;
            font-size : 20px;
            color:#333333;  
        }
        #myCanvas{
            width: 100%;
        }
       
    </style>
</head>
<body>  
    <h1 class="text-center title p-3">E-Business Card</h1>
        
    <div class="container">
        <div class="card p-1">
        <div class="card-block">
                <!-- IMG Insert Here  -->
                <div class="m-1 p-1">
                    <a class="btn btn-primary" href="{{\Library\Util::asset('/vcard/' . $id)}}"><i class="fa fa-address-book mr-1" aria-hidden="true"></i> Save this contact to my phone</a>
                </div>
            </div>

            <!-- Card  -->
            <img src="{{\Library\Util::asset('/card/image/' . $id)}}" alt="" width="100%" id="card"  style="display: block;">  

            <div class="card-block">
                <!-- IMG Insert Here  -->
                <div class="m-1 p-1">
                    <div class="btn-panel p-1 float-left">
                        <!-- BUTTON!!! -->
                        <img src="{{\Library\Util::asset('/images/geature.svg')}}" alt="Tab+Hold to save Card" width="100%"/>   

                    </div>
                    <p class="float-left p-1 m-1">กดค้างที่รูปเพื่อ Save</p>
                </div>
            </div>
        </div>
    </div>
   
</body>
</html>

