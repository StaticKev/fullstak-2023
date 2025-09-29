
<?php
	$con = new mysqli("localhost", "root", "", "fullstack");

	if ($con->connect_errno) {
		die("Failed: " . $con->connect_error);
	}
?>