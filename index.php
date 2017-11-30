<?php
	require("../../../config.php");
	require("PHP/functions.php");

	$signupFirstName = "";
	$signupFamilyName = "";
	$signupEmail = "";
	$loginEmail = "";
	$notice ="";
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	
	//Kui on sisseloginud
	if(isset($_SESSION["userID"])){
		header("Location: main.php");
		exit();
	}
	
	//Kas klõpsati sisselogimise nuppu
	if(isset($_POST["signInButton"])){
	
		//kas on kasutajanimi sisestatud
		if (isset ($_POST["loginEmail"])){
			if (empty ($_POST["loginEmail"])){
				$loginEmailError ="NB! Ilma selleta ei saa sisse logida!";
			} else {
				$loginEmail = $_POST["loginEmail"];
			}
		}
		
		//Kas kõik on sisestatud
		if(!empty($loginEmail) and !empty($_POST["loginPassword"])){
			//echo "Logime sisse";
			$notice = signIn($loginEmail, $_POST["loginPassword"]);
			
		}
	}
		if(isset($_POST["signUpButton"])){
	
	//kontrollime, kas kirjutati eesnimi
	if (isset ($_POST["signupFirstName"])){
		if (empty ($_POST["signupFirstName"])){
			$signupFirstNameError ="NB! Eesnime väli on kohustuslik!";
		} else {
			$signupFirstName = cleanInput($_POST["signupFirstName"]);
			
		}
	}
	
	//kontrollime, kas kirjutati perekonnanimi
	if (isset ($_POST["signupFamilyName"])){
		if (empty ($_POST["signupFamilyName"])){
			$signupFamilyNameError ="NB! Perekonnanime väli on kohustuslik!";
		} else {
			$signupFamilyName = cleanInput($_POST["signupFamilyName"]);
		}
	}
	
	//Kas päev on sisestatud
	if (isset ($_POST["signupBirthDay"])){
		$signupBirthDay = $_POST["signupBirthDay"];
		//echo $signupBirthDay;
	}
	
	//Kas kuu on sisestatud
	if(isset($_POST["signupBirthMonth"])){
		$signupBirthMonth = intval($_POST["signupBirthMonth"]);
	}

	//Kas sünnikuupäev on valiidne
	if(isset ($_POST["signupBirthDay"]) and isset ($_POST["signupBirthMonth"]) and isset ($_POST["signupBirthYear"])){
		if(checkdate(intval($_POST["signupBirthMonth"]), intval($_POST["signupBirthDay"]), intval($_POST["signupBirthYear"]))){

			$birthDate = date_create($_POST["signupBirthDay"]. "." . $_POST["signupBirthMonth"]. "." . $_POST["signupBirthYear"]);
			$signupBirthDate = date_format($birthDate, "Y-m-d");
		} else {
			$signupBirthDayError = "Sünnikuupäev on invaliidne";
		}
	} else {
		$signupBirthDayError = "Sünnikuupäev pole määratud";
	}
	
	
	//Kas aasta on sisestatud
	if (isset ($_POST["signupBirthYear"])){
		$signupBirthYear = $_POST["signupBirthYear"];
		//echo $signupBirthYear;
	}
	
	//kontrollime, kas kirjutati kasutajanimeks email
	if (isset ($_POST["signupEmail"])){
		if (empty ($_POST["signupEmail"])){
			$signupEmailError ="NB! E-posti väli on kohustuslik!";
		} else {
			$signupEmail = cleanInput($_POST["signupEmail"]);
			
			$signupEmail = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
			$signupEmail = filter_var($signupEmail, FILTER_VALIDATE_EMAIL);
		}
	}
	
	if (isset ($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
			$signupPasswordError = "NB! Parooli väli on kohustuslik!";
		} else {
			if (strlen($_POST["signupPassword"]) < 8){
				$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			} else{
				$signupPassword = $_POST["signupPassword"];
			}
		}
	}
	
	}
	
	//Tekitame kuupäeva valiku
	$signupDaySelectHTML = "";
	$signupDaySelectHTML .= '<select name="signupBirthDay">' ."\n";
	$signupDaySelectHTML .= '<option value="" selected disabled>päev</option>' ."\n";
	for ($i = 1; $i < 32; $i ++){
		if($i == $signupBirthDay){
			$signupDaySelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupDaySelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ." \n";
		}
		
	}
	$signupDaySelectHTML.= "</select> \n";
	
	//tekitan sünnikuu valiku
	$monthNamesEt = ["jaanuar", "veebruar", "märts", "april", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML ="";
	$signupMonthSelectHTML .= '<select name ="signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .= '<option value="" selected disabled>kuu</option>'."\n";
	foreach($monthNamesEt as $key => $month){
		if($key + 1 === $signupBirthMonth){
			$signupMonthSelectHTML .= '<option value="'.($key+1).'" selected>' .$month."</option> \n";
		} else {
			$signupMonthSelectHTML .= '<option value="'.($key+1).'" >' .$month."</option> \n";
		}
	}
	$signupMonthSelectHTML .="</select> \n";
	
	//Tekitame aasta valiku
	$signupYearSelectHTML = "";
	$signupYearSelectHTML .= '<select name="signupBirthYear">' ."\n";
	$signupYearSelectHTML .= '<option value="" selected disabled>aasta</option>' ."\n";
	$yearNow = date("Y");
	for ($i = $yearNow; $i > 1900; $i --){
		if($i == $signupBirthYear){
			$signupYearSelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupYearSelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ."\n";
		}
		
	}
	$signupYearSelectHTML.= "</select> \n";
	
	//UUE KASUTAJA LISAMINE ANDMEBAASI
	if(!empty($_POST["signupPassword"])){
		$signupPassword = $_POST["signupPassword"];
		signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $signupPassword, $signupEmail);
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
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<div id="inner">
	<h2>Logi sisse!</h2>
		<input  name="loginEmail" type="text" placeholder="E-mail">
		<br><br>
		<input name="loginPassword" placeholder="Salasõna" type="password">
		<br><br>
		<input name ="signInButton" type="submit" class="btn btn-primary" value="Logi sisse">
	</form>
	</div>
	<div id="inner" style="margin-top: 15px;">
	<h2>Loo kasutaja</h2>
	
	<form method="POST">
		<label>Eesnimi </label>
		<input name="signupFirstName" type="text" value="">
		<br>
		<label>Perekonnanimi </label>
		<input name="signupFamilyName" type="text" value="">
		<br><br>
		<label>Sisesta oma Sünnikuupäev</label>
		<?php echo "\n <br> \n" .$signupDaySelectHTML ."\n" .$signupMonthSelectHTML ."\n" .$signupYearSelectHTML ."\n <br> \n";?>
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