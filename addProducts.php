<?php

	//Et pääseks ligi sessioonile
	require("PHP/functions.php");
	require("PHP/addProducts_func.php");
	require("PHP/Photoupload.class.php");
	//KATEGOORIATE TSENTRAAL HALDUS 
	$categories = array("Elektroonika", "Koduloomad", "Kodutehnika");
	
	//Kui pole sisseloginud, liigume login lehele
	//Kui pole sisseloginud, liigume login lehele
	if(!isset($_SESSION["userID"])){
		header("Location: index.php");
		exit();
	}
	$dateCreated = date_create($_SESSION["created"]);
	
	if(isset($_POST["exit"])){
		header("Location: main.php");
		exit();
	}
	$notice="";
	$target_dir = "pildid/";
	$target_file = "";
	$uploadOk = 1;
	$maxWidth = 400;
	$maxHeight = 400;
	$marginHor = 30;
	$marginVer = 10;
	
	if(isset($_POST["submit"])) {
		//kas fail on valitud, failinimi olemas
		if(!empty($_FILES["fileToUpload"]["name"])){
			
			//fikseerin failinime
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
			$target_file = "hmv_" .(microtime(1) * 10000) ."." .$imageFileType;
			
			//Kas on pildi failitüüp
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$notice .= "Fail on pilt - " . $check["mime"] . ". ";
				$uploadOk = 1;
			} else {
				$notice .= "See pole pildifail. ";
				$uploadOk = 0;
			}
			
			/*//Kas selline pilt on juba üles laetud
			if (file_exists($target_file)) {
				$notice .= "Kahjuks on selle nimega pilt juba olemas. ";
				$uploadOk = 0;
			}*/
			//Piirame faili suuruse
			if ($_FILES["fileToUpload"]["size"] > 1000000) {
				$notice .= "Pilt on liiga suur! ";
				$uploadOk = 0;
			}
			
			//Piirame failitüüpe
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$notice .= "Vabandust, vaid jpg, jpeg, png ja gif failid on lubatud! ";
				$uploadOk = 0;
			}
			
			//Kas saab laadida?
			if ($uploadOk == 0) {
				$notice .= "Vabandust, pilti ei laetud üles! ";
			//Kui saab üles laadida
			} else {		
				
				//Pildi laadimine klassi abil
				$myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
				$myPhoto->resizePhoto($maxWidth, $maxHeight);
				//$myPhoto->addWatermark("../../graphics/hmv_logo.png", $marginHor, $marginVer);
				//$myPhoto->addTextWatermark("Head Mötete Veeb");
				$notice = $myPhoto->savePhoto($target_dir, $target_file);
				//$myPhoto->saveOriginal($directory, $target_file);
				$myPhoto->clearImages();
				echo $target_file;
				unset($myPhoto);
				
			}//saab salvestada lõppeb		
		
		} else {
			$notice = "Palun valige kõigepealt pildifail!";
		}
	}
	
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Sisselogimine meie uude projekti™</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<style>
	
	.btn-primary {
		background: #0099cc;
		color: #ffffff;
	}
	
	#inner-left {
		float: left;
		width: 25%;
		border: 3px solid #000000;
		padding: 20px;
		border-width: 8px;
		background-color: white;
		border-radius: 15px;
	}
	#inner {
		width: 50%;
		margin: auto;
		border: 3px solid #000000;
		padding: 20px;
		border-width: 8px;
		background-color: white;
		border-radius: 15px;
		
	}
	#grad {
		background: #ff1a1a; /* For browsers that do not support gradients */
		background: radial-gradient(#ff3333, #b30000); /* Standard syntax */
	}
	.badge {
		color: white;
		border: 1px solid #000000;
		border-width: 1px;
		border-radius: 5px;
		background-color: black;
	}
	div.gallery {
    margin: 10px;
    border: 1px solid #ccc;
    float: left;
    width: 180px;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
}

div.desc {
    padding: 15px;
    text-align: center;
}

label {
	font-weight: bold;
}
	</style>
</head>
<body id="grad" style="align: center;">
	<h1 style="text-align: center; color: white;" >Meie projekt™</h1>
	<div id="inner">
	<h2>Lisa uus toode</h2>
	<hr>
	<form action="addProducts.php" method="post" enctype="multipart/form-data">
	<label>Toote nimi: </label>
	<input class="form-control" name="productName" type="text" value="">
	<br>
	<label for="description">Toote Kirjeldus:</label>
	<textarea class="form-control" rows="2" id="description"></textarea>
	<br>
	<label>Toote kogus: </label>
	<input class="form-control" name="productName" type="number" value="" min="1">
	
	<br>
	<label>Vali toote kategooria: </label>
	<?php echo createCategoryDropdown($categories);?>
	<br>
	<label>Toote Hind (€): </label>
	<input class="form-control" name="productName" type="number" value="" min="0">
	<br>
	<label>Valige toodet kirjeldav pilt:</label>
	<input type="file" name="fileToUpload" id="fileToUpload">
	<br>
	<br>
	<input style="float: left;" name ="exit" type="submit" class="btn btn-warning" value="Katkesta">
	<input style="float: right;" name ="submit" type="submit" class="btn btn-success" value="Lisa">
	<br>
	</form>
		
	</div>
</body>
</html>