<?php 


$languageList=array_keys($languages);

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
	<link rel="stylesheet" href="./css/jquery-ui.min.css">
	<script src="./js/jquery.js"></script>
	<script src="./js/jquery-ui.min.js"></script>
	<script src="./js/utils.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	
	
	
	<script src="./bootstrap/js/popper.min.js"></script>
</head>





<body>
	<!-- **** B O D Y **** -->
	<header>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<div id="header">
				<span class="navbar-nav mr-auto">
				</span>
				<a href="index.php?view=search"><img id="logo_header"  src="./ressources/logotype_alstom.jpg"></a>
				
				<div id="content_header">
					<?php
					if (secure("status","SESSION") == "Administrator")
					{
						echo "<a id=\"administrationBtn\" href=\"index.php?view=administration\">". $translation["administration"] . "</a>";
					}

						// If the user is connected, a logout link is displayed
					if (secure("isConnected","SESSION"))
					{
						echo "<a id=\"logoutBtn\" href=\"controleur.php?action=Logout\">". $translation["logout"] . "</a>";
					}?>

					<form id="form_language" class="form-inline mt-2 mt-md-0" >
						<select id="selectLanguage" class="custom-select">
							<option value="" disabled selected><?php echo $translation["language"]?></option>
							<?php 

							foreach ($languageList as $key => $value) {
								echo "<option value='".$value."'>".$value."</option>";
							}

							?>
						</select>
					</form>
				</div>
			</div>
		</nav>
	</header>
