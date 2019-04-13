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
$dbStore = mysql_query("SELECT id_store, store_name, store_address, store_phone, store_web from tbl_store");
$dbCat = mysql_query("SELECT id_product_categories, title_product_categories, categories_logo from tbl_product_categories ORDER BY title_product_categories ASC");

//function to adding product with content  
function insert_product(){
      
    $idCat = $_POST['pro_cat'];
    $proName = $_POST['pro_name'];
    $proPrice = $_POST['pro_price'];
    $proDisc = $_POST['pro_disc'];
    $proDesc = $_POST['pro_desc'];
    $idStore = $_POST['pro_store'];
    $proUrl = $_POST['pro_url'];
    $proTime = $_POST['pro_time_start'];
    $proTimeEx = $_POST['pro_time_ex'];
    $imagePrimary = $_FILES['image_primary']['name'];
    $imagePreview2 = $_FILES['image_preview2']['name'];
    $imagePreview3 = $_FILES['image_preview3']['name'];
    $imagePreview4 = $_FILES['image_preview4']['name'];
    $imagePreview5 = $_FILES['image_preview5']['name'];
      
    if(!isset($idCat)||!isset($proName)||!isset($proPrice)||!isset($proDisc)||!isset($proDesc)||!isset($idStore)||!isset($proUrl)||!isset($protimeEx)||!isset($proTimeEx))
    {
        if(!empty($_FILES['image_primary']['name']))
        {
        // if image primary upload 
			if ($_FILES['image_primary']['size'] < 1024*1024)
			{
				if ($_FILES['image_primary']['type'] == 'image/png'|| $_FILES['image_primary']['type'] == 'image/jpg'||$_FILES['image_primary']['type'] == 'image/jpeg')
				{  
								$query = "INSERT  into tbl_product (id_product_categories, product_name, price, discount, product_desc, id_store, product_url, date_product, last_date_product_ex, image_primary) values ('$idCat', '$proName', '$proPrice', '$proDisc', '$proDesc', '$idStore', '$proUrl', '$proTime','$proTimeEx','$imagePrimary')";
								$value_insert= mysql_query($query) or die(mysql_error());
								$id_product = mysql_insert_id();
								  
								$query_image = "INSERT into tbl_image (id_product, image_name) values ('$id_product','$imagePrimary')";
								$value_image= mysql_query($query_image) or die(mysql_error());
								  
								$directory = "../img/product/".$id_product;
								mkdir($directory, 0755);
								  
								$move=move_uploaded_file($_FILES['image_primary']['tmp_name'], $directory.'/'.$imagePrimary);
								  
					if(!empty($_FILES['image_preview2']['name']))
					{
						if ($_FILES['image_preview2']['size'] < 1024*1024)
							{
								if ($_FILES['image_preview2']['type'] == 'image/png'|| $_FILES['image_preview2']['type'] == 'image/jpg'||$_FILES['image_preview2']['type'] == 'image/jpeg')
									{  
										$query_image2 = "INSERT into tbl_image (id_product, image_name) values ('$id_product','$imagePreview2')";
										$value_image2= mysql_query($query_image2) or die(mysql_error());
												  
										$move2=move_uploaded_file($_FILES['image_preview2']['tmp_name'], $directory.'/'.$imagePreview2);
											
									}
								else
									{                  
									echo '<script type="text/javascript">
												alert("File not allowed except png,jpeg,jpg..");
												window.location = "add_product.php";
												</script>';           
									}
							}
						else
							{                  
							echo '<script type="text/javascript">
										alert("Please re-upload image file.. <=1MB..");
										window.location = "add_product.php";
										</script>';           
							}
					}
					if(!empty($_FILES['image_preview3']['name']))
					{
						if ($_FILES['image_preview3']['size'] < 1024*1024)
							{
								if ($_FILES['image_preview3']['type'] == 'image/png'|| $_FILES['image_preview3']['type'] == 'image/jpg'||$_FILES['image_preview3']['type'] == 'image/jpeg')
									{  
										$query_image3 = "INSERT into tbl_image (id_product, image_name) values ('$id_product','$imagePreview3')";
										$value_image3= mysql_query($query_image3) or die(mysql_error());
										  
										$move3=move_uploaded_file($_FILES['image_preview3']['tmp_name'], $directory.'/'.$imagePreview3);
												
									}
								else
									{                  
									echo '<script type="text/javascript">
												alert("File not allowed except png,jpeg,jpg..");
												window.location = "add_product.php";
												</script>';           
									}
							}
						else
							{                  
							echo '<script type="text/javascript">
										alert("Please re-upload image file.. <=1MB..");
										window.location = "add_product.php";
										</script>';           
							}
					}
					if(!empty($_FILES['image_preview4']['name']))
					{
						if ($_FILES['image_preview4']['size'] < 1024*1024)
							{
								if ($_FILES['image_preview4']['type'] == 'image/png'|| $_FILES['image_preview4']['type'] == 'image/jpg'||$_FILES['image_preview4']['type'] == 'image/jpeg')
									{  
										$query_image4 = "INSERT into tbl_image (id_product, image_name) values ('$id_product','$imagePreview4')";
										$value_image4= mysql_query($query_image4) or die(mysql_error());
													  
										$move4=move_uploaded_file($_FILES['image_preview4']['tmp_name'], $directory.'/'.$imagePreview4);
													  
									}
								else
									{                  
									echo '<script type="text/javascript">
												alert("File not allowed except png,jpeg,jpg..");
												window.location = "add_product.php";
												</script>';           
									}
							}
						else
							{                  
							echo '<script type="text/javascript">
										alert("Please re-upload image file.. <=1MB..");
										window.location = "add_product.php";
										</script>';           
							}
					}
					if(!empty($_FILES['image_preview5']['name']))
					{
						if ($_FILES['image_preview5']['size'] < 1024*1024)
							{
								if ($_FILES['image_preview5']['type'] == 'image/png'|| $_FILES['image_preview5']['type'] == 'image/jpg'||$_FILES['image_preview5']['type'] == 'image/jpeg')
									{  
										$query_image5 = "INSERT into tbl_image (id_product, image_name) values ('$id_product','$imagePreview5')";
										$value_image5= mysql_query($query_image5) or die(mysql_error());
													  
										$move5=move_uploaded_file($_FILES['image_preview5']['tmp_name'], $directory.'/'.$imagePreview5);
													  
									}
								else
									{                  
									echo '<script type="text/javascript">
												alert("File not allowed except png,jpeg,jpg..");
												window.location = "add_product.php";
												</script>';           
									}
							}
							else
							{                  
							echo '<script type="text/javascript">
										alert("Please re-upload image file.. <=1MB..");
										window.location = "add_product.php";
										</script>';           
							}
					}   
                          
              
				echo '<script type="text/javascript">
								alert("Data already added..");
								window.location = "product.php";
								</script>';
				}
			else
				{                  
				echo '<script type="text/javascript">
							alert("File not allowed except png,jpeg,jpg..");
							window.location = "add_product.php";
							</script>';           
				}
		}
		else
		{
			echo '<script type="text/javascript">
						alert("Please re-upload image file.. <=1MB..");
						window.location = "add_product.php";
						</script>';
		}
    }
    else
    {
        echo '<script type="text/javascript">
        alert("Need to upload primary image..");
        window.location = "add_product.php";
        </script>';   
    }
  }
  else
  {
	echo '<script type="text/javascript">{
         alert("Fill the blank..");
         window.location = "add_product.php";
        }</script>';
  }
}
?>
  
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Product - Admin Panel</title>
    <link rel="shortcut icon" href="../belanja.png">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">	
	<link rel="stylesheet" href="../css/themes/default/jquery.mobile-1.4.1.css">
	<link rel="stylesheet" href="../_assets/css/jqm-demos.css">
	<script src="../js/jquery.js"></script>
	<script src="../_assets/js/index.js"></script>
	<script src="../js/jquery.mobile-1.4.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery.countdown.js"></script>
      
    <!-- Date Picker -->
    <link type="text/css" href="../js/datepicker/jqm-datebox.min.css" rel="stylesheet" />  
    <script type="text/javascript" src="../js/datepicker/jqm-datebox.core.min.js"></script>
    <script type="text/javascript" src="../js/datepicker/jqm-datebox.mode.calbox.min.js"></script>
      
  
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
        insert_product();
    }
