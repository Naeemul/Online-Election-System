<?php
session_start();
if(!isset ($_SESSION['admin'])){
	header('location:adminlogin.php');
}

if(isset ($_SESSION['nid'])){
	header('location:votersite.php');	
}
?>
 
<html>
	<head> 
		<link rel="stylesheet" href="CSS/styleElection.css">
		<style> 
			input[type=submit] {
			  background-color: #4CAF50;
			  border: none;
			  color: white;
			  padding: 8px 16px;
			  text-decoration: none;
			  margin: 4px 2px;
			  cursor: pointer;
			}
		</style>
	</head>
	<body>
		<div class="head">
			<br><p style="font-size:40px; margin-left: 1%; color: red;"> Welcome to Election Update Page.
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href="adminlogout.php">Logout</a>
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href='adminsite.php'>Adminsite</a>
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href="newelection.php">Election</a>				
			</p>
		</div> <br>
	</body>

</html>

<?php
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

$ID=$_GET['GetID'];
$sql = "SELECT * FROM votehost WHERE ID='$ID' ";
$result = mysqli_query($conn, $sql);

if(!$ID){
	header("location:newelection.php");
}

while($row = mysqli_fetch_assoc($result)) {
	$ElectionName = $row['name'];
	$ElectionArea = $row['area'];
	$ElectionDate = $row['date'];
	
	echo "
	<center> <h1> <u> Update Election </u> </h1><br>
	<form action='' method='post'>
		Election Type: 
			<select name='electionName'>
				<option value='$ElectionName'>$ElectionName</option> ";
				if($ElectionName == 'Mayor'){
					echo "
					<option value='Councilor'>Councilor</option>
					<option value='Chairman'>Chairman</option>";
				}
				elseif($ElectionName == 'Councilor'){
					echo "
					<option value='Mayor'>Mayor</option>
					<option value='Chairman'>Chairman</option>";
				}
				elseif($ElectionName == 'Chairman'){
					echo "
					<option value='Mayor'>Mayor</option>
					<option value='Councilor'>Councilor</option>";
				}
		echo "</select> <br><br>
		Area:
			<select name='electionArea'>
				<option value='$ElectionArea'>$ElectionArea</option>";
				if($ElectionArea == 'Dhaka'){
					echo "
					<option value='Chittagong'>Chittagong</option>
					<option value='Sylhet'>Sylhet</option>
					<option value='Rajshahi'>Rajshahi</option>";
				}
				elseif($ElectionArea == 'Chittagong'){
					echo "
					<option value='Dhaka'>Dhaka</option>
					<option value='Sylhet'>Sylhet</option>
					<option value='Rajshahi'>Rajshahi</option>";
				}
				elseif($ElectionArea == 'Sylhet'){
					echo "
					<option value='Dhaka'>Dhaka</option>
					<option value='Chittagong'>Chittagong</option>
					<option value='Rajshahi'>Rajshahi</option>";
				}
				elseif($ElectionArea == 'Rajshahi'){
					echo "
					<option value='Dhaka'>Dhaka</option>
					<option value='Chittagong'>Chittagong</option>
					<option value='Sylhet'>Sylhet</option>";
				}
				else{
					echo "
					<option value='Dhaka'>Dhaka</option>
					<option value='Chittagong'>Chittagong</option>
					<option value='Sylhet'>Sylhet</option>
					<option value='Rajshahi'>Rajshahi</option>";
				}
		echo "</select> <br><br>
		Election Date: <input type='date' name='electionDate' value='$ElectionDate' /> <br><br>
		<input type='submit' name='update' value='Update' />
		</form>
		</center>";
}

if (isset($_POST['update']))
{
	$name = $_POST['electionName']; 
	$area = $_POST['electionArea'];
	$date = date( 'Y-m-d', strtotime( $_POST['electionDate'] ) );
	
	$query = "UPDATE votehost SET name='$name', area='$area', date='$date', winner='' WHERE ID='$ID' ";
	
	if (mysqli_query($conn, $query)) {
		header("location:newelection.php");
	}
	else {
		echo "Wrong!!! Try again." . mysqli_error($conn);
	}	
}

mysqli_close($conn);
?>