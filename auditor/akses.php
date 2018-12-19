<?php
	session_start();
	if(!isset($_SESSION['auditor'])){
		echo header('location:../index.php');
	}
?>