<?
include ('../include/connect.php');

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

$id_store = $_GET['id_store'];
$query = mysql_query("SELECT id_store, store_name, store_address, store_phone, store_web, store_logo from tbl_store where id_store='$id_store'");

// updating store's data in database
function update_store(){
$id_store = $_POST['id_store'];
$store_name = $_POST['store_name'];
$store_address = $_POST['store_address'];
$store_phone = $_POST['store_phone'];
$store_web = $_POST['store_web'];

$image_del = $_POST['image_del'];
$store_logo = $_FILES['store_logo']['name'];
	
	if(empty($store_name) || empty($store_address) || empty($store_phone) || empty($store_web))
	{
		echo '<script type="text/javascript">  window.onload = function(){
			alert("Data not completed..");
			window.location = "edit_store_partner.php?id_store='.$id_store.'";
		}</script>';
	}
	else if(empty($store_logo))
	{
		$directory = "../img/store/".$id_store;
		chmod($directory, 755);
		
		$query = "UPDATE tbl_store SET store_name='$store_name', store_address='$store_address', store_phone='$store_phone', store_web='$store_web' WHERE id_store='$id_store'";
		$value_update= mysql_query($query) or die(mysql_error()); 
								
		echo '<script type="text/javascript">
			  alert("Data already updated..");
			  window.location = "store.php";
			  </script>';
	}else
	{
		if ($_FILES['store_logo']['size'] < 1024*1024)
			{
				if ($_FILES['store_logo']['type'] == 'image/png'|| $_FILES['store_logo']['type'] == 'image/jpg'||$_FILES['store_logo']['type'] == 'image/jpeg')
				{  
					$directory = "../img/store/".$id_store;
					$image_remove = $directory.'/'.$image_del;
					unlink($image_remove);
					chmod($directory, 755);
					
					$query = "UPDATE tbl_store SET store_name='$store_name', store_address='$store_address', store_phone='$store_phone', store_web='$store_web', store_logo='$store_logo' WHERE id_store='$id_store'";
					$value_insert= mysql_query($query) or die(mysql_error());
					
					$move=move_uploaded_file($_FILES['store_logo']['tmp_name'], $directory.'/'.$store_logo);
					
					
					echo '<script type="text/javascript">
					alert("Data already updated..");
					window.location = "store.php";
					</script>';
				}
				else
				{
						echo '<script type="text/javascript">  window.onload = function(){
						alert("File not allowed except png,jpeg,jpg..");
						window.location = "edit_store_partner.php?id_store='.$id_store.'";
						}</script>';
				}
			}
			else
			{                  
				echo '<script type="text/javascript">
				alert("Please re-upload image file.. <=1MB..");
				window.location = "edit_store_partner.php?id_store='.$id_store.'";
				</script>';           
			}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Belanja - Admin Panel</title>
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
        update_store();
    }
?>
<body>
<div data-role="page" class="jqm-demos ui-responsive-panel" id="panel-fixed-page1">

    <div data-role="header" data-theme="f" data-position="fixed">
        <h1>Update Store</h1>
		<a href="store.php" data-role="button" data-mini="true" data-transition="slide" data-icon="back" data-iconpos="left" data-ajax="false">Back</a>
    </div><!-- /header -->
	
	<div data-role="content" class="jqm-content">
	<?php 
		while( $row = mysql_fetch_array($query)):
	?>
	<form action="?action=updatefunc" method="post" enctype="multipart/form-data" data-ajax="false">		
	<div data-role="fieldcontain">
    <label for="store_name">Store name:</label>
    <input name="store_name" id="store_name" placeholder="" value="<?=$row[1];?>" type="text">
	</div>
	
	<div data-role="fieldcontain">
	<label for="store_address">Store address:</label>
    <input name="store_address" id="store_address" placeholder="" value="<?=$row[2];?>" type="text">
	</div>
	
	<div data-role="fieldcontain">
	<label for="store_phone">Store phone:</label>
    <input name="store_phone" id="store_phone" placeholder="" value="<?=$row[3];?>" type="text">
	</div>
	
	<div data-role="fieldcontain">
	<label for="store_web">Store website:</label>
    <input name="store_web" id="store_web" placeholder="" value="<?=$row[4];?>" type="text">
	</div>
	
	<div data-role="fieldcontain">
	<label for="store_image" style="margin:0px 13px 0px 5px;"><img class="popphoto" src="../img/store/<?=$row[0];?>/<?=$row[5];?>" alt="<?=$row[5];?>" alt="" style="width:170px; height:170px; margin:0px 10px 10px 10px; border-radius:10px; box-shadow:0 1px 3px rgba(0,0,0,0.5);"></label>
	<input type="file" name="store_logo" id="store_logo" placeholder="Store image.." data-theme="a" multiple />
	</div>
	
	<div data-role="fieldcontain">
	<input type="hidden" name="id_store" id="id_dealer" class="ui-hidden-accessible" value="<?=$row[0];?>"/>
	<input type="hidden" name="image_del" id="image_del" class="ui-hidden-accessible" value="<?=$row[5];?>"/>
	</div>
	
	<div data-role="controlgroup" data-type="horizontal" align="center">
		<a href="store_partner.php" data-role="button" data-icon="back" data-iconshadow="false" data-theme="a">Cancel</a>
		<button type="submit" onclick="update_store()" data-theme="b" data-icon="edit" data-ajax="false">Update</button>
	</div>
	</form>
	<?endwhile;?>
	</div><!-- /content -->

	
	<div data-role="footer" data-position="fixed" data-theme="f">
    	<h4>Copyright &copy; 2014, Belanja - Created for Mobile</h4>
    </div><!-- /footer -->
</div><!-- /page -->
</body>
</html>
