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
			<br><p style="font-size:40px; margin-left: 1%; color: red;"> Welcome to Add Candidate Page.
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


echo "
<center> <h1> <u> Add Candidate </u> </h1><br>
	<form action='' method='post'>
		Name: <input type='text' name='name' placeholder='Enter Name' required /> <br><br>
		Email: <input type='email' name='email' placeholder='Enter Valid Email' required /> <br><br>
		POST:
			<select name='post'>
				<option value='Mayor'>Mayor</option>
				<option value='Councilor'>Councilor</option>
				<option value='Chairman'>Chairman</option>
			</select> <br><br>
		Area:
			<select name='elecArea'>
				<option value='Dhaka'>Dhaka</option>
				<option value='Chittagong'>Chittagong</option>
				<option value='Sylhet'>Sylhet</option>
				<option value='Rajshahi'>Rajshahi</option>
			</select> <br><br>
		<input type='submit' name='add' value='Add Candidate' />
	</form>
</center>";



if (isset($_POST['add']))
{
	$name = $_POST['name'];
	$email = $_POST['email'];
	$post = $_POST['post'];
	$elecArea = $_POST['elecArea'];
	
	$query = "INSERT INTO candidate (name, email, post, address)
				VALUES ('$name', '$email', '$post', '$elecArea')  ";
	
	if (mysqli_query($conn, $query)) {
		header("location:candidates.php");
	}
	else {
		echo "Wrong!!! Try again." . mysqli_error($conn);
	}	
}

mysqli_close($conn);
?>