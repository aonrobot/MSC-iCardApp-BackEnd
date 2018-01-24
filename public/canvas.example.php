<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>QRLab</title>
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="css/open-iconic-bootstrap.min.css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>

	<style type="text/css">
		@font-face {
		    font-family: 'sarabunNew';
		    src: url('fonts/THSarabunNew.ttf');
		}
		@font-face {
			font-family: 'KulminoituvaRegular';
			src: url('http://www.miketaylr.com/f/kulminoituva.ttf');
		}
	</style>
	
	<script>
		
	</script>
	
</head>
<body>

	<canvas id="myCanvas" width="531" height="325"
	style="border:1px solid #d3d3d3; background-color: #FFF;">
	Your browser does not support the canvas element.
	</canvas>

	


	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 25px;">
	  <a class="navbar-brand" href="#">QRlab</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	</nav>
	<div class="container">
		<div class="section">
			<div class="row">
				<div class="col-12">
					<h3><span class="oi oi-credit-card"></span></span> Bussiness Card</h3>
					<p class="lead">
					  Hold bottom image to save image
					</p>
					<hr>
					<img id="canvasImg" class="mw-100" alt="Right click to save me!">
					<hr>
				</div>
			</div>
		</div>
	</div>

	<img id="logoImg" src="images/bg_card.png" height="530" width="325" alt="Right click to save me!" style="display: none">

	<script src="js/jquery-3.2.1.min.js" ></script>
	<script src="js/bootstrap.min.js"></script>


	<script>

		<?php
				$nTH = (isset($_GET['nTH'])) ? $_GET['nTH'] : '';
				$lnTH = (isset($_GET['lnTH'])) ? $_GET['lnTH'] : '';
				$nEN = (isset($_GET['nEN'])) ? $_GET['nEN'] : '';
				$lnEN = (isset($_GET['lnEN'])) ? $_GET['lnEN'] : '';
				$pos = (isset($_GET['pos'])) ? $_GET['pos'] : '';
				$depart = (isset($_GET['d'])) ? $_GET['d'] : '';

				if(isset($_GET['tel'])){
					$tel = $_GET['tel'];
					$tel = str_replace('-','',$tel);
					$telF = substr($tel, 1,1);
					$telFull1 = substr($tel, 2,4);
					$telFull2 = substr($tel, 6,9);
					$tel = '+66' . $telF . ' ' . $telFull1 . ' ' . $telFull2;
				}else{
					$tel = '';
				}

				if(isset($_GET['fax'])){
					$fax = $_GET['fax'];
					$fax = str_replace('-','',$fax);
					$faxF = substr($fax, 1,1);
					$faxFull1 = substr($fax, 2,4);
					$faxFull2 = substr($fax, 6,9);
					$fax = '+66' . $faxF . ' ' . $faxFull1 . ' ' . $faxFull2;
				}else{
					$fax = '';
				}
				
				if(isset($_GET['dir'])){
					$dir = $_GET['dir'];
					$dir = str_replace('-','',$dir);
					$dirF = substr($dir, 1,1);
					$dirFull1 = substr($dir, 2,4);
					$dirFull2 = substr($dir, 6,9);
					$dir = '+66' . $dirF . ' ' . $dirFull1 . ' ' . $dirFull2;
				}else{
					$dir = '';
				}
		?>
		
		function init(){
			var canvas = document.getElementById("myCanvas");
			var ctx = canvas.getContext("2d");

			var card = {'width' : 531 , 'height' : 325}

			ctx.beginPath();
			ctx.rect(0, 0, card.width, card.height);

			ctx.fillStyle = "white";
			ctx.fill();

			ctx.rect(0, 0, card.width, card.height);
			ctx.stroke();

			//Backgroud
			var img = document.getElementById("logoImg");
			ctx.drawImage(img, 0, 0 , 530, 325);
			
			//Section 1 NameTH, NameEN, Position
			var midHoCard = canvas.width/12.2
			var startHeightCard = 75;

			ctx.font = "lighter 32px sarabunNew";
			ctx.fillStyle = "black";
			ctx.fillText("<?php echo $nTH; ?> <?php echo $lnTH; ?>",midHoCard, startHeightCard);

			ctx.font = "bold 32px sarabunNew";
			ctx.fillStyle = "black";
			ctx.fillText("<?php echo $nEN; ?> <?php echo $lnEN; ?>",midHoCard, startHeightCard+26);

			ctx.font = "lighter 18.5px Arial";
			ctx.fillStyle = "#0068b0";
			ctx.fillText("<?php echo $pos; ?>",midHoCard, startHeightCard+50);

			//Section 2 Tel
			var midHoCard = canvas.width/8.2
			var startHeightCard = 152;

			ctx.font = "lighter 14px Arial";
			ctx.fillStyle = "black";
			ctx.fillText("Tel : <?php echo $tel; ?>",midHoCard,startHeightCard);

			ctx.font = "lighter 14px Arial";
			ctx.fillStyle = "black";
			ctx.fillText("Dir : <?php echo $dir; ?>",midHoCard,startHeightCard+17);

			ctx.font = "lighter 14px Arial";
			ctx.fillStyle = "black";
			ctx.fillText("Fax : <?php echo $fax; ?>",midHoCard+145 ,startHeightCard);
			
			//Section 2 Email
			var midHoCard = canvas.width/8.2
			var startHeightCard = 185;

			ctx.font = "lighter 14px Arial";
			ctx.fillStyle = "black";
			ctx.fillText("<?php echo $_GET['email']; ?>",midHoCard ,startHeightCard);

			// Data
			//Gen Canvas to Image

			// save canvas image as data url (png format by default)
			var dataURL = canvas.toDataURL();

			// set canvasImg image src to dataURL
			// so it can be saved as an image
			document.getElementById('canvasImg').src = dataURL;

			canvas.style.display = 'none'
		}

		$(document).ready(function(){
			init()
		})
		

	</script>

</body>
</html>
