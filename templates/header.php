<?php 
/**
* \file header.php
* \author TOPINF team
* \version 1.0
* \brief This template is included at the beginning of each page on the website except the login page.
*/

/**
* \cond
*/
$languageList=array_keys($languages);
if(secure('status',"SESSION")=='Administrator') {
	$baselineList=listBaselines();
	$searchDatas=getSearchDatas();
}
	
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>MDM - Alstom</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>MDM - Alstom</title>

	<!-- Bootstrap core CSS -->
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

	<link rel="shortcut icon" type="image/x-icon" href="http://www.alstom.com/Templates/ui/img/icon/favicon.ico">
	<!-- Custom styles for this template -->


	<link rel="stylesheet" href="./css/jquery-ui.min.css">
	<link href="./css/sticky-footer.css" rel="stylesheet"/>
	<script src="./js/jquery.js"></script>
	<script src="./js/jquery-ui.min.js"></script>
	<script src="./js/utils.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

	<!-- (Optional) Latest compiled and minified JavaScript translation files -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</head>





<body>
	<!-- **** B O D Y **** -->
	<header>

		


		<nav class="navbar navbar-expand-sm navbar-dark fixed-top" style="background-color: rgb(12, 65, 173); border-radius: 0;">
			<div class="navbar-header">
				<a  class="nav-brand" href="index.php?view=search">
					<img style="width:150px; border-radius:50px; padding:5px"  src="./ressources/logotype_alstom.jpg">
				</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
					<?php
					if(secure("status","SESSION")=="Administrator" || (secure("status","SESSION")=="Manager" && secure("authorized","SESSION")==1))
					{
						echo "<li class=\"nav-item active\">
							<a class=\"nav-link  navbar-items\" id=\"addBaseline\" data-target=\"#newBaseline\" data-toggle=\"modal\">" . $translation["addBaseline"] . "</a>		
						</li>";
						echo "<li class=\"nav-item active\"> 
							<a class=\"nav-link  navbar-items\" id=\"addDoc\" data-target=\"#newDocument\" data-toggle=\"modal\">"
							. $translation["addDoc"] . "</a>
						</li>";
					}
					if (secure("status","SESSION") == "Administrator")
					{
						echo "<li class=\"nav-item active\">
							<a class=\"nav-link  navbar-items\" id=\"administrationBtn\" href=\"index.php?view=administration\">". $translation["administration"] . "</a>
						</li>";
					}

						// If the user is connected, a logout link is displayed
					if (secure("isConnected","SESSION"))
					{
						echo "<li class=\"nav-item\">";
						echo "<a class=\"nav-link  navbar-items\" id=\"help\" href=\"index.php?view=help\">".$translation["help"] . "</a>";
						echo "</li>";
						echo "<li class=\"nav-item\">";
						echo "<a class=\"nav-link  navbar-items\" id=\"logoutBtn\" href=\"controleur.php?action=Logout\">". $translation["logout"] . "</a>";
						echo "</li>";
					}?>
					
					<li class="nav-item dropdown">
						<div style="padding:6px;" class="form-group">
								<select style="padding:5px; border-radius:10px;"id="selectLanguage">
									<option value="" disabled selected><?php echo $translation["language"]?></option>
									<?php 

									foreach ($languageList as $key => $value) {
										echo "<option value='".$value."'>".$value."</option>";
									}

									?>
								</select>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</header>

