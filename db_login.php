<?php
	$host="192.7.1.239";
	$user="postgres";
	$password="raditya";
	$port="5432";
	$dbname="DB_MR_TEST";
	$conn = pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$password) 
	or die ('An error occurred: '.pg_errormessage());
?>