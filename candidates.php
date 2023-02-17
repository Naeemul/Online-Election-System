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

?>

<html>
	<head> 
		<link rel="stylesheet" href="CSS/styleCandidates.css">
	</head>
	<body>
		<div class="head">
			<br><p style="font-size:40px; margin-left: 1%; color: red;"> Welcome to Candidate detail page.
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href="adminlogout.php"> <u> Logout </u> </a> 
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href="adminsite.php"> <u> Home </u> </a>
			</p>
		</div>
	</body>

</html>

<?php


$sql = "SELECT * FROM candidate";
$result = mysqli_query($conn, $sql); ?>

	<center>
		<br><a style="font-size:30px; color: red;" href='add_candidates.php'> <u> ADD-Candidate </u> </a>
	</center>

	<div class='table-box'>
		<div class='table-row table-head'>
			<div class='table-cell'>
			<p>Name</p> </div> 
			
			<!-- <div class='table-cell'>
			<p>Email</p> </div> -->
			
			<div class='table-cell'>
			<p>Post</p> </div> 
			
			<div class='table-cell'>
			<p>Area</p>  </div> 
			
			<div class='table-cell'>
			<p>Update</p>  </div> 
			
			<div class='table-cell last-cell'>
			<p>Delete</p>  </div>
		</div>
	
	<?php
$i=1;

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	
		
    while($row = mysqli_fetch_assoc($result)) {
			$ID = $row['ID']; ?>
			
			<div class='table-row'>
				<div class='table-cell'>
					<p> <?php echo $row['name'] ?> </p> 
				</div> 
				
				<!-- <div class='table-cell'>
					<p> <?php //echo  $row['email'] ?> </p> 
				</div> -->
				
				<div class='table-cell'>
					<p> <?php echo $row['post'] ?> </p> 
				</div>
				
				<div class='table-cell'>
					<p> <?php echo $row['address'] ?> </p> 
				</div>
				
				<div class='table-cell'>
					<p> <?php echo " <a href='update_candidates.php?GetID=$ID'> <u> click-Update </u> </a> "?> </p>
				</div>
				
				<div class='table-cell last-cell'>
					<p> <?php echo " <a href='delete_candidates.php?GetID=$ID'> <u> click-Delete </u> </a> "?> </p>
				</div>
			</div>
		<?php
    } ?>
	</div>
		
	<?php
} 
else {
    echo "0 results";
}

mysqli_close($conn);
?>
