<?php
	include ('../include/connect.php');
	$dbProduct = mysql_query("SELECT * FROM tbl_product p, tbl_product_categories c, tbl_currency s WHERE p.id_product_categories=c.id_product_categories ORDER BY id_product DESC");
	
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
	
	function delProduct() {
		$idProduct = $_POST['idProduct'];
				
		if (isset($idProduct)) {
			$directory = "../img/product/" . $idProduct;

			if (is_dir($directory)) {
				$imgs = scandir($directory);

				foreach ($imgs as $img) {
					if ($img != "." &&  $img != "..") {
						if (filetype($directory."/".$img) == "dir") rmdir($directory."/".$img); else unlink($directory."/".$img);
					}
				}

				reset($imgs);
				rmdir($directory);
				mysql_query("DELETE FROM tbl_image WHERE id_product = '" . $idProduct . "'");
				mysql_query("DELETE FROM tbl_product WHERE id_product = '" . $idProduct . "'");

				echo "<script type='text/javascript'>
					alert('Data product already deleted...');
					window.location = 'product.php';
				</script>";
			}
		} else {
			echo "<script type='text/javascript'>
				alert('Data not completed...');
				window.location = 'product.php';
			</script>";
		}
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Product - Admin Panel</title>
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
	<body>
		<?php
			if (isset($_GET['del']) == 'delFunc') {
				delProduct();
			}
		?>
		<div data-role="page" class="jqm-demos">
			<div data-role="header" data-position="fixed" data-theme="f">
				<h1>Belanja - Admin</h1>
				<a href="#hiddenMenu" data-icon="bars" data-iconpos="notext">Menu</a>
				<a href="logout.php" data-role="button" data-mini="true" data-transition="slide" data-icon="info" data-iconpos="left" data-ajax="false">Logout</a>
			</div> <!-- end of header -->

			<div data-role="content" class="jqm-content">
				<a href="add_product.php" data-role="button" data-icon="plus" data-iconshadow="false" data-theme="a" data-ajax="false">Add New Product</a><br/>
				<ul data-role="listview" data-split-icon="delete" data-split-theme="d" data-inset="true" data-filter="true" data-ajax="false">
						<?php
							$a = 1;
							$c = 1;
							while($rowProd = mysql_fetch_array($dbProduct)):
								$dbDate = mysql_fetch_array(mysql_query("SELECT last_date_product_ex, date_product FROM tbl_product WHERE id_product='" . $rowProd[0] . "'"));
								
								echo "<script type='text/javascript'>
									  $(function() {
											var endDate = '" . date('Y-m-d', strtotime($dbDate[0])) . "';
											$('.countdown". $c ."').countdown({ date: endDate });
										});
								</script>";
								$theme = 'c';
								if (date('Y-m-d', strtotime($dbDate[1])) > date('Y-m-d')) {
									$theme = 'e';
								} elseif (date('Y-m-d', strtotime($dbDate[0])) < date('Y-m-d')) {
									$theme = 'a';
								}
								echo"
								<li data-theme='".$theme."'>
								";

								$color = 'none';
								// showing product with some discount
								if($rowProd[4] > 0) {
									$discount = " with " . $rowProd[4] . "% off";
								echo "
								
								<a href='edit_product.php?id_product=".$rowProd[0]."' rel='external' data-ajax='false' style='background-color: ". $color ."'>
									<img src='../img/product/".$rowProd[0]."/".$rowProd[10]."' style='height:100%; width:90px; margin-top:7px; margin-left:5px;'>
									<h2>".$rowProd[2]."&nbsp;&nbsp;&nbsp; Category : <font color='#3333FF'>".$rowProd[12]."</font></h2>
									<p><font color='#c3c3c3' style='text-decoration:line-through'> ".$rowProd[15]."".number_format($rowProd[3], 2)."</font><font color='red'>".$discount."</font>&nbsp;&nbsp;<font color='#147206'>".$rowProd[15]."".number_format(round($rowProd[3] - $rowProd[3] * $rowProd[4] / 100, 2), 2)."</font></p>
									<p class='countdown".$c++."' style='font-weight:bold;'></p>
									</a>
								<a href='#delete".$a."' data-rel='popup' data-position-to='window'>Delete?</a>
								";	
								} else {
								// showing product with no discount
								echo "
								<a href='edit_product.php?id_product=".$rowProd[0]."' rel='external' data-ajax='false' style='background-color: ". $color ."'>
									<img src='../img/product/".$rowProd[0]."/".$rowProd[10]."' style='height:100%; width:90px; margin-top:7px; margin-left:5px;'>
									<h2>".$rowProd[2]."&nbsp;&nbsp;&nbsp; Category : <font color='#3333FF'>".$rowProd[12]."</font></h2>
									<p><font color='red'>Best Price &nbsp&nbsp</font><font color='#147206'>".$rowProd[15]."".number_format($rowProd[3], 2)."</font></p>
									<p class='countdown".$c++."' style='font-weight:bold;'></p>
									</a>
								<a href='#delete".$a."' data-rel='popup' data-position-to='window'>Delete?</a>
								";	
								echo "
								</li>";	
								}
								
								// showing function to delete product
								echo"
								<div id='delete".$a++."' class='ui-content' data-overlay-theme='b' data-role='popup' data-theme='a'>
									<form action='?del=delFunc' method='post' enctype='multipart/form-data' data-ajax='false'>
										<p id='question'><h2>Are you sure that you want to delete this product?</h2></p>
										<p>This request can't be undo</p>

										<input type='hidden' name='idProduct' id='idProduct' data-theme='c' class='ui-hidden-accessible' value='".$rowProd[0]."' required />
										<button type='submit' onclick='delProduct()' data-theme='b' data-icon='check' data-inline='true' data-mini='true'>Yes</button>
										<a href='#' data-role='button' data-rel='back' data-inline='true' data-mini='true' data-icon='minus'>Cancel</a>
									</form>
								</div>
								";
 								
							?>
					<?php
					endwhile; ?>	
				</ul>
			</div> <!-- end of content -->

			<div data-role="footer" data-position="fixed" data-theme="f">
				<h4>Copyright &copy; 2014, Belanja - Created for Mobile</h4>
			</div> <!-- end of footer -->

			<div data-role="panel" data-position-fixed="true" data-theme="b" id="hiddenMenu">
				<ul data-role="listview" class="nav-search" data-theme="a">
					<li data-icon="delete" data-theme="b"><a href="#" data-rel="close">Menu List</a></li>
					<li data-icon="carat-r"><a href="index.php" data-ajax="false">All Products</a></li>
					<li data-icon="carat-r"><a href="category.php" data-ajax="false">Product Categories</a></li>
					<li data-icon="carat-r"><a href="store.php" data-ajax="false">Store Partners</a></li>
					<li data-icon="carat-r"><a href="currency.php" data-ajax="false">Currency Format</a></li>
					<li data-icon="carat-r"><a href="admin.php" data-ajax="false">Admin Profil</a></li>
				</ul>
			</div> <!-- end of panel hiddenMenu -->
		</div> <!-- end of page -->
	</body>
</html>
