<?php
session_start();
if(!isset ($_SESSION['admin'])){
	header('location:adminlogin.php');
}

if(isset ($_SESSION['nid'])){
	header('location:votersite.php');	
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elction";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$ID = $_GET['GetID'];
$query = "UPDATE votehost SET freeze='no' WHERE ID='$ID'  ";
if (mysqli_query($conn, $query)) {
	header("location:newelection.php");
}
else {
	echo "Wrong!!! Try again." . mysqli_error($conn);
}

?>