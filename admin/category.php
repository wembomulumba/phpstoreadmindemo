<?php
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

$query = mysql_query("SELECT id_product_categories, title_product_categories, categories_logo from tbl_product_categories ORDER BY title_product_categories ASC");

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

// adding product's category to database
function insert_categories(){
$categories = $_POST['categories'];
$cat_logo = $_FILES['cat_logo']['name'];
	
	if(isset($categories))
	{
		if ($_FILES['cat_logo']['size'] < 1024*1024)
			{
				if ($_FILES['cat_logo']['type'] == 'image/png'|| $_FILES['cat_logo']['type'] == 'image/jpg'||$_FILES['cat_logo']['type'] == 'image/jpeg')
					{  
						$query = "INSERT  into tbl_product_categories (title_product_categories, categories_logo) values ('$categories','$cat_logo')";
						$value_insert= mysql_query($query) or die(mysql_error());
						
						$id_cat = mysql_insert_id();
						$directory = "../img/product_category/".$id_cat;
						mkdir($directory, 0755);
						
						$move=move_uploaded_file($_FILES['cat_logo']['tmp_name'], $directory.'/'.$cat_logo);
						
						echo '<script type="text/javascript">
						alert("Data already added..");
						window.location = "category.php";
						</script>';
					}
				else{
					
					echo '<script type="text/javascript">
					alert("File not allowed..");
					window.location = "category.php";
					</script>';
					
					}
			}
		else
			{
					echo '<script type="text/javascript">  window.onload = function(){
					alert("Your image to big size, please reupload <= 1 MB..");
					window.location = "category.php";
					}</script>';
			}
	}
	else{
		echo "<script>alert('Data not complete...');</script>";
		echo  "<script> window.location='category.php'</script>";
	}
}

// updating product's category in database
function update_categories(){
		$id_product_categories = $_POST['id_product_categories'];
		$categories = $_POST['categories'];
		$cat_logo = $_FILES['cat_logo']['name'];
		
		$cat_logo_del = $_POST['cat_logo_del'];
		
		if(empty($categories))
		{
			echo '<script type="text/javascript">  window.onload = function(){
				alert("Data not completed..");
				window.location = "category.php";
			}</script>';
		}
		else if (empty($cat_logo))
		{
		$directory = "../img/product_category/".$id_product_categories;
		chmod($directory, 755);
		
		$query = "UPDATE tbl_product_categories SET title_product_categories='$categories', categories_logo='$cat_logo_del' WHERE id_product_categories='$id_product_categories'";
			$value_update= mysql_query($query) or die(mysql_error()); 
									
			echo '<script type="text/javascript">
				alert("Data already change..");
				window.location = "category.php";
				</script>';
		
		}
		else 
		{
			if ($_FILES['cat_logo']['size'] < 1024*1024)
				{
					if ($_FILES['cat_logo']['type'] == 'image/png'|| $_FILES['cat_logo']['type'] == 'image/jpg'||$_FILES['cat_logo']['type'] == 'image/jpeg')
						{  
							$query = "UPDATE tbl_product_categories SET title_product_categories='$categories', categories_logo='$cat_logo' WHERE id_product_categories='$id_product_categories'";
							$value_update= mysql_query($query) or die(mysql_error()); 
													
							$directory = "../img/product_category/".$id_product_categories;
							chmod($directory, 755);
							
							$image_del = $directory.'/'.$cat_logo_del;
							unlink($image_del);
							
							$move=move_uploaded_file($_FILES['cat_logo']['tmp_name'], $directory.'/'.$cat_logo);
							echo '<script type="text/javascript">
								alert("Data already change..");
								window.location = "category.php";
								</script>';
						}
					else
						{
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
					window.location = "category.php";
					}</script>';
				}
		}
	}