<?php if(secure("status","SESSION")=="Administrator" OR secure("status","SESSION")=="Manager" && secure("authorized","SESSION")==1): ?>

	<!-- MODAL TO ADD A BASELINE -->
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
					<div class="modal-footer" style="text-align:center">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $translation["cancel"]?></button>
						<button type="button" id="baseline" class="btn btn-success"><?php echo $translation["add"]?></button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL TO ADD A DOCUMENT -->
		<div class="modal fade" id="newDocument" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
			<div class="modal-dialog" role="document" style="">
				<div class="modal-content" style="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modalLabel"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo $translation["addDoc"]?></h4>
					</div>
					<div class="modal-body" style="overflow-x:auto">
						<div class="form-group">
							<label class="col-sm-1" for="name"><?php echo $translation["reference"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["reference"] ?>" name="reference"></div>
							<label class="col-sm-1" for="previous_doc"><?php echo $translation["previous_ref"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" id="previous_ref" placeholder="<?php echo $translation["previous_ref"] ?>" name="previous_doc"></div>
							<label class="col-sm-1" for="version"><?php echo $translation["version"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" id="version" placeholder="<?php echo $translation["version"] ?>" name="version"></div>
							<label class="col-sm-1" for="inputPassword1"><?php echo $translation["pic"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" id="pic" placeholder="<?php echo $translation["pic"] ?>" name="pic"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-1" for="baseline"><?php echo $translation["baseline"] ?></label>
							<div class="col-sm-2">
								<select class="form-control selcls"  data-live-search="true" name="GATC_baseline">
									<?php
									foreach ($searchDatas["baseline"] as $key => $value) {
										echo "<option value='".$value["GATC_baseline"]."'>".$value["GATC_baseline"]."</option>";
									}

									?>
								</select>
							</div>
							<label class="col-sm-1" for="language"><?php echo $translation["language"]?></label>
							<div class="col-sm-2">
								<select class="form-control selcls" data-live-search="true" name="language">
									<?php
									foreach ($searchDatas["language"] as $key => $value) {
										echo "<option value='".$value["initial_language"]."'>".$value["initial_language"]."</option>";
									}

									?>
								</select>
							</div>
							<label class="col-sm-1" for="type"><?php echo $translation["type"]?></label>
							<div class="col-sm-2">
								<div style="margin-top:-2vw ;display: inline-block;">
									<label class="checkbox-inline"><input type="checkbox" name="installation" value="1"><b>&nbsp;<?php echo $translation["installation"]?></b></label>
									<label class="checkbox-inline"><input type="checkbox" name="maintenance" value="1"><b>&nbsp;<?php echo $translation["maintenance"]?></b></label>
								</div>
							</div>
							<label class="col-sm-1" for="type"><?php echo $translation["status"]?></label>
							<div class="col-sm-2">
								<select class="form-control selcls"  name="status">
									<option value="Internal"><?php echo $translation["internal"]?></option>
									<option value="Public"><?php echo $translation["public"]?></option>
									<option value="Draft"><?php echo $translation["draft"]?></option>
									<option value="Future"><?php echo $translation["future"]?></option>
									<option value="Obsolete"><?php echo $translation["obsolete"]?></option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1" for="site"><?php echo $translation["site"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["site"] ?>" name="site"></div>
							<label class="col-sm-1" for="product"><?php echo $translation["product"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["product"] ?>" name="product"></div>
							<label class="col-sm-1" for="component"><?php echo $translation["component"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["component"] ?>" name="component"></div>
							<label class="col-sm-1" for="translation"><?php echo $translation["translation"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["translation"] ?>" name="translation"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-1" for="project"><?php echo $translation["project"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["project"] ?>" name="project"></div>
							<label class="col-sm-1" for="translator"><?php echo $translation["translator"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["translator"] ?>" name="translator"></div>
							<label class="col-sm-1" for="aec_link"><?php echo $translation["aec"] ?></label>
							<div class="col-sm-2">
								<input type="text" style="margin:auto auto -2vw auto" class="form-control selcls" placeholder="<?php echo $translation["aec"] ?>" name="aec_link"><br>
								<div class="inlineBox">
									<label class="checkbox-inline" ><input type="checkbox" name="aec_different" value="1"><b>&nbsp;<?php echo $translation["up_to_date_aec"]?></b></label>
									<label class="checkbox-inline"><input type="checkbox" name="availability_aec" value="1"><b>&nbsp;<?php echo $translation["availability_aec"]?></b></label>
								</div>
							</div>
							<label class="col-sm-1" for="x_link"><?php echo $translation["x_link"] ?></label>
							<div class="col-sm-2">
								<input type="text" style="margin:auto auto -2vw auto" class="form-control selcls" placeholder="<?php echo $translation["x_link"] ?>" name="x_link"><br>
								<label class="checkbox-inline" ><input type="checkbox" name="availability_x" value="1"><b>&nbsp;<?php echo $translation["availability_x"]?></b></label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1" for="ftp_link"><?php echo $translation["ftp_link"] ?></label>
							<div class="col-sm-2">
								<input type="text" class="form-control selcls" placeholder="<?php echo $translation["ftp_link"] ?>" name="ftp_link">
								<label class="checkbox-inline" ><input type="checkbox" name="availability_ftp" value="1"><b>&nbsp;<?php echo $translation["availability_ftp"]?></b></label>
							</div>
							<label class="col-sm-1" for="sharepoint_vbn_link"><?php echo $translation["vbn"] ?></label>
							<div class="col-sm-2">
								<input type="text" class="form-control selcls" placeholder="<?php echo $translation["vbn"] ?>" name="sharepoint_vbn_link">
								<label class="checkbox-inline" ><input type="checkbox" name="availability_sharepoint_vbn" value="1"><b>&nbsp;<?php echo $translation["availability_sharepoint_vbn"]?></b></label>
							</div>
							<label class="col-sm-1" for="sharepoint_blq_link"><?php echo $translation["blq"] ?></label>
							<div class="col-sm-2">
								<input type="text" class="form-control selcls" placeholder="<?php echo $translation["blq"] ?>" name="sharepoint_blq_link">
								<label class="checkbox-inline" ><input type="checkbox" name="availability_sharepoint_blq" value="1"><b>&nbsp;<?php echo $translation["availability_sharepoint_blq"]?></b></label>
							</div>
							<label class="col-sm-1" for="remarks"><?php echo $translation["commentaries"] ?></label>
							<div class="col-sm-2"><textarea class="form-control selcls z-depth-1"  name="remarks" rows="3" ></textarea></div>
						</div>
						<div class="form-group">
							<label class="col-sm-1" for="working_field_1"><?php echo $translation["work1"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["work1"] ?>" name="working_field_1"></div>
							<label class="col-sm-1" for="working_field_2"><?php echo $translation["work2"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["work2"] ?>" name="working_field_2"></div>
							<label class="col-sm-1" for="working_field_3"><?php echo $translation["work3"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["work3"] ?>" name="working_field_3"></div>
							<label class="col-sm-1" for="working_field_4"><?php echo $translation["work4"] ?></label>
							<div class="col-sm-2"><input type="text" class="form-control selcls" placeholder="<?php echo $translation["work4"] ?>" name="working_field_4"></div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<button type="button" id="document" class="btn btn-info btn-block" ><?php echo $translation["add"]?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



<?php endif; ?>