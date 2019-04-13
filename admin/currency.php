<?php
include ('../include/connect.php');
$query = mysql_query("SELECT id_currency, type_currency from tbl_currency");

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

// changing currency's format
function change_currency(){
$id_currency = $_POST['id-currency'];
$currency = $_POST['currency'];
	if(isset($id_currency)||isset($currency))
	{
		$query = "UPDATE tbl_currency SET type_currency = '$currency' WHERE id_currency='$id_currency'";
		$value_update= mysql_query($query) or die(mysql_error()); 
		echo '<script type="text/javascript">
		 window.location = "currency.php";
		</script>';
	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Currency- Admin Panel</title>
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
</head>
<?php
    if(isset($_GET['action'])=='updatefunc') {
        change_currency();
    }
?>
<body>
<?php 
	while( $row = mysql_fetch_row($query)):
?>
<div data-role="page" class="jqm-demos ui-responsive-panel" id="panel-fixed-page1">

    <div data-role="header" data-theme="f" data-position="fixed">
        <h1>Currency</h1>
        <a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
		<a href="logout.php" data-role="button" data-mini="true" data-transition="slide" data-icon="info" data-iconpos="left" data-ajax="false">Logout</a>
    </div><!-- /header -->

    <!-- Content for currency -->
	<div data-role="content" class="jqm-content">
	<a href="#popupCurrency" data-rel="popup" data-position-to="window" data-role="button" data-icon="edit" data-iconshadow="false" data-theme="a">Change</a>
		<div data-role="controlgroup">
			<a href="#" data-role="button"><font size="6"><?=$row[1];?></font></a>
		</div>
	</div>
	<!-- /Content for currency -->
	
	<!-- Pop up change currency -->
			<div data-role="popup" id="popupCurrency" data-theme="a" data-overlay-theme="b" class="ui-corner-all">
			<a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
				<form action="?action=updatefunc" method="post" id="add-form" enctype="multipart/form-data" data-ajax="false">
					<div style="padding:10px 20px;">
					  <h3>Change currency.</h3>
					  <label for="type" class="ui-hidden-accessible">Currency</label>
					  <input type="text" name="currency" id="currency" placeholder="" data-theme="a" value="<?=$row[1]; ?>" required/>
					  <input type="hidden" name="id-currency" value="<?=$row[0];?>"/>
					  <button type="submit" data-theme="f" onclick="change_currency()">Change</button>
					</div>
				</form>
			</div>
	<!-- Pop up change currency -->

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
