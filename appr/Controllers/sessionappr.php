<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	
	
	$header_id = $_REQUEST['header_id'];
	$_SESSION['appr_mr'] = $header_id;

	
	header("location: ../appr_form_request.php");
?>