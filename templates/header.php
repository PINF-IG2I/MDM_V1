<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>MDM - v1.0</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" />
	<link href="css/sticky-footer.css" rel="stylesheet" />
	<link href="bootstrap/css/light-bootstrap-dashboard.css" rel="stylesheet" />
	<!--[if lt IE 9]>
	  <script src="js/html5shiv.js"></script>
	  <script src="js/respond.min.js"></script>
	<![endif]-->

	<script src="js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	

</head>
<!-- **** E N D **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

	<!-- inspired from http://www.bootstrapzero.com/bootstrap-template/sticky-footer --> 

	<!-- Wrap all page content here -->
	<div id="wrap">

		<!-- Fixed navbar -->
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php?view=accueil">MDM 2018</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<!-- <li class="active"><a href="index.php?view=accueil">Accueil</a></li> -->
						<?=mkHeadLink("Home","accueil",$view)?>
						<?php
						// If the user is not connected, we display a login link
						if (!secure("isConnected","SESSION"))
							echo mkHeadLink("Login","login",$view); 
						?>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>



		<!-- Begin page content -->
		<div class="container">
