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

$ElectionID = $_GET['GetID'];
$sql = "SELECT * FROM votehost WHERE ID=$ElectionID";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$ElectionName = $row['name'];
		$ElectionArea = $row['area'];
		echo "ElectionName: ".$ElectionName." ElectionArea: ".$ElectionArea."<br>";
    }
} 
else {
    echo "No election found. <br>";
}


$sql = "SELECT * FROM candidate WHERE post='$ElectionName' AND address='$ElectionArea' ";
$result = mysqli_query($conn, $sql);
$candidateID = array (); $i=0;
$countCandidateID = array ();
$candidateName = array ();

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$candidateID[$i] = $row['ID']; 
		echo $candidateID[$i]."<br>"; 
		$i++;
    }
} 
else {
    echo "No candidate found. <br>";
}


//echo "<br>Count ".count($candidateID);
$maxVote=0;
$maxVoteCandidateID=0;
$maxVoteCandidateName='';

for($i=0; $i<count($candidateID); $i++){
	$sql = "SELECT COUNT(*)as total FROM votecast WHERE electionID='$ElectionID' AND candidateID='$candidateID[$i]' "; 
	$result = mysqli_query($conn, $sql);
	
	while($row = mysqli_fetch_assoc($result)) {
		//echo $candidateID[$i]." vote ".$row['total']."<br>";
		if($maxVote < $row['total']){
			$maxVote = $row['total'];
			$maxVoteCandidateID = $candidateID[$i];
			
		}
	}
}

echo "<br><br>Max Vote got ".$maxVoteCandidateID." which is ".$maxVote."<br><br>";


$sql = "SELECT * FROM candidate WHERE ID='$maxVoteCandidateID'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$maxVoteCandidateName = $row['name'];
    }
} 
else {
    echo "No candidate found";
}

$sql = "UPDATE votehost SET winner='$maxVoteCandidateName' WHERE ID = '$ElectionID' ";
if (mysqli_query($conn, $sql)) {
	header("location:newelection.php");
} 
else {
	echo "Wrong!!! Try again." . mysqli_error($conn); 
}

mysqli_close($conn);
?>