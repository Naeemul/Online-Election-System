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
			<p style="font-size:35px; margin-left: 1%; color: red;"> Welcome <?php echo $_SESSION['name']; ?> for Online Voting  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				<a style="font-size:35px; float:right; margin-right: 1%; color: red;" href="voterLogout.php">Logout</a>
				<a style="font-size:35px; float:right; margin-right: 2%; color: red;" href="votersite.php">Home</a>
			<p>
		</div>
			
		<div class="body">
			<?php
			$NID = $_SESSION['nid'];
			$name = $_SESSION['name'];
			$area = $_SESSION['area'];
			$email = $_SESSION['email'];
			$password = $_SESSION['password'];
			
			if (isset($_POST['update'])) {
				$nid = $_POST['NID'];
				$name = $_POST['name'];
				$email = $_POST['email'];
				$area = $_POST['area'];
				$Password = $_POST['password'];
				$flag = 0;
				
				if( strlen($nid) != 5 ) {
					$error_msg['NID'] = "[ Only input 5 digit NID number is allowed ]";
					$flag = 1;
				}
				if( strlen($Password) < 5 ) {
					$error_msg['password'] = "[ Given Password is less than 5 characters. Try Again 5 to 8 characters !!! ]";
					$flag = 1;
				}
				if( strlen($Password) > 8 ) {
					$error_msg['password'] = "[ Given Password is greater than 8 characters. Try Again 5 to 8 characters !!! ]";
					$flag = 1;
				}
				
				if($flag == 0){
					$query = "UPDATE voter SET NID='$nid', name='$name', email='$email', area='$area', password	='$Password'  WHERE NID='$NID'  ";
					if (mysqli_query($conn, $query)) {
						$_SESSION['nid'] = $nid;
						$_SESSION['name'] = $name;
						$_SESSION['email'] = $email;
						$_SESSION['area'] = $area;
						$_SESSION['password'] = $Password;
						header("location:voterProfile.php");
					}
					else {
						echo "Wrong!!! Try again. " . mysqli_error($conn);
					}
				}
			}
			
			
			echo "
			<center> 
				<h1> <u> Edit Profile </u> </h1><br>
				<form action='' method='post'>";
				echo "
					Address:
					<select name='area'>
						<option value='$area'>$area</option>";
						if($area == 'Dhaka'){
							echo "
							<option value='Chittagong'>Chittagong</option>
							<option value='Sylhet'>Sylhet</option>
							<option value='Rajshahi'>Rajshahi</option>";
						}
						elseif($area == 'Chittagong'){
							echo "
							<option value='Dhaka'>Dhaka</option>
							<option value='Sylhet'>Sylhet</option>
							<option value='Rajshahi'>Rajshahi</option>";
						}
						elseif($area == 'Sylhet'){
							echo "
							<option value='Dhaka'>Dhaka</option>
							<option value='Chittagong'>Chittagong</option>
							<option value='Rajshahi'>Rajshahi</option>";
						}
						elseif($area == 'Rajshahi'){
							echo "
							<option value='Dhaka'>Dhaka</option>
							<option value='Chittagong'>Chittagong</option>
							<option value='Sylhet'>Sylhet</option>";
						}
					echo "</select> <br><br>";
					echo "
					&nbsp; &nbsp; &nbsp; &nbsp;
					NID: <input type='number' name='NID' value='$NID' /> <br><br> ";
					if(isset($error_msg['NID'])){
						echo "<p style='font-size:18px; color: red;'>".$error_msg['NID']."</p> <br>";
					}
					
					echo " &nbsp; &nbsp;
					Name: <input type='text' name='name' value='$name' /> <br><br> &nbsp; &nbsp;  
					Email: <input type='email' name='email' value='$email' /> <br><br> 
					Password: <input type='text' name='password' value='$password' /> <br><br>";
					if(isset($error_msg['password'])){
						echo "<p style='font-size:18px; color: red;'>".$error_msg['password']."</p> <br>";
					}
					
					echo "<input type='submit' name='update' value='Update' />
				</form>
			</center>";

		mysqli_close($conn);
		?>
			
		</div>
	</body>
</html>