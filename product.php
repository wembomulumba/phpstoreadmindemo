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
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.countdown.js"></script>

	<!-- Demo CSS -->
	<link rel="stylesheet" href="css/slider/flexslider.css" type="text/css" media="screen" />

	<!-- Modernizr -->
    <script src="css/slider/js/modernizr.js"></script>
	
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
	
	<style>
		@media screen and (min-width: 600px) {
			#contentview { width: 80%; margin: 0 auto; }
		}
		
		@media screen and (min-width: 1024px) {
			#contentview { width: 70%; margin: 0 auto; }
		}
	</style>

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
	
		<div data-role="content" id="contentview">
			 <div class="flexslider">
			  <ul class="slides">
					<?php $flag = 0;
								while($rowImg = mysql_fetch_array( $dbImage )):
									if( $flag == 0 ) {
									echo "<li data-thumb='img/product/". $prodID ."/". $rowImg[0] ."'>
										<img src='img/product/". $prodID ."/". $rowImg[0] ."' />
										</li>";
									} else {
									echo "<li data-thumb='img/product/". $prodID ."/". $rowImg[0] ."'>
										<img src='img/product/". $prodID ."/". $rowImg[0] ."' />
										</li>";
									} $flag++;
								endwhile;
							?>
			  </ul>
			</div>
			
			<div class="ui-body ui-body-a ui-corner-all" style="margin:5px 0 5px 0;">	
				<div class='countdown' style="text-align:center"></div> <!-- div for showing the countdown -->
			</div>
			
			<div class="ui-body ui-body-a ui-corner-all">	
				<p style="text-align: justify;"><?php echo $rowProd[0];?>
				</p>
				<p style="text-align: center;">
				<strong>
				<?php
								if( $rowProd[2] > 0 ) {
									echo "<font color='#c3c3c3' style='text-decoration:line-through'>". $dbCurrency[0] ." ". number_format( $rowProd[1], 2 ) ."</font>
										<font color='red'>". $rowProd[2] ." % OFF</font> &nbsp; &nbsp;
									<font color='#147206'>". $dbCurrency[0] ." ". number_format( round( $rowProd[1] - $rowProd[1] * $rowProd[2] / 100, 2), 2 ) ."</font>";
								} else {
									echo "<font color='#147206'>". $dbCurrency[0] ." ". $rowProd[1] ."</font>
									(<font color='red'>Best Price</font>)";
								}
								
				?>
					</strong></p>
					<p><?php echo $rowProd[3] ."<br/><a href='". $rowProd[4] ."'>". $rowProd[4] ."</a>"; ?></p>
			</div>
			<ul data-role="listview" data-inset="true"   style="margin-top:5px;"> 
						<li>
						<a href="<?php echo "tel:".$rowProd[7]?>"> <img src="<?php echo "img/store/". $rowProd[9] ."/". $rowProd[8]; ?>" style="height:100%;width:90px; margin-top:7px;margin-left:5px"/><h3><?php echo $rowProd[5] ."<br/>Address: ". $rowProd[6] ."<br/>Phone: ". $rowProd[7]; ?></h3></a>
							</li>
					</ul>
		</div>
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
	
  <!-- FlexSlider -->
  <script defer src="css/slider/jquery.flexslider.js"></script>

  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
	
  <!-- Syntax Highlighter -->
  <script type="text/javascript" src="css/slider/js/shCore.js"></script>
  <script type="text/javascript" src="css/slider/js/shBrushXml.js"></script>
  <script type="text/javascript" src="css/slider/js/shBrushJScript.js"></script>

  <!-- Optional FlexSlider Additions -->
  <script src="css/slider/js/jquery.easing.js"></script>
  <script src="css/slider/js/jquery.mousewheel.js"></script>
  <script defer src="css/slider/js/demo.js"></script>
	
</body>
</html>