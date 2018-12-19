<?php
	session_start();
	if(!isset($_SESSION['user_pur'])){
		echo header('location:../index.php');
	}
?>