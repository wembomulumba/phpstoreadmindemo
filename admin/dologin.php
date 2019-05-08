<?php
	ob_start();
	require_once('../include/connect.php');

	$username = $_POST['admin'];
	$password = $_POST['pass'];
	$md5Pwd = md5($password);

	$checkLogin = mysql_query("SELECT user_admin, md5_admin FROM tbl_admin WHERE user_admin='". $username ."' AND md5_admin='". $md5Pwd ."'");

	// counting the numbers of rows
	$rowCount = mysql_num_rows($checkLogin);

	if ($rowCount > 0) {
		echo "<script> alert('Admin page.. Redirect..'); </script>";
		session_start();
		$_SESSION['Admin'] = 1;	// Store session data
		echo "<script> window.location='product.php'; </script>";
	} else {
		echo "<script>
			alert('You are not an admin.. Redirect..');
			window.location='index.php';
		</script>";
	}

	ob_flush();
?>
