<?php
	$host = "localhost";
	$userDB = "webgyqyy_food";
	$pwdDB = "webgyqyy_food";
	$nmDB = "webgyqyy_food";

	$connecting = mysql_connect($host, $userDB, $pwdDB);
	mysql_select_db($nmDB);

	$mysqli = new mysqli($host, $userDB, $pwdDB, $nmDB);
	if(mysqli_connect_errno()) {
		die('No Connection!' . mysql_error());
	}
?>
