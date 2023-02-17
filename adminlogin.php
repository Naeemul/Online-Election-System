<?php
session_start();
if(isset ($_SESSION['admin'])){
	header('location:adminsite.php');
}

if(isset ($_SESSION['nid'])){
	header('location:votersite.php');	
}

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
			<form action="" method="post">
				<h1>Administration Login</h1> &nbsp; &nbsp; &nbsp;
				Name: <input type="text" name="name" placeholder="Enter admin name" required /> <br><br>
				Password: <input type="password" name="password" placeholder="Enter admin password" required /> <br><br>
				<input type="submit" name="login" value="Login" />
			</form>
			<a href="registerVoter.php">Register as a Voter</a> <br> <br>
			<a href="index.php">Login Voter </a>
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
		$name = $_POST['name'];
		$password = $_POST['password'];
		$query = "SELECT * FROM admin where name = '$name' AND password = '$password' ";
		$result = mysqli_query($conn,$query);
		
		$rowCount=mysqli_num_rows($result);
		
		if($rowCount==1){
			$row = mysqli_fetch_assoc($result);
			$_SESSION['admin'] = $row['name'];
			header("location:adminsite.php");
		}
		else {
			echo "Wrong!!! Try again.";
		}		
	}

	mysqli_close($conn);
	?>

</html>