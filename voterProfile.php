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

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/styleVotersite.css">
	</head>
	<body>
		<div class="head"> <br>
			<p style="font-size:35px; margin-left: 1%; color: red;"> Welcome <?php echo $_SESSION['name']; ?> for Online Voting  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				<a style="font-size:35px; float:right; margin-right: 1%; color: red;" href="voterLogout.php">Logout</a>
				<a style="font-size:35px; float:right; margin-right: 2%; color: red;" href="votersite.php">Home</a>
			<p>
		</div>
			
		<div class="body">
			<center> <br> <br>
				<h1> NID No : <?php echo $_SESSION['nid']; ?> </h1> <br>
				<h1> Name : <?php echo $_SESSION['name']; ?> </h1> <br>
				<h1> Address : <?php echo $_SESSION['area']; ?> </h1> <br>
				<h1> Email : <?php echo $_SESSION['email']; ?> </h1> <br>
				<h1> Password : <?php echo $_SESSION['password']; ?> </h1> <br>
				<p style="font-size:40px; color: #000066;"> <a href="editVoterProfile.php">Edit-Profile</a> </p> <br>
			</center>
		</div>
	</body>
	
		<!--$_SESSION['nid'] = $row['NID'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['area'] = $row['area'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['password'] = $row['password']; -->

<?php mysqli_close($conn); ?>
</html>