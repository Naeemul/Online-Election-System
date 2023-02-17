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
		<div class="head"> <br>
			<p style="font-size:35px; margin-left: 1%; color: red;"> Welcome <?php echo $_SESSION['name'] ; ?> for Online Voting  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				<a style="font-size:35px; float:right; margin-right: 1%; color: red;" href="voterLogout.php">Logout</a>
				<a style="font-size:35px; float:right; margin-right: 2%; color: red;" href="voterProfile.php">Profile</a>
			<p>
		</div>
			
		<div class="body">
			<div class="box">
				<center>
					<form action="" method="post"> <br>
						<p style="font-size:30px; color: white;">Select Election ID: </p> <br>
						<select style="font-size:20px; background-color: #4CAF50; color: white;" name="elecID"> 
							<option selected="" value="select" >Select</option>
							<?php 
								$query1 = "SELECT * FROM votehost ";
								$result1 = mysqli_query($conn, $query1);
								$ElectionID; $ElectionName; $ElectionDate;
								while($row1 = mysqli_fetch_assoc($result1)) {
									$ElectionID = $row1['ID'];
									$ElectionName = $row1['name'];
									$ElectionDate = $row1['date'];
									echo " <option value='$ElectionID'>$ElectionID</option> ";
								}
							?>
						</select>  &nbsp; &nbsp; 
						<input type="submit" name="vote" value="Press" />
					</form> <br>
				<center>
			
	
		<?php

		if (isset($_POST['vote']))
		{
			$elecID = $_POST['elecID'];
			if($elecID=='select'){ ?>
				<p style="font-size:25px; color: #000066;"> Please Select Election Type </p> <?php
			}
			else 
			{
				$query1 = "SELECT * FROM votehost where ID = '$elecID' ";
				$result1 = mysqli_query($conn, $query1);
				while($row1 = mysqli_fetch_assoc($result1)) {
					$ElectionID = $row1['ID'];
					$ElectionName = $row1['name'];
					$ElectionArea = $row1['area'];
					$ElectionDate = $row1['date'];
					$FreezeStatus = $row1['freeze'];
				}
				$NID = $_SESSION['nid'];
				$VoterArea = $_SESSION['area']; ?>
				<p style="font-size:24px; color: #000066;"> Election ID: <?php echo $ElectionID ?> <br>Election Name: <?php echo $ElectionName ?> election<br>Election Area: <?php echo $ElectionArea ?> <br>Election Date: <?php echo $ElectionDate ?> </p> <br>
				
				<?php
				if($FreezeStatus == 'no')
				{
					$date = date("Y-m-d");
					if($date == $ElectionDate)
					{
						if($VoterArea == $ElectionArea){
							$query2 = "SELECT * FROM votecast where electionID = '$ElectionID' AND voterID = '$NID' "; //Cheacking Vote done query
							$result2 = mysqli_query($conn, $query2);
							$check = 0;
							
							while($row2 = mysqli_fetch_assoc($result2)) {
								$check = $row2['electionID'];
							}
							if($check == 0)
							{
								$query = "SELECT * FROM candidate where post = '$ElectionName' AND address = '$ElectionArea' ";
								$result = mysqli_query($conn, $query);
								$i=0;
								$candidate = array();
								
								echo "<p style='font-size:25px; color: #000066;'> Select Candidate: </p> ";
								echo " <form action='voteComplete.php'  method='post'> ";
								while($row = mysqli_fetch_assoc($result)) {
									$candidate [$i] = $row['ID'];
									echo " <p style='font-size:21px; color: #000066;'> <input type='radio' name='candidateID' value='$candidate[$i]'/> ".$row['name']."</p>";
									echo "	<input type='hidden' name='electionID' value='$ElectionID'/> ";
									$i++;
								} 
								echo " <input type='submit' name='voteCandidate' value='Press' /> ";
								echo " </form> ";
							}
							else{
								echo "<p style='font-size:24px; color: #000066;'> You already complete your vote. </p>";
							}
						}
						else{
							echo "<p style='font-size:24px; color: #000066;'> You are not eligibale to vote ".$ElectionArea." area. You can vote only ".$VoterArea." area. </p>";
						}
					}
					
					elseif($date < $ElectionDate) {
						echo "<p style='font-size:24px; color: #000066;'> Today is ".$date.". Only ".$ElectionArea." area's voters can vote on this ".$ElectionDate. " Date. </p>";
					}
					
					elseif($date > $ElectionDate) {
						$query = "SELECT COUNT(*)as total FROM votecast where electionID=$ElectionID "; ///Total vote count query
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)){
							echo "<p style='font-size:24px; color: #000066;'> Election is completed. Election Result --- <br>";
							echo "Total Vote drop from Voter : ".$row['total']."<br>";
							
							$candidateID = array(); $candidateName = array(); $i=0;
							$queryNew = "SELECT * FROM candidate where post = '$ElectionName'  AND address = '$ElectionArea' "; //All candidate show query in this election area
							$resultNew = mysqli_query($conn, $queryNew);
							while($rowNew = mysqli_fetch_assoc($resultNew)) {
								$candidateID [$i] = $rowNew['ID']; 
								$candidateName [$i] = $rowNew['name'];	$i++;
							}
							echo "Total Candidate : ".count($candidateID)."<br>";
							
							echo "Candidate : ";
							for($i=0;$i<count($candidateID);$i++){
								echo ($i+1).") ".$candidateName [$i].". ";
							}
						}
						$query = "SELECT * FROM votehost where ID=$ElectionID ";
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)){
							$winner = $row['winner'];
						}
						if($winner == ''){
							echo "<br>Wineer is not declare from Election Commission.";
						}
						else{
							echo "<br>Winner is ".$winner;
						}
					}
					
				}
				elseif($FreezeStatus == 'yes'){
					echo "<p style='font-size:24px; color: #000066;'> Sorry!!! Election is freeze by Election Commission. </p>";
				}
			}
		}

		mysqli_close($conn);
		?>
			</div>
		</div>
		
	</body>

</html>