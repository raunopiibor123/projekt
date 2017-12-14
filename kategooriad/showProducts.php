<?php
require("../../../config.php");
$database = "if17_veebprojekt";
function showProducts($category){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT picname, productname, description, quantity, price, category FROM products WHERE category = '".$category."'");
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

?>