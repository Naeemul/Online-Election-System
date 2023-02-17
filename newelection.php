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
			<br><p style="font-size:40px; margin-left: 1%; color: red;"> Welcome to Election detail page.
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href="adminlogout.php"> <u> Logout </u> </a>
				<a style="font-size:33px; float:right; margin-right: 2%; color: red;" href='adminsite.php'> <u> Home </u> </a>				
			</p>
		</div> <br>
		<center>
			<h1> Add New Election </h1> <br>
			<form action="" method="post">
				Election Type: <!-- <input type="text" name="elecName" placeholder="Enter Election Name" required /> <br><br> -->
					<select name="elecName">
						<!-- <option selected="" disabled >Select</option> -->
						<option value="Mayor">Mayor</option>
						<option value="Councilor">Councilor</option>
						<option value="Chairman">Chairman</option>
					</select> <br><br>
				Election Area:
					<select name="elecArea">
						<!-- <option selected="" disabled >Select</option> -->
						<option value="Dhaka">Dhaka</option>
						<option value="Chittagong">Chittagong</option>
						<option value="Sylhet">Sylhet</option>
						<option value="Rajshahi">Rajshahi</option>
					</select> <br><br>
				<!-- Number of Candidates: <input type="number" name="numofcan" placeholder="Enter Number of Candidates" required /> <br><br> -->
				Election Date: <input type="date" name="elecDate" placeholder="Enter Election Date" required /> <br><br>
				<input type="submit" name="create" value="Create New Election" />
			</form>
		</center>
	</body>
	
	<?php

	if (isset($_POST['create']))
	{
		$elecName = $_POST['elecName'];
		$elecArea = $_POST['elecArea'];
		$elecDate = date( 'Y-m-d', strtotime( $_POST['elecDate'] ) );
		
		$query = "INSERT INTO votehost (name, area, date, freeze)
					VALUES ('$elecName','$elecArea', '$elecDate', 'no')";
					
		if (mysqli_query($conn, $query)) {
			//$_SESSION['status'] = "Create New Election Succesfully.";
			header("location:newelection.php");
		}
		else {
			echo "Wrong!!! Try again." . mysqli_error($conn);
		}		
	}
	
	$sql = "SELECT * FROM votehost";
	$result = mysqli_query($conn, $sql); ?>

	<br><br><br><h1 style="text-align: center;"> <u> Show Election Details </u> </h1>

	<div class='table-box'>
		<div class='table-row table-head'>
			<div class='table-cell'>
			<p>Election Name</p> </div> 
			
			<div class='table-cell'>
			<p>Election Area</p> </div>
			
			<div class='table-cell'>
			<p>Election Date</p> </div> 
			
			<div class='table-cell'>
			<p>Winner</p> </div> 
			
			<div class='table-cell'>
			<p>Freeze-Status</p> </div> 
			
			<div class='table-cell'>
			<p>Update</p> </div>
			
			<div class='table-cell last-cell'>
			<p>Delete</p> </div>
		</div>
	 <?php
$i=1; $date = date("Y-m-d");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$ID = $row['ID']; ?>
		
		<div class='table-row'>
			<div class='table-cell'>
				<p> <?php echo $row['name']." Election" ?> </p> 
			</div> 
				
			<div class='table-cell'>
				<p> <?php echo $row['area'] ?> </p> 
			</div> 
				
			<div class='table-cell'>
				<p> <?php echo $row['date'] ?> </p> 
			</div> 
				
			<div class='table-cell'>
				<?php
				if($row['winner'] == ''){ ?>
					<p> Not Declare </p> <?php
					if($date > $row['date'] ){ ?>
						<br><p> (Want to process result then <?php echo "<a href='resultProcess.php?GetID=$ID '> <u> Click </u> </a>" ?> ) </p> <?php
					}
				}
				else{ ?>
					<p> <?php echo $row['winner'] ?> </p> <?php
				} ?>					
			</div> 
				
			<div class='table-cell'>
				<?php
				if($row['freeze'] == 'no'){ ?>
					<p>Not Freeze <br> (Want to freeze then <?php echo " <a href='freezeElection.php?GetID=$ID '> <u> Click </u> </a>" ?> )</p> <?php
				}
				elseif ($row['freeze'] == 'yes'){ ?>
					<p>Freeze <br> (Want to cancel freeze then <?php echo " <a href='NotFreezeElection.php?GetID=$ID '> <u> Click </u> </a>" ?> ) </p> <?php
				} ?>
			</div> 
				
			<div class='table-cell'>
				<p> <?php echo " <a href='updateElection.php?GetID=$ID'> <u> Click-Update </u> </a>" ?> </p>
			</div> 
				
			<div class='table-cell'>
				<p> <?php echo " <a href='deleteElection.php?GetID=$ID'> <u> Click-Delete </u> </a>" ?> </p> 
			</div> 
		</div>
		<?php
    } ?>
	</div> <?php
}
else {
    echo "0 results";
}

	mysqli_close($conn);
	?>
</html>
