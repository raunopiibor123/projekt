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
				
				//Liigume pealehele
				header("Location: main.php");
				exit();
			} else {
				$notice = "Sisestasite vale salasõna!";
			}
			
		} else {
			
			echo "Sellist kasutajat {" . $email . "} ei ole!";
		}
		return $notice;
	}
	
	function showLatestProducts(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT picname, productname, description, quantity, price, category FROM products WHERE added >= current_timestamp - interval '10' day");
		$stmt->bind_result($picName, $productName, $productDescription, $productQuantity, $productPrice, $productCategory);
		$stmt->execute();
		$result="";
		
		
		while($stmt->fetch()){
			$result .= '<div class="gallery">';
				$result .= '<a target="_blank" href="pildid/'. $picName .'">';
					$result .='<img src="pildid/'. $picName .'" alt="'. $picName .'">';
				$result.='</a>';
				$result.='<div class="desc">'. $productName.', '.$productDescription.', '.$productQuantity.', '.$productPrice.'€ </div>';
			$result.='</div>';
		}
		return $result;
	}
	
	function cleanInput($strToClean){
		$strToClean = trim($strToClean);
		$strToClean = stripslashes($strToClean);
		$strToClean = htmlspecialchars($strToClean);
		return $strToClean;
	}
?>