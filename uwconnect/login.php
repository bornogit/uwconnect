<?php
	include('library.php');
	session_start();
	if (!sessionCheck())
	{
		$conn = connect();
		$result = login($_POST['loginHandle'], $_POST['loginPassword']);
		header("Location: index.php");
	}
	else
	{
		onLogOutSuccess();
		header("Location: index.php");
	}
?>