// deleting product's category from database
function delete_categories(){
$id_product_categories = $_POST['id_product_categories'];
$cat_logo = $_POST['cat_logo'];

	if (isset($id_product_categories))
	{		
			$directory = "../img/product_category/".$id_product_categories;	
			$image_del = $directory.'/'.$cat_logo;
			unlink($image_del);
		
			$sql="DELETE FROM tbl_product_categories WHERE id_product_categories ='$id_product_categories'";
			$result=mysql_query($sql);
			
			if(!file_exists($image_del)){
			rmdir($directory);
			echo '<script type="text/javascript">
			alert("Data already deleted..");
			window.location = "category.php";
			</script>';
			}
			
	}
	else{
		echo "<script>alert('Data not complete...');</script>";
		echo  "<script> window.location='category.php'</script>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Category - Admin Panel</title>
    <link rel="shortcut icon" href="../belanja.png">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">	
	<link rel="stylesheet" href="../css/themes/default/jquery.mobile-1.4.1.css">
	<link rel="stylesheet" href="../_assets/css/jqm-demos.css">
	<script src="../js/jquery.js"></script>
	<script src="../_assets/js/index.js"></script>
	<script src="../js/jquery.mobile-1.4.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery.countdown.js"></script>
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
        insert_categories();
    }else if(isset($_GET['delete'])=='deletefunc'){
		delete_categories();
	}else if(isset($_GET['update'])=='updatefunc'){
		update_categories();
	}
?>
<body>
<div data-role="page" class="jqm-demos ui-responsive-panel" id="panel-fixed-page1">

    <div data-role="header" data-theme="f" data-position="fixed">
        <h1>Product Categories</h1>
        <a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
		<a href="logout.php" data-role="button" data-mini="true" data-transition="slide" data-icon="info" data-iconpos="left" data-ajax="false">Logout</a>
    </div><!-- /header -->

    <!-- Content for real estate categories -->
	<div data-role="content" class="jqm-content">
	<a href="#popupCategories" data-rel="popup" data-position-to="window" data-role="button" data-icon="plus" data-iconshadow="false" data-theme="a">Add Categories</a>
	<ul data-role="listview" data-split-icon="delete" data-theme="a" data-split-theme="a" data-inset="true">
	<?php
		$a = 1;
		$b = 1;
		while( $row = mysql_fetch_array($query)):
	?>	
		<li><a href="#update<?=$b?>" data-rel="popup" data-position-to="window"><img src="../img/product_category/<?=$row[0];?>/<?=$row[2];?>" alt="<?=$row[2];?>" class="ui-li-icon ui-corner-none" style="padding:10px 10px 10px 0px;">
			<h2><?=$row[1];?></h2>
			</a><a href="#delete<?=$a?>" data-rel="popup" data-position-to="window">Delete Categories</a>
		</li>
		
		<!-- Pop up delete categories -->
		<div id="delete<?=$a++?>" class="ui-content" data-role="popup" data-overlay-theme="b" data-theme="a">
		<form action="?delete=deletefunc" method="post" enctype="multipart/form-data" data-ajax="false">
			<p id="question"><h2>Are you sure you want to delete?</h2></p>
			<p>This request can't be undo.</p>
				<input type="hidden" name="id_product_categories" id="id_car_categories" class="ui-hidden-accessible" value="<?=$row[0];?>" required/>
				<input type="hidden" name="cat_logo" id="cat_logo" class="ui-hidden-accessible" value="<?=$row[2];?>"/>
				<button type="submit" onclick="delete_categories()" data-theme="b" data-icon="check" data-inline="true" data-mini="true">Yes</button>
				<a href="#" data-role="button" data-rel="back" data-inline="true" data-mini="true" data-icon="minus">Cancel</a>
		</form>
		</div>
		<!-- /Pop up delete categories -->
		
		<!-- Pop up edit categories -->
					<div data-role="popup" id="update<?=$b++?>" data-theme="a" data-overlay-theme="b" class="ui-corner-all">
					<a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
						<form action="?update=updatefunc" method="post" enctype="multipart/form-data" data-ajax="false">
							<div style="padding:10px 20px;">
								<h3>Edit Categories</h3>
								<label for="type" class="ui-hidden-accessible">Categories</label>
								<input type="text" name="categories" id="categories" placeholder="categories.." data-theme="a" value="<?=$row[1];?>" required/>
								<input type="hidden" name="id_product_categories" id="id_product_categories" data-theme="a" class="ui-hidden-accessible" value="<?=$row[0];?>" required/>
								<input type="hidden" name="cat_logo_del" id="cat_logo_del" class="ui-hidden-accessible" value="<?=$row[2];?>"/>
								
								<label for="image">Categories Logo <font color="red">(Recomended 25x25pixels)</font></label>
								<input type="file" name="cat_logo" id="cat_logo" placeholder="Categories logo.." data-theme="a" multiple />

								<button type="submit" data-theme="a" onClick="update_categories()">Submit</button>
							</div>
						</form>
					</div>
						<!-- /Pop up edit categories -->
		
	<?endwhile;?>
	</ul>
	
	<!-- Pop up add categories -->
	<div data-role="popup" id="popupCategories" data-theme="a" data-overlay-theme="b" class="ui-corner-all">
		<a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
			<form action="?action=submitfunc" method="post" enctype="multipart/form-data" data-ajax="false">
				<div style="padding:10px 20px;">
					<h3>Add Categories</h3>
					<label for="type" class="ui-hidden-accessible">Categories</label>
					<input type="text" name="categories" id="categories" placeholder="categories.." data-theme="a" value="" required/>
					
					<label for="image">Categories Logo <font color="red">(Must 25x25pixels)</font></label>
					<input type="file" name="cat_logo" id="cat_logo" placeholder="Categories logo.." data-theme="a" multiple />

					<button type="submit" data-theme="a" onClick="insert_categories()">Submit</button>
				</div>
			</form>
	</div>
	<!-- /Pop up add categories -->
	</div>
	<!-- /Content for real estate categories -->
	
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
</body>
</html>
