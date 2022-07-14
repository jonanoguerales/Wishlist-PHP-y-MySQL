<?php 
$conn = new mysqli("localhost","Jonathan","Jonathan12","wishlist");
 
if($conn->connect_error){
	die("Error de conexión" . $conn->connect_error);	
}
?>