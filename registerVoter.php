<?php
session_start();
if(isset ($_SESSION['admin'])){
	header('location:adminsite.php');
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
	
	if (isset($_POST['register'])) {
		$flag=0; $NID = $_POST['NID']; $password = $_POST['password'];
		if( strlen($NID) != 5 ) {
			$error_msg['NID'] = "[ Only input 5 digit NID number is allowed ]";
			$flag = 1;
		}
		if( strlen($password) < 5 ) {
			$error_msg['password'] = "[ Given Password is less than 5 characters. Try Again !!! ]";
			$flag = 1;
		}
		if( strlen($password) > 8 ) {
			$error_msg['password'] = "[ Given Password is greater than 8 characters. Try Again !!! ]";
			$flag = 1;
		}
		
		
		if($flag == 0){
		
		$sql = "INSERT INTO voter (NID, name, area, email, password) 
				VALUES ('$_POST[NID]', '$_POST[name]', '$_POST[area]', '$_POST[email]', '$_POST[password]')";
		
		if (mysqli_query($conn, $sql)){
			echo "<h3>Registration successfully done.</h3>";
		} 
		else{
			echo "Error: " . mysqli_error($conn);
		}
		
		}
		
	}

	mysqli_close($conn);
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
				<h1> <u> Voter Registration Form </u> </h1>
				Area:
				<select name="area">
					<!-- <option selected="" disabled >Select</option> -->
					<option value="Dhaka">Dhaka</option>
					<option value="Chittagong">Chittagong</option>
					<option value="Sylhet">Sylhet</option>
					<option value="Rajshahi">Rajshahi</option>
				</select> <br><br>  &nbsp;&nbsp; &nbsp;
				Name: <input type="text" name="name" placeholder="Enter your proper name" required /> <br><br> &nbsp;&nbsp; &nbsp; 
				Email: <input type="email" name="email" placeholder="Enter valid email" required /> <br><br>
				NID NO: <input type="number" name="NID" placeholder="Your 5 digit NID NO" required /> <br> 
				<?php
				if(isset($error_msg['NID'])){
					echo "<p style='font-size:18px; color: red;'>".$error_msg['NID']."</p>";
				}
				?> <br>
				Password: <input type="password" name="password" placeholder="Must be 5 to 8 characters" required /> <br>
				<?php
				if(isset($error_msg['password'])){
					echo "<p style='font-size:18px; color: red;'>".$error_msg['password']."</p> <br>";
				}
				?> 
				<input type="submit" name="register" value="Register" />
			</form>
			<a href="index.php">Login Voter </a> <br> <br>
			<a href="adminlogin.php">Admin Login:</a> 
		</center>
	</body>
</html>

