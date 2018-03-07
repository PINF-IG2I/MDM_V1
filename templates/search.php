<?php
/**
* \file search.php
* \brief This page is the main page of the website. It's the one that permits the users to search for documents.
* \author
* \version
*/

redirect("index.php?view=login&msg=".urlencode("You need to be logged in."));

//include "/../translations/search_translations.php";
$languageList=getLanguages();

$searchDatas=getSearchDatas();

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
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	<script src="./js/jquery.js"></script>
	<script src="./bootstrap/js/popper.min.js."></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#selectLanguage").change(function(){
				$.ajax({
					url : "controleur.php",
					data : {
						'action' : 'changeLanguage',
						'language' : $("#selectLanguage option:selected").val()
					},
					success : location.reload()
				});
			});
			$("#send").click(function(){
				var oQuery={};
				$("#headerSearch input").each(function(){
					var key= $(this).attr("name");
					var value=$(this).val();
					if(value!="")
						oQuery[key]=value;
					console.log(oQuery);
				});
				$("#headerSearch select").each(function(){
					var key= $(this).attr("name");
					var value=$(this).val();
					console.log(key);
					console.log(value);
					if(value!=null){
						oQuery[key]=value;
						console.log(oQuery);

					}
				});
				console.log(oQuery);
				if(!$.isEmptyObject(oQuery)){
					$.getJSON( "controleur.php",
					{
						"action":"Search",
						"data":oQuery
					},
					function(oRep){	
						$("#results").html(oRep);
					}
					);
				}
			});
		});


	</script>
</head>

<body>

	<header>
		<!-- Fixed navbar -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a class="navbar-brand" href="http://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/#">Fixed navbar</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<span class="navbar-nav mr-auto">
				</span>
				<form class="form-inline mt-2 mt-md-0">
					<select id="selectLanguage">
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
	</header>

	<!-- Begin page content -->
	<main role="main" class="container">
		<div class="page-header">
			<h1><?php echo $translation["titlePage"]?></h1>
			<div id="headerSearch">

				<div id="form"> <!-- see Jquery function -->
					<label for="name"><?php echo $translation["doc_number"] ?></label>
					<input type="text" name="name"/>
					<label for="version"><?php echo $translation["version"] ?></label>
					<input type="text" name="version"/>
					<label for="previous_doc"><?php echo $translation["previous_ref"] ?></label>
					<input type="text" name="previous_doc"/>
					<label for="pic"><?php echo $translation["pic"] ?></label>
					<input type="text" name="pic"/>
					<label for="baseline"><?php echo $translation["baseline"] ?></label>
					<select multiple name="gatc_baseline">
						<?php
						foreach ($searchDatas["baseline"] as $key => $value) {
							echo "<option value='".$value["GATC_baseline"]."'>".$value["GATC_baseline"]."</option>";
						}

						?>
					</select>
					<label for="initial_language"><?php echo $translation["language"]?></label>
					<select multiple name="initial_language">
						<?php
						foreach ($searchDatas["language"] as $key => $value) {
							echo "<option value='".$value["language"]."'>".$value["language"]."</option>";
						}

						?>
					</select>
					<label for="type"><?php echo $translation["type"]?></label>
					<select multiple name="type">
						<option value="installation"><?php echo $translation["installation"]?></option>
						<option value="maintenance"><?php echo $translation["maintenance"]?></option>
					</select>
					<label for="etcs_subsystem"><?php echo $translation["product"]?></label>
					<select multiple name="etcs_subsystem.id">
						<?php
						foreach ($searchDatas["product"] as $key => $value) {
							echo "<option value='".$value["id"]."'>".$value["subsystem_name"]."</option>";
						}

						?>
					</select>
					<label for="component"><?php echo $translation["component"]?></label>
					<select multiple name="component">
						<?php
						foreach ($searchDatas["component"] as $key => $value) {
							echo "<option value='".$value["id"]."'>".$value["component_name"]."</option>";
						}

						?> 
					</select>
					<label for="site"><?php echo $translation["site"]?></label>
					<select multiple name="site">
						<?php
						foreach ($searchDatas["site"] as $key => $value) {
							echo "<option value='".$value["site"]."'>".$value["site"]."</option>";
						}

						?>
					</select>
					<button type="button" class="btn btn-primary" id="send"><?php echo $translation["search"]?></button>

				</div> 
			</div>
		</div>
		<hr/> 
	</div>
	<p class="lead">
		<div id="resultsPage">
			<h1><?php echo $translation["result"]?></h1>
			<div id="results">
			</div>
		</div>
	</p>
</main>


    <!-- Bootstrap core JavaScript
    	================================================== -->
    	<!-- Placed at the end of the document so the pages load faster -->

    	<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>



