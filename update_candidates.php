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
		<link rel="stylesheet" href="CSS/styleCandidates.css">
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
			<br><p style="font-size:40px; margin-left: 1%; color: red;"> Welcome to Update Candidate Page.
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href="adminlogout.php"> <u> Logout </u> </a> 
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href="candidates.php"> <u> Candidates </u> </a>
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
$sql = "SELECT * FROM candidate WHERE ID='$ID' ";
$result = mysqli_query($conn, $sql);

if(!$ID){
	header("location:candidates.php");
}

while($row = mysqli_fetch_assoc($result)) {
	$ID = $row['ID'];
	$name = $row['name'];
	$email = $row['email'];
	$post = $row['post'];
	$elecArea = $row['address'];
	
	echo "
	<center> <h1> <u> Update Candidate </u> </h1><br>
	<form action='' method='post'>
		Name: <input type='text' name='name' value='$name' /> <br><br>
		Email: <input type='email' name='email' value='$email' /> <br><br>
		POST: 
			<select name='post'>
				<option value='$post'>$post</option> ";
				if($post == 'Mayor'){
					echo "
					<option value='Councilor'>Councilor</option>
					<option value='Chairman'>Chairman</option>";
				}
				elseif($post == 'Councilor'){
					echo "
					<option value='Mayor'>Mayor</option>
					<option value='Chairman'>Chairman</option>";
				}
				elseif($post == 'Chairman'){
					echo "
					<option value='Mayor'>Mayor</option>
					<option value='Councilor'>Councilor</option>";
				}
		echo "</select> <br><br>
		Area:
			<select name='elecArea'>
				<option value='$elecArea'>$elecArea</option>";
				if($elecArea == 'Dhaka'){
					echo "
					<option value='Chittagong'>Chittagong</option>
					<option value='Sylhet'>Sylhet</option>
					<option value='Rajshahi'>Rajshahi</option>";
				}
				elseif($elecArea == 'Chittagong'){
					echo "
					<option value='Dhaka'>Dhaka</option>
					<option value='Sylhet'>Sylhet</option>
					<option value='Rajshahi'>Rajshahi</option>";
				}
				elseif($elecArea == 'Sylhet'){
					echo "
					<option value='Dhaka'>Dhaka</option>
					<option value='Chittagong'>Chittagong</option>
					<option value='Rajshahi'>Rajshahi</option>";
				}
				elseif($elecArea == 'Rajshahi'){
					echo "
					<option value='Dhaka'>Dhaka</option>
					<option value='Chittagong'>Chittagong</option>
					<option value='Sylhet'>Sylhet</option>";
				}
			echo "</select> <br><br>
			
		
		<input type='submit' name='update' value='Update' />
		</form>
	</center>";
}

if (isset($_POST['update']))
{
	$name = $_POST['name'];
	$email = $_POST['email'];
	$post = $_POST['post'];
	$elecArea = $_POST['elecArea'];
	
	$query = "UPDATE candidate SET name='$name', email='$email', post='$post', address='$elecArea' WHERE ID='$ID'  ";
	
	if (mysqli_query($conn, $query)) {
		header("location:candidates.php");
	}
	else {
		echo "Wrong!!! Try again." . mysqli_error($conn);
	}	
}

mysqli_close($conn);
?>