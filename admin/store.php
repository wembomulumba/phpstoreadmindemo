<?
include ('../include/connect.php');
$query = mysql_query("SELECT id_store, store_name, store_address, store_phone, store_web, store_logo from tbl_store ORDER BY store_name ASC");

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

// adding store's data into database
function insert_store(){
$store_name = $_POST['store_name'];
$store_address = $_POST['store_address'];
$store_phone = $_POST['store_phone'];
$store_web = $_POST['store_web'];
$store_logo = $_FILES['store_logo']['name'];
	
	if(isset($store_name)&&isset($store_address)&&isset($store_phone)&&isset($store_web))
	{
		if ($_FILES['store_logo']['size'] < 1024*1024)
			{
				if ($_FILES['store_logo']['type'] == 'image/png'|| $_FILES['store_logo']['type'] == 'image/jpg'||$_FILES['store_logo']['type'] == 'image/jpeg')
				{  
					$query = "INSERT  into tbl_store (store_name, store_address, store_phone, store_web, store_logo) values ('$store_name', '$store_address', '$store_phone', '$store_web', '$store_logo')";
					$value_insert= mysql_query($query) or die(mysql_error());
					
					$id_store = mysql_insert_id();
					$directory = "../img/store/".$id_store;
					mkdir($directory, 0755);
					
					$move=move_uploaded_file($_FILES['store_logo']['tmp_name'], $directory.'/'.$store_logo);
					
					echo '<script type="text/javascript">
					alert("Data already added..");
					window.location = "store.php";
					</script>';
				}
				else{
					
					echo '<script type="text/javascript">
					alert("File not allowed..");
					window.location = "store.php";
					</script>';
					
					}
			}
		else
			{
					echo '<script type="text/javascript">  window.onload = function(){
					alert("Your image to big size, please reupload <= 1 MB..");
					window.location = "store.php";
					}</script>';
			}
	}
}

// deleting store's data from database
function delete_store(){
	$id_store = $_POST['id_store'];
	$store_logo = $_POST['store_logo'];

	if (isset($id_store)){	
		$directory = "../img/store/".$id_store;	
		$image_del = $directory.'/'.$store_logo;
		unlink($image_del);
		
		$sql="DELETE FROM tbl_store WHERE id_store ='$id_store'";
		$result=mysql_query($sql);
		
		if(!file_exists($image_del)){
		rmdir($directory);
		echo '<script type="text/javascript">
		 window.location = "store.php";
		</script>';
		}
	}
	else{
		echo "<script>alert('Data not complete...');</script>";
		echo  "<script> window.location='product_categories.php'</script>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP - Admin Panel</title>
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
    if(isset($_GET['action'])=='submitfunc') {
        insert_store();
    }else if(isset($_GET['delete'])=='deletefunc'){
		delete_store();
	}
?>
<body>
<div data-role="page" class="jqm-demos ui-responsive-panel" id="panel-fixed-page1">

    <div data-role="header" data-theme="f" data-position="fixed">
        <h1>Store</h1>
        <a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
		<a href="logout.php" data-role="button" data-mini="true" data-transition="slide" data-icon="info" data-iconpos="left" data-ajax="false">Logout</a>
    </div><!-- /header -->
	
	<div data-role="content" class="jqm-content">
	<a href="#popupStore" data-rel="popup" data-position-to="window" data-role="button" data-icon="plus" data-iconshadow="false" data-theme="a">Add new store</a><br/>
		<!-- Pop up list store -->
		<ul data-role="listview" data-split-icon="delete" data-split-theme="a" data-inset="true" data-filter="true" data-ajax="false">
		<?php
			$a = 1;
			while( $row = mysql_fetch_array($query)):
		?>	
			<li><a href="edit_store_partner.php?id_store=<?=$row[0];?>" rel="external" data-ajax="false">
				<img src="../img/store/<?=$row[0];?>/<?=$row[5];?>" style='height:100%; width:90px; margin-top:7px; margin-left:5px;'>
				<h2><?=$row[1];?></h2>
				<p><strong><?=$row[2];?></strong></p>
				<p><?=$row[3];?><span>&nbsp;&nbsp;&nbsp; <?=$row[4];?></span></p>
				</a><a href="#deleteStore<?=$a?>" data-rel="popup" data-position-to="window" data-transition="pop">Delete store?</a>
			</li>
		
		
		<div data-role="popup" id="deleteStore<?=$a++?>" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
		<form action="?delete=deletefunc" method="post" enctype="multipart/form-data" data-ajax="false" data-theme="f">		
			<h3>Delete store content?</h3>
			<p>This request can't be undo.</p>
			<input type="hidden" name="id_store" id="id_store" class="ui-hidden-accessible" value="<?=$row[0];?>"/>
			<input type="hidden" name="store_logo" id="store_logo" class="ui-hidden-accessible" value="<?=$row[5];?>"/>
			<button  type="submit" onclick="delete_store()" data-rel="back" data-theme="b" data-icon="check" data-inline="true" data-mini="true">Yes</button>
			<a href="#" data-role="button" data-rel="back" data-icon="minus" data-inline="true" data-mini="true">Cancel</a>
		</form>
		</div>	
		<?endwhile;?>
		</ul>
		<!-- /Pop up list store -->
		
		<!-- Pop up add store -->
		<div data-role="popup" id="popupStore" data-theme="a" data-overlay-theme="b"  class="ui-corner-all">
			<a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
				<form action="?action=submitfunc" method="post" enctype="multipart/form-data" data-ajax="false">
					<div style="padding:10px 20px;">
						<h3>Add new store</h3>
						<label for="type" class="ui-hidden-accessible">Store name : </label>
						<input type="text" name="store_name" id="store_name" placeholder="Store name.." data-theme="a" value="" required/>
						
						<label for="type" class="ui-hidden-accessible">Store address : </label>
						<textarea cols="40" rows="8" name="store_address" id="store_address" placeholder="Store address.." data-theme="a" value="" required></textarea>
						
						<label for="type" class="ui-hidden-accessible">Store phone number : </label>
						<input type="text" name="store_phone" id="store_phone" placeholder="Store phone number.." data-theme="a" value="" required/>
						
						<label for="type" class="ui-hidden-accessible">Store website : </label>
						<input type="text" name="store_web" id="store_web" placeholder="Store url website.." data-theme="a" value="" required/>

						<label for="image" class="ui-hidden-accessible">Store logo</label>
						<input type="file" name="store_logo" id="store_logo" placeholder="Store logo.." data-theme="a" multiple />
						
						<button type="submit" data-theme="f" onClick="insert_store()">Submit</button>
					</div>
				</form>
		</div>
		<!-- /Pop up add store -->
		
	</div><!-- /content -->

	
	<div data-role="footer" data-position="fixed" data-theme="f">
    	<h4>Copyright &copy; 2014, Belanja - Created for Mobile</h4>
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
</body>
</html>
