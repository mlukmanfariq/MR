<?php
	session_start();
	if(!isset($_SESSION['user_view'])){
		echo header('location:../index.php');
	}
?>