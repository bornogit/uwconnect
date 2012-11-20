<?php
include('library.php');
session_start();
if (!sessionCheck())
{
	$conn = connect();
	$result = signup($conn, $_POST);
}
else
{	
	echo "<div> <p> You are already connected. Please Logout first and try again </p></div>";
	drawLogout();
}
?>


