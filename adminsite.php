<?php
session_start();
if(!isset ($_SESSION['admin'])){
	header('location:adminlogin.php');
}

if(isset ($_SESSION['nid'])){
	header('location:votersite.php');	
}

//&nbsp; &nbsp;

?>

<html>
	<head> 
		<link rel="stylesheet" type="text/css" href="CSS/styleAdmin.css">
		<style>
			body {
			  background-image: url('CSS/background.jpg');
			  background-size: cover;
			}
		</style>
	</head>
	<body>
		<div class="head">
			<br><p style="font-size:40px; margin-left: 1%; color: red;"> Welcome to admin site.
				<a style="font-size:33px; float:right; margin-right: 1%; color: red;" href="adminlogout.php">Logout</a> 
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href="candidates.php">Candidates</a>
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href="newelection.php">Election</a>
			</p>
		<div>
	</body>

</html>