<?php
session_start();
if(isset ($_SESSION['admin'])){
	header('location:adminsite.php');
}

if(!isset ($_SESSION['nid'])){
	header('location:index.php');
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

$NID = $_SESSION['nid'];
//echo $NID."<br>";

$ElectionID = $_POST['electionID'];
//echo $ElectionID."<br>";

$CandidateID = $_POST['candidateID'];
//echo $CandidateID."<br>"; */

$sql = "INSERT INTO voteCast (electionID, voterID, candidateID) 
       VALUES ('$ElectionID', '$NID', '$CandidateID')";
	   
if (mysqli_query($conn, $sql)) {
	header("location:votersite.php");
}
else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

