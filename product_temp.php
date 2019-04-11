<?php
	include('include/connect.php');

	$prodID = $_GET['id'];
	$dbDate = mysql_fetch_array( mysql_query( "SELECT last_date_product_ex FROM tbl_product WHERE id_product='". $prodID ."'" ) );
	$dbImage = mysql_query( "SELECT image_name FROM tbl_image WHERE id_product='". $prodID ."'" );
	$dbThumb = mysql_query( "SELECT image_name FROM tbl_image WHERE id_product='". $prodID ."'" );
	$dbCategory = mysql_query( "SELECT id_product_categories, title_product_categories, categories_logo from tbl_product_categories" );
	$dbCurrency = mysql_fetch_array(mysql_query("SELECT type_currency FROM tbl_currency"));
	$dbProd = mysql_query( "SELECT product_name, price, discount, product_desc, product_url, store_name, store_address, store_phone, 
		store_logo, s.id_store FROM tbl_product p, tbl_store s WHERE id_product='". $prodID ."' AND p.id_store=s.id_store" );

	$rowProd = mysql_fetch_array( $dbProd );
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
			padding: 0 20px;
			margin: 1em auto 6.25em;
		}

		.contentview li {
			float: left;
			display: inline-block;
			margin: 5px 5px 20px 5px;
		}

		.contentview li#preview { 
			width: 30%; 
			background-color: #F0EFED; 
			padding: 12px; 
			padding-bottom: 7px;
			border: 1px solid #E6E2DA;
			border-radius: 10px;
		}

		.contentview li#preview div#imagepanel, .contentview li#preview div#.imagepanel img {
			width: 100%;
			margin-bottom: 2px;
		}

		.contentview li#preview div#imagepanel { position: relative; }

		.contentview li#preview div#imagepanel img {
			left: 0;
			position: absolute;

			-webkit-transition: opacity 1s ease-in-out;
			-moz-transition: opacity 1s ease-in-out;
			-o-transition: opacity 1s ease-in-out;
			transition: opacity 1s ease-in-out;
			opacity:0;
			-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
			filter: alpha(opacity=0);
		}

		.contentview li#preview div#imagepanel img.opaque {
			opacity:1;
			-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
			filter: alpha(opacity=1);
		}

		.contentview li#preview div#thumbpanel, .contentview li#preview div#thumbpanel span img { width: 100%; }
		.ui-block-a, .ui-block-b, .ui-block-c, .ui-block-d { padding-right: 3px; }

		.contentview li#description {
			width: 63.5%; text-align: left;
		}

		.contentview li#description div {
			margin-left: 10px;
			padding-right: 15px;
			padding-left: 15px;
			border: 1px solid #E6E2DA;
			border-radius: 10px;
			background-color: #F0EFED;
		}

		.contentview li#description div#store { margin-top: 18px; }
		.contentview li#description div.countdown {
			font-size: 25px;
			font-weight: bold;
			padding: 10px;
		}

		.contentview li#description div#product, .contentview li#description div#store { margin-top: 10px; }

		.contentview li#description div#store div#imgStore {
			margin-top: 10px;
			float: left;
			border: none;
			margin-left: -3px;
			padding-left: 0;
		}

		@media screen and (max-width: 1300px) {
			.contentview {
				width: auto;
			}
		}

		@media screen and (max-width: 1024px) {
			.contentview li#preview {
				width: 45%;
			}

			.contentview li#description {
				width: 55%;
			}
		}

		@media screen and (max-width: 960px) {
			.contentview li#preview, .contentview li#description, .contentview div.imagepanel img {
				width: 100%;
			}

			.contentview li#description div {
				margin-left: 0;
				margin-top: 10px;
			}

			.contentview li#description div#store {
				margin-top: 0;
			}
		}
	</style>

	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.countdown.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			// making image thumbnails in square size
			var divWidth = $('.ui-block-a').width();
			$('#thumbpanel span img').css('height', divWidth);

			// making image preview's height same with div's height
			var divHeight = $('#imagepanel img').height();
			$('#imagepanel').css('height', divHeight + 10);
;			
			// making image thumbnails clickable for showing image preview
			$("#thumbpanel").on('click', 'span', function() {
				$("#imagepanel img").removeClass("opaque");
				$("#thumbpanel span").removeClass("selected");

				var newImg = $(this).index();

				$("#imagepanel img").eq(newImg).addClass("opaque");
				$(this).addClass("selected");
			});
		});
	</script>

	<!-- making countdown from now to expire date of the product -->
	<?php echo "<script type='text/javascript'> $(function() {
		var endDate = '". date('Y-m-d', strtotime( $dbDate[0] )) ."';
		$('.countdown').countdown({ date: endDate });
	}); </script>";?>
