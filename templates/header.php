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

	<script src="./js/jquery.js"></script>
	<script src="./js/utils.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	
	
	
	<script src="./bootstrap/js/popper.min.js."></script>
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



<!--

  <header>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="http://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/#">Fixed navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="http://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/#">Link</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="http://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/#">Disabled</a>
          </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
  </header>-->