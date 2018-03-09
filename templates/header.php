<?php 


$languageList=getLanguages();
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>MDM - Alstom</title>

	<!-- Bootstrap core CSS -->
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

	<!-- Custom styles for this template -->
	<link href="./bootstrap/css/sticky-footer-navbar.css" rel="stylesheet"/>
	<link href="./css/sticky-footer.css" rel="stylesheet"/>

	<script src="./bootstrap/js/bootstrap.min.js"></script>
	<script src="./js/jquery.js"></script>
	<script src="./bootstrap/js/popper.min.js."></script>
</head>



<body>
<!-- **** B O D Y **** -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<span class="navbar-nav mr-auto">
				</span>
					<img id="logo_header"  src="./ressources/logotype_alstom.jpg">
				
					<?php
				// If the user is connected, a logout link is displayed
				if (secure("isConnected","SESSION"))
				{
					echo "<a id=\"logoutBtn\" href=\"controleur.php?action=Logout\">Logout</a>";
				}?>

				<form class="form-inline mt-2 mt-md-0">
					<select class="custom-select" id="selectLanguage">
						<option value="" disabled selected><?php echo $translation["language"]?></option>
						<?php 

						foreach ($languageList as $key => $value) {
							echo "<option value='".$value["language"]."'>".$value["language"]."</option>";
						}


						?>
					</select>
				</form>
			</div>
		</nav>
