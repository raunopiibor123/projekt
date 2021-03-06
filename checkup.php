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
		if(isset($_POST["back"])){
		header("Location: main.php");
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
		display:inline-block;
		width: 40%;
		border: 3px solid #000000;
		padding: 20px;
		border-width: 8px;
		background-color: white;
		border-radius: 15px;
		margin-left: 5%;
	}
	#inner-right{
		float: right;
		width: 15%;
		border: 1px solid #000000;
		padding: 20px;
		border-width: 3px;
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
	</style>
</head>
<body id="grad" style="align: center;">
	<h1 style="text-align: center; color: white;" >Meie projekt™</h1>
	<div id="inner-left">
	<form action="addProducts.php">

	</form>
	</div>
	<div id="inner">
	
	</div>
	
	<div id="inner-right">
	<form method="POST">
	<h6>Tere tulemast tagasi: <br> <?php echo $_SESSION["firstName"]. " ". $_SESSION["lastName"] ?></h6>
	<p>Kasutaja loodi:<br> <?php echo date_format($dateCreated, "Y-m-d");?></p>
	
	<input name ="logout" type="submit" class="btn btn-primary" value="Logi välja">
	<input style="margin-left: 70px;" name ="back" type="submit" class="btn btn-danger" value="Tagasi!">
	</form>
	</div>
</body>
</html>