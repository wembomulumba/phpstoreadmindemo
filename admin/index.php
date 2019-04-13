<?php
	include('../include/connect.php');

	// checking the session have been expire or not
	session_start();
	if (isset($_SESSION['Admin'])) {
		$_SESSION['Admin'] = 1;
		echo "<script> window.location='product.php'; </script>";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Store | Admin Panel</title>
		<link rel="shortcut icon" href="../belanja.png">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">	
		<link rel="stylesheet" href="../css/themes/default/jquery.mobile-1.4.1.css">
		<link rel="stylesheet" href="../_assets/css/jqm-demos.css">
		<script src="../js/jquery.js"></script>
		<script src="../_assets/js/index.js"></script>
		<script src="../js/jquery.mobile-1.4.1.min.js"></script>
    	<style type="text/css">
    		.contentView {
    			width: 480px;
    			margin: 0 auto;
    		}

    		.contentView form {
    			padding: 25px;
    		}
    	</style>
	</head>
	<body>
		<div data-role="page" class="jqm-demos">
			<div data-role="header" data-position="fixed" data-theme="f">
				<h1>Belanja</h1>
			</div> <!-- end of header -->

			<div class="jqm-content">
				<div class="contentView">
					<form action="dologin.php" method="post" id="admin-form" data-ajax="false">
						<div data-role="fieldcontain">
							<label for="name">User Name: </label>
							<input type="text" name="admin" id="name" required />
						</div>

						<div data-role="fieldcontain">
							<label for="name">Password: </label>
							<input type="password" name="pass" id="name" required />
						</div>

						<fieldset class="ui-grid-solo">
							<div class="ui-block-a"><button type="submit" data-theme="a">Log In</button></div>
						</fieldset>
					</form>
					
					<fieldset class="ui-grid-a">
						<div class="ui-block-a" style="padding:2px;"><button >Username: <font color="red">Admin</font></button></div>
						<div class="ui-block-b" style="padding:2px;"><button >Password: <font color="red">12345</font></button></div>
					</fieldset>
				</div>
			</div> <!-- end of content -->

			<div data-role="footer" data-position="fixed" data-theme="f">
			   <h4>Copyright &copy; 2017, WEMBO OTEPA MULUMBA</h4>
			</div>
		</div>
	</body>
</html>