?>
<body>
<div data-role="page" class="jqm-demos ui-responsive-panel" id="panel-fixed-page1">
  
    <div data-role="header" data-theme="f" data-position="fixed">
        <h1>Add new product</h1>
        <a href="product.php" data-role="button" data-mini="true" data-transition="slide" data-icon="back" data-iconpos="left" data-ajax="false">Back</a>
    </div><!-- /header -->
      
    <div data-role="content" class="jqm-content">
      
    <form action="?action=submitfunc" method="post" enctype="multipart/form-data" data-ajax="false">      
    <div data-role="fieldcontain"> 
	<!--showing form content to add your new product -->
    <label for="pro_cat">Product's Categories:</label>  
        <select name="pro_cat" id="pro_cat">
            <?php
                while( $row = mysql_fetch_array($dbCat)):
            ?>
            <option value="<?=$row[0];?>"><?=$row[1];?></option>
            <?endwhile;?>
        </select>
	</div>
	
    <div data-role="fieldcontain"> 
    <label for="pro_store">Choose Store :</label>
        <select name="pro_store" id="pro_store">
            <?php
                    while( $row = mysql_fetch_array($dbStore)):
            ?>
            <option value="<?=$row[0];?>"><?=$row[1];?></option>
            <?endwhile;?>
        </select>
	</div>
	
    <div data-role="fieldcontain"> 
    <label for="pro_name">Product's Name:</label>
    <input name="pro_name" id="pro_name" placeholder="Product name.." value="" type="text" required>
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="pro_price">Price:</label>
    <input name="pro_price" id="pro_price" placeholder="Price.." data-clear-btn="true" value="" type="number" required>
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="pro_disc">Discount:</label>
    <input name="pro_disc" id="pro_disc" placeholder="Discount.." data-clear-btn="true" value="" type="number" required>
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="pro_desc">Product's Descriptions:</label>
    <textarea cols="40" rows="15" name="pro_desc" id="pro_desc" placeholder="Descriptions.." style="margin-bottom:5px;" required></textarea>
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="pro_url">Product's URL:</label>
    <input name="pro_url" id="pro_url" placeholder="Product's URL.." value="" type="text" required>
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="pro_time_start" >Start Preview:</label>
    <input type="text" name="pro_time_start" id="pro_time_start" placeholder="Start preview.."  data-role="datebox" data-options='{"mode": "calbox"}' />  
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="pro_time_ex" style="margin-bottom:20px;">Last Preview:</label>
    <input type="text" name="pro_time_ex" id="pro_time_ex" placeholder="Last preview.." data-role="datebox" data-options='{"mode": "calbox"}'>
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="image_primary"><font color="red">*Image Primary Preview (Rec : Image size 600x800px):</font></label>
    <input type="file" name="image_primary" id="image_primary" placeholder="Image Preview.." data-theme="a" multiple />
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="image_preview2" style="margin-bottom:10px;">Image Second (Rec : Image size 600x800px):</label>
    <input type="file" name="image_preview2" id="image_preview2" placeholder="Image Preview2.." data-theme="a" multiple />
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="image_preview3" style="margin-bottom:10px;">Image Third (Rec : Image size 600x800px):</label>
    <input type="file" name="image_preview3" id="image_preview3" placeholder="Image Preview3.." data-theme="a" multiple />
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="image_preview4" style="margin-bottom:10px;">Image Four (Rec : Image size 600x800px):</label>
    <input type="file" name="image_preview4" id="image_preview4" placeholder="Image Preview4.." data-theme="a" multiple />
    </div>
	
	<div data-role="fieldcontain"> 
    <label for="image_preview5" style="margin-bottom:10px;">Image Five (Rec : Image size 600x800px):</label>
    <input type="file" name="image_preview5" id="image_preview5" placeholder="Image Preview.." data-theme="a" multiple />
    </div>
	
    <div data-role="controlgroup" data-type="horizontal" align="center">
        <a href="store_partner.php" data-role="button" data-icon="back" data-iconshadow="false" data-theme="a">Cancel</a>
        <button type="submit" onClick="insert_product()" data-theme="b" data-icon="edit" data-ajax="false">Submit</button>
    </div>
    </form>
    </div><!-- /content -->
  
      
    <div data-role="footer" data-position="fixed" data-theme="f">
        <h4>Copyright &copy; 2014, Belanja - Created for Mobile</h4>
    </div><!-- /footer -->
</div><!-- /page -->
</body>
</html> 
