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
	<h2>Kategooriad</h2>
	<ul class="list-group">
		<li class="list-group-item">Elektroonika <span class="badge">12</span></li>
		<li class="list-group-item">Koduloomad <span class="badge">6</span></li>
		<li class="list-group-item">Kodutehnika <span class="badge">80</span></li>
	</ul>
	<br>
	<input name ="logout" type="submit" class="btn btn-success" value="Lisa toode!">
	</form>
	</div>
	<div id="inner">
	<h2>Uusimad lisatud tooted</h2>
		<div class="gallery">
			<a target="_blank" href="pildid/meat.jpeg">
				<img src="pildid/meat.jpeg" alt="Meat" width="300" height="200">
			</a>
			<div class="desc">Unikorn meat, 5€/kg</div>
		</div>
		<div class="gallery">
			<a target="_blank" href="pildid/canned-air.jpeg">
				<img src="pildid/canned-air.jpeg" alt="canned-air" width="300" height="200">
			</a>
			<div class="desc">Värske õhk! 10€/l</div>
		</div>
		<div class="gallery">
			<a target="_blank" href="pildid/coke-can.jpeg">
				<img src="pildid/coke-can.jpeg" alt="coke-can" width="300" height="200">
			</a>
			<div class="desc">Tühi coca-cola purk, 50€/tk</div>
		</div>
	</div>
	
	<div id="inner-right">
	<form method="POST">
	<h6>Tere tulemast tagasi: <br> <?php echo $_SESSION["firstName"]. " ". $_SESSION["lastName"] ?></h6>
	<p>Kasutaja loodi:<br> <?php echo date_format($dateCreated, "Y-m-d");?></p>
	
	<input name ="logout" type="submit" class="btn btn-primary" value="Logi välja">
	</form>
	</div>
</body>
</html>