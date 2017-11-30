<?php
require("../../../config.php");
$database = "if17_veebprojekt";

session_start();
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $signupPassword, $signupEmail){
		
		$signupPassword = hash("sha512", $_POST["signupPassword"]);
		
		//Ühendus serveriga
			
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//käsk serverlile
		$stmt = $mysqli->prepare("INSERT INTO users (firstname, lastname, birthday, password, email ) VALUES (?, ?, ? ,? ,?)");
		echo $mysqli->error;
		//s - string
		//i - int
		//d - decimal
		$stmt->bind_param("sssss", $signupFirstName, $signupFamilyName, $signupBirthDate, $signupPassword, $signupEmail);
		//$stmt->execute();
		if($stmt->execute()){
			//echo "Õnnestus";
		} else{
			echo "Tekkis viga: ". $stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		
	}
	
	function signIn($email, $password){
		$notice ="";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, password, created, email FROM users WHERE email = ? ");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $firstNameFromDb, $lastNameFromDb, $passwordFromDb, $createdDB, $emailFromDb);
		$stmt->execute();
		
		//Kontrollime kasutajat
		if($stmt->fetch()){
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb){
				$notice = "Kõik korras, logisimegi sisse!";
				
				//Salvestame sessioonimuutujad
				$_SESSION["userID"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				$_SESSION["firstName"] = $firstNameFromDb;
				$_SESSION["lastName"] = $lastNameFromDb;
				$_SESSION["created"] = $createdDB;
				echo $_SESSION["userID"];
				echo"Pask on lahti 4";
				//Liigume pealehele
				header("Location: main.php");
				exit();
			} else {
				echo"Pask on lahti 1";
				$notice = "Sisestasite vale salasõna!";
			}
			
		} else {
			echo"Pask on lahti 2";
			$notice ="Sellist kasutajat {" . $email . "} ei ole!";
		}
		echo"Pask on lahti 3";
		return $notice;
	}
	
	function cleanInput($strToClean){
		$strToClean = trim($strToClean);
		$strToClean = stripslashes($strToClean);
		$strToClean = htmlspecialchars($strToClean);
		return $strToClean;
	}
?>