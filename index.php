<?php
	include('include/connect.php');

	$query = "SELECT id_product, product_name, price, discount FROM tbl_product WHERE last_date_product_ex > CURRENT_DATE() AND date_product <= CURRENT_DATE()";
	$dbCategory = mysql_query("SELECT id_product_categories, title_product_categories, categories_logo FROM tbl_product_categories");
	$dbCurrency = mysql_fetch_array(mysql_query("SELECT type_currency FROM tbl_currency"));

	if ( !isset( $_GET['cat'] ) ) {
		$dbProduct = mysql_query( $query . " ORDER BY id_product DESC" );
	} else {
		$dbProduct = mysql_query( $query . " AND id_product_categories='" . $_GET['cat'] . "' ORDER BY id_product DESC" );
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ABSYS Store Demo</title>
	<link rel="shortcut icon" href="belanja.png">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">	
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.1.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">

	<style type="text/css">
		.contentview {
			width: 1280px;
			text-align: center;
			padding: 0 10px;
			margin: 0 auto 2em;
		}

		.contentview li {
			width: 300px;
			display: inline-block;
			margin: 20px 5px 5px 5px;
		}

		li.item { border-radius: 10px;}

		.contentview ul li a div {
			height: 200px;
			background-repeat: no-repeat;
			border-radius: 10px;

			background-size: cover;
			-moz-background-size: cover;
			-webkit-background-size: cover;
		}

		@media screen and (max-width: 1300px) {
			.contentview { width: auto; }
		}

		@media screen and (max-width: 600px) {
			.contentview li { width: 230px; }
			.contentview ul li a div { height: 150px; }
		}

		@media screen and (max-width: 480px) {
			.contentview li { width: 97%; }
			.contentview ul li a div { height: 200px; }
		}
	</style>

	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.1.min.js"></script>
</head>
<body>
	<div data-role="page">
		<div data-role="header" data-position="fixed" data-theme="f">
			<h1>Belanja</h1>
			<a href="#hiddenMenu" data-icon="bars" data-iconpos="notext">Menu</a>
		</div> <!-- end of header -->

		<div data-role="content" data-theme="c">
			<div class="contentview">
				<ul data-role="listview"  data-icon="false">
					<?php while ($rowProd = mysql_fetch_array( $dbProduct )):
						$dbImg = mysql_fetch_array( mysql_query( "SELECT id_image, image_name FROM tbl_image WHERE id_product='" . $rowProd[0] . "' ORDER BY id_image ASC" ) );
						echo "<li class='item'><a href='product.php?id=" . $rowProd[0] . "' data-ajax='false'>
								<div style='background-image:url(img/product/" . $rowProd[0] . "/" . $dbImg[1] . ")'></div>
								<h1 style='font-size:18px'>" . $rowProd[1] . "</h1>";

								if ( $rowProd[3] > 0 ) {
									echo 	"<p>
												<font size='3px' weight='bold' color='#c3c3c3' style='text-decoration:line-through'>" . $dbCurrency[0] . " " . number_format( $rowProd[2], 2 ) . "</font>
												&nbsp;&nbsp; <font weight='bold' color='red'>" . $rowProd[3] . "% OFF</font> &nbsp;&nbsp;
												<font size='3px' weight='bold' color='#147206'>" . $dbCurrency[0] . " " . number_format( round( $rowProd[2] - $rowProd[2] * $rowProd[3] / 100, 2 ), 2 ) . "</font>
											</p>";
								} else {
									echo 	"<p>
												<font size='3px' weight='bold' color='red'>Best Price</font>
												<font size='3px' weight='bold' color='#417206'>" . $dbCurrency[0] . " " . $rowProd[2] . "</font>
											</p>";
								}
						echo "</a></li>";
					endwhile; ?>
				</ul>
			</div>
		</div> <!-- end of content -->

		<div data-role="footer" data-position="fixed" data-theme="f">
			<h4>Copyright &copy; 2014, ABSYS - Created for Mobile</h4>
		</div>

		<div data-role="panel" data-position-fixed="true" id="hiddenMenu" >
			<ul data-role="listview" class="nav-search">
				<li data-icon="delete" data-theme="a"><a href="#" data-rel="close" style='font-size: 20px; font-weight: bold;'>Menu List</a></li>
				<li><a href="index.php" data-ajax="false" style='font-size: 18px; font-weight: bold;'>All Product</a></li>
				<?php while($rowCat = mysql_fetch_array($dbCategory)):
					echo "
						<li><a href='index.php?cat=" . $rowCat[0] . "' data-ajax='false'>
							<img src='img/product_category/" . $rowCat[0] . "/" . $rowCat[2] . "' class='ui-li-icon ui-corner-none'>
							<font style='font-size: 18px; font-weight: bold;'>" . $rowCat[1] . "</font>
						</a></li>
					";
				endwhile; ?>
			</ul>
		</div> <!-- end of panel hiddenMenu -->
	</div>
</body>
</html>