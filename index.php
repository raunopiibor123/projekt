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
	
	#inner {
		align: center;
		margin: auto;
		width: 50%;
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
	</style>
</head>
<body id="grad" style="align: center;">
	<div>
	<h1 style="text-align: center; color: white;" >Meie projekt™</h1>
	
	<form method="POST">
	<div id="inner">
	<h2>Logi sisse!</h2>
		<input  name="loginEmail" type="text" placeholder="Kasutajanimi">
		<br><br>
		<input name="loginPassword" placeholder="Salasõna" type="password">
		<br><br>
		<input name ="signInButton" type="submit" class="btn btn-primary" value="Logi sisse">
	</form>
	</div>
	<div id="inner" style="margin-top: 15px;">
	<h2>Loo kasutaja</h2>
	
	<form method="POST">
	<form method="POST">
		<label>Eesnimi </label>
		<input name="signupFirstName" type="text" value="">
		<br>
		<label>Perekonnanimi </label>
		<input name="signupFamilyName" type="text" value="">
		<br><br>
		<label>Sisesta oma Sünnikuupäev</label>
		
		<br><br>
		<label>Sugu</label><span>
		<br>
		<!-- Kõik läbi POST'i on string!!! -->
		<input type="radio" name="gender" value="1"><label>Mees</label> 
		<input type="radio" name="gender" value="2"><label>Naine</label>
		<br><br>
		
		<label>Kasutajanimi (E-post)</label>
		<input name="signupEmail" type="email" value="">
		<br><br>
		<input name="signupPassword" placeholder="Salasõna" type="password">
		<br><br>
		
		<input class="btn btn-primary" name ="signUpButton" type="submit" value="Loo kasutaja">
		<span>
		</span>
	</form>
	</div>
</body>
</html>