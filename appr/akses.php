<?php
	session_start();
	if(!isset($_SESSION['user_depthead'])){
		echo header('location:../index.php');
	}
?>