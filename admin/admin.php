<?php
include ('../include/connect.php');
$query = mysql_query("SELECT id_admin, user_admin, pass_admin, md5_admin from tbl_admin");

	// checking the session have been expire or not
	session_start();
	if (isset($_SESSION['Admin'])) {
		$_SESSION['Admin'] = 1;
	} else {
		echo "<script>
			alert('You must login first.. Redirect..');
			window.location='index.php';
		</script>";
	}

// updating admin's data (username and/or password)
function change_admin(){
	$id_admin = $_POST['id-admin'];
	$username = $_POST['username'];
	$password = $_POST['pass'];
	$pass_md5 = md5($password);
	
	if(isset($username) || isset( $password))
	{
		$query = "UPDATE tbl_admin SET user_admin = '$username', pass_admin = '$password', md5_admin = '$pass_md5' WHERE id_admin='$id_admin'";
		$value_update= mysql_query($query) or die(mysql_error()); 
		echo '<script type="text/javascript">
		 window.location = "admin.php";
		</script>';
	}

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PHP Store- Admin Panel</title>
	<link rel="shortcut icon" href="../belanja.png">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">	
	<link rel="stylesheet" href="../css/themes/default/jquery.mobile-1.4.1.css">
	<link rel="stylesheet" href="../_assets/css/jqm-demos.css">
	<script src="../js/jquery.js"></script>
	<script src="../_assets/js/index.js"></script>
	<script src="../js/jquery.mobile-1.4.1.min.js"></script>
	
    <style>
        .nav-search .ui-btn-up-a {
            background-image: none;
            background-color: #333;
        }
        .nav-search .ui-btn-inner {
            border-top: 1px solid #888;
            border-color: rgba(255, 255, 255, .1);
        }
        .nav-search .ui-btn.ui-first-child {
            border-top-width: 0;
            background: #111;
        }
        .userform {
			padding: .8em 1.2em;
		}
        .userform h2 {
			color: #555;
			margin: 0.3em 0 .8em 0;
			padding-bottom: .5em;
			border-bottom: 1px solid rgba(0,0,0,.1);
		}
        .userform label {
			display: block;
			margin-top: 1.2em;
		}
        .ui-grid-a {
			margin-top: 1em;
			padding-top: .8em;
			margin-top: 1.4em;
			border-top: 1px solid rgba(0,0,0,.1);
		}
    </style>
	
	<SCRIPT Language="JavaScript">
	<!--//
	// creating random password with it's length equal with the number which user's typed before 
	function showAndClearField(frm){
	
	  if (frm.firstName.value == "")
		  alert("You didn't input anything!")
	  else{
		var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
		var string_length = frm.firstName.value;
		var randomstring = '';
		var charCount = 0;
		var numCount = 0;

		for (var i=0; i<string_length; i++) {
			// If random bit is 0, there are less than 3 digits already saved, and there are not already 5 characters saved, generate a numeric value. 
			if((Math.floor(Math.random() * 2) == 0) && numCount < 3 || charCount >= 5) {
				var rnum = Math.floor(Math.random() * 10);
				randomstring += rnum;
				numCount += 1;
			} else {
				// If any of the above criteria fail, go ahead and generate an alpha character from the chars string
				var rnum = Math.floor(Math.random() * chars.length);
				randomstring += chars.substring(rnum,rnum+1);
				charCount += 1;
			}
		}
		alert("Password Generate is : " + randomstring)
		frm.firstName.value = ""
		}
	}
	//-->
	</SCRIPT>
	
</head>
<?php
    if(isset($_GET['action'])=='updatefunc') {
        change_admin();
    }
?>
<body>
<?php 
	while( $row = mysql_fetch_row($query)):
?>
<div data-role="page" class="jqm-demos ui-responsive-panel" id="panel-fixed-page1">

    <div data-role="header" data-theme="f" data-position="fixed">
        <h1>Admin Panel</h1>
        <a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
		<a href="logout.php" data-role="button" data-mini="true" data-transition="slide" data-icon="info" data-iconpos="left" data-ajax="false">Logout</a>
    </div><!-- /header -->

    <!-- Content for admin -->
	<div data-role="content" class="jqm-content">
		<a href="#popupAdmin" data-rel="popup" data-position-to="window" data-role="button" data-icon="edit" data-iconshadow="false" data-theme="a">Change</a>
		<div data-role="controlgroup">
			<a href="#" data-role="button">Username : <font color="blue" size="4"><?=$row[1];?></font></a>
			<a href="#" data-role="button">Password : <font color="blue" size="4"><?=$row[2];?></font></a>
		</div>
		
		<form NAME="test">
		<input data-clear-btn="true" NAME="firstName" placeholder="password length.." id="length" value="" type="number">
		<input value="Password Generate" type="button" onClick="showAndClearField(this.form)" data-theme="a" data-icon="gear" data-iconshadow="false">
		</form>
		
		<?
		function ranwd_string( $length ) {

		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);
		}

		?>
		
	</div>
	<!-- /Content for admin -->
	
	<!-- Pop up change admin -->
			<div data-role="popup" id="popupAdmin" data-theme="a" data-overlay-theme="b" class="ui-corner-all">
			<a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
				<form action="?action=updatefunc" method="post" id="add-form" enctype="multipart/form-data" data-ajax="false">
					<div style="padding:10px 20px;">
					  <h3>Change Login Admin.</h3>
					  <label for="type" class="ui-hidden-accessible">Username</label>
					  <input type="text" name="username" id="username" placeholder="" data-theme="a" value="<?=$row[1];?>" required/>
					  <input type="hidden" name="id-admin" value="<?=$row[0];?>"/>
					  
					  <label for="type" class="ui-hidden-accessible">New Password</label>
					  <input type="text" name="pass" id="pass" placeholder="new password.." data-theme="a" value="" required/>
					  
					  <button type="submit" data-theme="b" onClick="update_admin()">Change</button>
					</div>
				</form>
			</div>
	<!-- Pop up change admin -->

    <div data-role="footer" data-position="fixed" data-theme="f">
    	<h4>Copyright &copy; 2017, WEMBO OTEPA MULUMBA</h4>
    </div><!-- /footer -->

	<div data-role="panel" data-position-fixed="true" data-theme="b" id="nav-panel">
		<ul data-role="listview" data-theme="a" class="nav-search">
				<li data-icon="delete" data-theme="b"><a href="#" data-rel="close">Menu List</a></li>
				<li data-icon="carat-r"><a href="product.php" data-ajax="false">All Products</a></li>
				<li data-icon="carat-r"><a href="category.php" data-ajax="false">Product Categories</a></li>
				<li data-icon="carat-r"><a href="store.php" data-ajax="false">Store Partners</a></li>
				<li data-icon="carat-r"><a href="currency.php" data-ajax="false">Currency Format</a></li>
				<li data-icon="carat-r"><a href="admin.php" data-ajax="false">Admin Profil</a></li>
		</ul>
	</div><!-- /panel -->
</div><!-- /page -->
<?endwhile;?>
</body>
</html>
