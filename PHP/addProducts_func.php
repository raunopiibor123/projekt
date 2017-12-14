<?php
require("../../../config.php");
$database = "if17_veebprojekt";
function createCategoryDropdown($array){
	$result = "";
	$result .= "<select name='productCategory' class='form-control'>";
    foreach ($array as $category) {
		$result .='<option value="'.$category.'">'.$category.'</option>';
	}
	$result .="<select>";
	return $result;
}

function addProductToDatabase($userName, $picName, $productName, $description, $quantity, $price, $category){
		
	//Ühendus serveriga
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//käsk serverlile
	$stmt = $mysqli->prepare("INSERT INTO products (username, picname, productname, description, quantity, price, category ) VALUES (?, ?, ? ,? ,?, ?, ?)");
	echo $mysqli->error;
	//s - string
	//i - int
	//d - decimal
	$stmt->bind_param("ssssids", $userName, $picName, $productName, $description, $quantity, $price, $category);
	if($stmt->execute()){
		//echo "Õnnestus";
	} else{
		echo "Tekkis viga: ". $stmt->error;
	}
	$stmt->close();
	$mysqli->close();
}

?>