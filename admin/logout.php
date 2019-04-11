<?php
	session_start();  
	if(isset($_SESSION['Admin']))
	unset($_SESSION['Admin']);
	echo "<script> window.location='index.php'</script>";	
?>
