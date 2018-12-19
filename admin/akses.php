<?php
	session_start();
	if(!isset($_SESSION['admin'])){
		echo header('location:../index.php');
	}
?>