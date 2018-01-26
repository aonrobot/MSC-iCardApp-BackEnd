<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR LAB</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
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
    <h1 class="text-center title p-3">Business Card</h1>
        
    <div class="container">
        <div class="card p-1">
        <img src="/images/bg_card.png" alt="" width="100%" id="card"  style="display: block;">  
        <div id="canvas"></div>
        {{--  LogoImage  --}}
        <div style="display:none;">
            <img src="/images/company/MCC.png"  id ="logoImage"/>
        </div>

        <div class="card-block">
            
            <!-- IMG Insert Here  -->
            <div class="m-1 p-1">
                <div class="btn-panel p-1 float-left">
                    <!-- BUTTON!!! -->
                    <img src="/images/geature.svg" alt="Tab+Hold to save Card" width="100%"/>   
                </div>
                <p class="float-left p-1 m-1">Tab + Hold to save card</p>
            </div>
        </div>
        </div>
    </div>
   
</body>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script>

        
    var data ;
    $.ajax({
        url: "/api/card/fake",
        async : false
        }).done(function (res) {
           data = res.data; 
        });

    var img = document.getElementById("card");        
       
    $('#canvas').html( `
        <canvas id = 'myCanvas' width='${ img.offsetWidth }px' height = '${ img.offsetHeight }px'>Your browser does not support the HTML5 canvas tag.</canvas>
    `);

    var canvas = document.getElementById("myCanvas");
        canvas.width = img.offsetWidth;
        canvas.height = img.offsetHeight;

        img.style.display = "none";
        
	var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0,0,canvas.width,canvas.height);

    //  THAI NAME 
		ctx.font = "lighter 3vw sarabunNew";
		ctx.fillStyle = "black";
		ctx.fillText(data.nameTH + '  ' + data.lastnameTH, canvas.width/10, canvas.height/5);
    
    // ENG NAME 

        ctx.font = "bold 3vw Quicksand";
		ctx.fillStyle = "black";
		ctx.fillText(data.nameEN + '  ' + data.lastnameEN, canvas.width/10, canvas.height/3.5);
    
    // POSITION
  
		ctx.fillStyle = "#0364b1";
		ctx.fillText(data.position, canvas.width/10, canvas.height/2.7);
    
    // TEL
        ctx.font = " 2vw Quicksand";
        ctx.fillStyle = "black";
		ctx.fillText('Tel : ' + data.contactTel + '  Fax : ' +  data.contactFax, canvas.width/ 8, canvas.height/2.15);
        ctx.fillText('Dir : ' + data.contactDir , canvas.width / 8, canvas.height / 1.95);
    
    // EMAIL

		ctx.fillText(data.email, canvas.width / 8, canvas.height / 1.79);
    
    // Company

        ctx.font = "bold 2vw sarabunNew";
        ctx.fillStyle = "black";
		ctx.fillText(data.companyName, canvas.width / 8, canvas.height / 1.5);
    
    // Logo 
    var imageList = ['HIS','MCC','MID','MSC'];
        imageList = imageList.map(function(x){ return x.toLowerCase() });
    var image ;
    if( imageList.indexOf(data.company.toLowerCase()) === -1 ){
        image = 'MSC';
    }else {
        image = data.company;
    }
   
    /*var logoImage = document.getElementById('logoImage');
        logoImage.src = `/images/company/${image}.png`;

    var widthLogoImage = canvas.width * 0.94
    var heightLogoImage = canvas.height * 0.86

    var MCC_Woffer = canvas.width * 0.618
    var MCC_Hoffer = canvas.height * 0.538

    console.log(canvas.width, canvas.height)

    ctx.drawImage(
        logoImage, 
        0, 
        0, 
        widthLogoImage,
        heightLogoImage , 

        canvas.width - logoImage.width , 
        canvas.height - logoImage.height , 

        widthLogoImage - MCC_Woffer,
        heightLogoImage - MCC_Hoffer ,  
    );*/

    var dataURL = canvas.toDataURL(); 
    img.style.display = 'block';
    img.src = dataURL;
	canvas.style.display = 'none'
    
</script>
</html>

