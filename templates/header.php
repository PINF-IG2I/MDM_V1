<?php 


$languageList=array_keys($languages);
if(secure('status',"SESSION"=='Administrator'))
	$baselineList=listBaselines();

?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>MDM - Alstom</title>

	<!-- Bootstrap core CSS -->
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet"/>


	<!-- Custom styles for this template -->


	<link rel="stylesheet" href="./css/jquery-ui.min.css">
	<link href="./css/sticky-footer.css" rel="stylesheet"/>
	<script src="./js/jquery.js"></script>
	<script src="./js/jquery-ui.min.js"></script>
	<script src="./js/utils.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

	<script src="./bootstrap/js/popper.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
	<link href="./bootstrap/css/sticky-footer-navbar.css" rel="stylesheet"/>	
	

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
					if(secure("status","SESSION")=="Administrator" || (secure("status","SESSION")=="Manager" && secure("authorized","SESSION")==1))
					{
						echo "<a id=\"addBaseline\" data-target=\"#newBaseline\" data-toggle=\"modal\">" . $translation["addBaseline"] . "</a>";		
						echo "<a id=\"addDoc\" data-target=\"#newDocument\" data-toggle=\"modal\">" . $translation["addDoc"] . "</a>";
					}
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
						<select id="selectLanguage" class="selectpicker"/ >
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
<!-- MODAL TO ADD A BASELINE -->
<?php if(secure("status","SESSION")=="Administrator" OR secure("status","SESSION")=="Manager" && secure("authorized","SESSION")==1): ?>
	<div class="modal fade" id="newBaseline" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalLabel"><?php echo $translation["addBaseline"]?></h4>
				</div>
				<div class="modal-body">
					<form class="well form-horizontal">
						<fieldset>
							<div class="form-group">
								<label for="gatc" class="col-md-4 control-label"><?php echo $translation["gatc"]?></label>
								<div class="col-sm-7 inputGroupContainer">
									<input required id="gatc" name="gatc_baseline" class="form-control" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="unisig" class="col-md-4 control-label"><?php echo $translation["unisig"]?></label>
								<div class="col-sm-7 inputGroupContainer">
									<input required id="unisig" name="unisig_baseline" class="form-control" type="text" />
								</div>
							</div>
							<br/>
						</fieldset>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $translation["cancel"]?></button>
						<button type="button" id="baseline" class="btn btn-primary"><?php echo $translation["add"]?></button>
					</form>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>