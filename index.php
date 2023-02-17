<?php
session_start();
if(isset ($_SESSION['admin'])){
	header('location:adminsite.php');
}

if(isset ($_SESSION['nid'])){
	header('location:votersite.php');	
}
//&nbsp; &nbsp;

?>

<html>
	<head>
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
		<center>
			<h1> Voters Login Page </h1>
			<form action="" method="post">
				Voter NID: <input type="text" name="nid" placeholder="Enter NID" /> <br><br> &nbsp;
				Password: <input type="password" name="password" placeholder="Enter Password" /> <br><br>
				<input type="submit" name="login" value="Login" />
			</form>
			<a href="registerVoter.php">Register as a Voter</a> <br> <br>
			<a href="adminlogin.php">Admin Login:</a> <br>
		</center>
	</body>
	
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

	if (isset($_POST['login']))
	{
		$nid = $_POST['nid'];
		$password = $_POST['password'];
		$query = "SELECT * FROM voter where NID = '$nid' AND password = '$password' ";
		$result = mysqli_query($conn,$query);
		
		$rowCount=mysqli_num_rows($result);
		
		if($rowCount==1){
			$row = mysqli_fetch_assoc($result);
			$_SESSION['nid'] = $row['NID'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['area'] = $row['area'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['password'] = $row['password'];
			header("location:votersite.php");
		}
		else {
			echo "Wrong!!! Try again.";
		}		
	}

	mysqli_close($conn);
	?>

</html>
