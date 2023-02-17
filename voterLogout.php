<?php
session_start();
if(isset ($_SESSION['nid'])){
	session_destroy();	
}
header("location:index.php");
?>