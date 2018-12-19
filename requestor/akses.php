<?php
	session_start();
	if(!isset($_SESSION['user'])){
		echo header('location:../index.php');
	}
?>