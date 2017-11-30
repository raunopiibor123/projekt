<?php

	//Et pääseks ligi sessioonile
	require("PHP/functions.php");
	
	//Kui pole sisseloginud, liigume login lehele
	//Kui pole sisseloginud, liigume login lehele
	if(!isset($_SESSION["userID"])){
		header("Location: index.php");
		exit();
	}
	$dateCreated = date_create($_SESSION["created"]);
	
	if(isset($_POST["logout"])){
		session_destroy();
		header("Location: index.php");
		exit();
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
	<label>Toote nimi: </label>
	<input class="form-control" name="productName" type="text" value="">
	<br>
	<label for="description">Toote Kirjeldus:</label>
	<textarea class="form-control" rows="2" id="description"></textarea>
	<br>
	<label>Toote kogus: </label>
	<input class="form-control" name="productName" type="number" value="" min="1">
	
	<br>
	<br>
	<label>Toote Hind (€): </label>
	<input class="form-control" name="productName" type="number" value="" min="0">
	<br>
	<label>Valige toodet kirjeldav pilt (no porr plz):</label>
	<input type="file" name="fileToUpload" id="fileToUpload">
	<br>
	<br>
	<input style="float: left;"name ="exit" type="submit" class="btn btn-warning" value="Katkesta">
	<input style="float: right;"name ="exit" type="submit" class="btn btn-success" value="Lisa">
	<br>
	
		
	</div>
</body>
</html>