</head>
<body>
	<div data-role='page' class='jqm-demos'>
		<div data-role='header' data-position='fixed' data-theme='f'>
			<h1>Belanja</h1>
			<a href="#hiddenMenu" data-icon='bars' data-iconpos='notext'>Menu</a>
		</div> <!-- end of header -->

		<div data-role='content'>
			<div class="contentview">
				<ul>
					<li id='preview'>
						<div id='imagepanel'>
						<?php $flag = 0;
							while($rowImg = mysql_fetch_array( $dbImage )):
								if( $flag == 0 ) {
									echo "<img src='img/product/". $prodID ."/". $rowImg[0] ."' class='opaque'>";
								} else {
									echo "<img src='img/product/". $prodID ."/". $rowImg[0] ."'>";
								} $flag++;
							endwhile;
						?></div> <!-- end of imagepanel -->
						<div id='thumbpanel' class='ui-grid-d'>
						<?php $flag = 0; while($rowThumb = mysql_fetch_array( $dbThumb )):
							if( $flag == 0 ) {
								$clSpan = 'ui-block-a';
							} elseif ( $flag == 1 ) {
								$clSpan = 'ui-block-b';
							} elseif ( $flag == 2 ) {
								$clSpan = 'ui-block-c';
							} elseif ( $flag == 3 ) {
								$clSpan = 'ui-block-d';
							} elseif ( $flag == 4 ) {
								$clSpan = 'ui-block-e';
							} $flag++;

							echo "<span class='". $clSpan ."'><img src='img/product/". $prodID ."/". $rowThumb[0] ."'></span>";
						endwhile; ?>
						</div> <!-- end of thumbpanel -->
					</li><li id='description'>
						<div class='countdown' style="text-align:center"></div> <!-- div for showing the countdown -->
						<div id='product'>
							<p style="font-size: 20px; font-weight: bold;">
							<?php
								echo $rowProd[0] ." - ";

								if( $rowProd[2] > 0 ) {
									echo "<font color='#c3c3c3' style='text-decoration:line-through'>". $dbCurrency[0] ." ". number_format( $rowProd[1], 2 ) ."</font>
										<font color='red'>". $rowProd[2] ." % OFF</font> &nbsp; &nbsp;
									<font color='#147206'>". $dbCurrency[0] ." ". number_format( round( $rowProd[1] - $rowProd[1] * $rowProd[2] / 100, 2), 2 ) ."</font>";
								} else {
									echo "<font color='#147206'>". $dbCurrency[0] ." ". $rowProd[1] ."</font>
									(<font color='red'>Best Price</font>)";
								}
							?></p>
							<p><?php echo $rowProd[3] ."<br/><a href='". $rowProd[4] ."'>". $rowProd[4] ."</a>"; ?></p>
						</div>
						<div id='store'>
							<div id='imgStore'><img src="<?php echo "img/store/". $rowProd[9] ."/". $rowProd[8]; ?>" style='width:110px'></div>
							<div style="border:none">
								<p><?php echo $rowProd[5] ."<br/>Address: ". $rowProd[6] ."<br/>Phone: ". $rowProd[7]; ?></p>
							</div>
						</div>
					</li>
				</ul>
			</div> <!-- end of contentview -->
		</div> <!-- end of content -->
		<div data-role="footer" data-position="fixed" data-theme="f">
			<h4>Copyright &copy; 2014, Belanja - Created for Mobile</h4>
		</div> <!-- end of footer -->

		<div data-role="panel" data-position-fixed="true" id="hiddenMenu">
			<ul data-role="listview" class="nav-search">
				<li data-icon="delete" data-theme="a"><a href="#" data-rel="close" style='font-size: 20px; font-weight: bold;'>Menu List</a></li>
				<li><a href="index.php" data-ajax="false" style='font-size: 18px; font-weight: bold;'>All Product</a></li>
				<?php
					// showing product's category for menu which user can choose
					while($rowCat = mysql_fetch_array($dbCategory)):
						echo "
							<li><a href='index.php?cat=" . $rowCat[0] . "' data-ajax='false'>
								<img src='img/product_category/" . $rowCat[0] . "/" . $rowCat[2] . "' class='ui-li-icon ui-corner-none'>
								<font style='font-size: 18px; font-weight: bold;'>" . $rowCat[1] . "</font>
							</a></li>
						";
					endwhile;
				?>
			</ul>
		</div> <!-- end of panel hiddenMenu -->
	</div>
</body>
</html>