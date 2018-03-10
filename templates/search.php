<?php
/**
* \file search.php
* \brief This page is the main page of the website. It's the one that permits the users to search for documents.
* \author
* \version
*/

redirect("index.php?view=login&msg=".urlencode("You need to be logged in."));

//include "/../translations/search_translations.php";
$languageList=array_keys($languages);

$searchDatas=getSearchDatas();

?>
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
					console.log(oRep);
					if(oRep.length!=0)
						$("#results").html(JSON.stringify(oRep));
					else 
						$("#results").html("No results found");
				}
				);
			}
		});
	});
</script>



<!-- Begin page content -->
<main role="main" class="container">
	<div class="page-header">
		<h1><?php echo $translation["titlePage"]?></h1>
		<div id="headerSearch">

			<div id="form"> <!-- see Jquery function -->

				<div id="content_search_1">
					<div class="form_search">
						<label for="name"><?php echo $translation["doc_number"] ?></label>
						<input type="text" name="name"/>
					</div> 
					<div class="form_search">
						<label for="previous_doc"><?php echo $translation["previous_ref"] ?></label>
						<input type="text" name="previous_doc"/>
					</div>	
				</div>


				<div id="content_search_2">
					<div class="form_search">
						<label for="version"><?php echo $translation["version"] ?></label>
						<input type="text" name="version"/>
					</div>

					<div class="form_search" >
						<label for="pic"><?php echo $translation["pic"] ?></label>
						<input type="text" name="pic"/>
					</div>
				</div>


				<div class="form_search" id="content_search_3">
					<label for="baseline"><?php echo $translation["baseline"] ?></label>
					<select multiple name="gatc_baseline">
						<?php
						foreach ($searchDatas["baseline"] as $key => $value) {
							echo "<option value='".$value["GATC_baseline"]."'>".$value["GATC_baseline"]."</option>";
						}

						?>
					</select>
				</div>

				<div class="form_search" id="content_search_4">
					<label for="language"><?php echo $translation["language"]?></label>
					<select multiple name="initial_language">
						<?php
						foreach ($searchDatas["language"] as $key => $value) {
							echo "<option value='".$value["initial_language"]."'>".$value["initial_language"]."</option>";
						}

						?>
					</select>
				</div>

				<div class="form_search" id="content_search_5">
					<label for="type"><?php echo $translation["type"]?></label>
					<select multiple name="type">
						<option value="installation"><?php echo $translation["installation"]?></option>
						<option value="maintenance"><?php echo $translation["maintenance"]?></option>
					</select>
				</div>

				<div class="form_search" id="content_search_6">
					<label for="etcs_subsystem"><?php echo $translation["product"]?></label>
					<select multiple name="etcs_subsystem.id">
						<?php
						foreach ($searchDatas["product"] as $key => $value) {
							echo "<option value='".$value["id"]."'>".$value["subsystem_name"]."</option>";
						}

						?>
					</select>
				</div>

				<div class="form_search" id="content_search_7">
					<label for="component"><?php echo $translation["component"]?></label>
					<select multiple name="component">
						<?php
						foreach ($searchDatas["component"] as $key => $value) {
							echo "<option value='".$value["id"]."'>".$value["component_name"]."</option>";
						}

						?> 
					</select>
				</div>

				<div class="form_search" id="content_search_8">
					<label for="site"><?php echo $translation["site"]?></label>
					<select multiple name="site">
						<?php
						foreach ($searchDatas["site"] as $key => $value) {
							echo "<option value='".$value["site"]."'>".$value["site"]."</option>";
						}

						?>
					</select>
				</div>
				<div class="form_search" id="content_search_9">					
          <button type="button" class="btn btn-primary" id="send"><?php echo $translation["search"]?></button><!-- needs rework -->
				</div>
			</div> 
		</div>
	</div>
	<hr/> 
</div>
<div class="lead">
	<div id="resultsPage">
		<h1><?php echo $translation["result"]?></h1>
		<div id="results">
		</div>
	</div>
</div>
</main>


    <!-- Bootstrap core JavaScript
    	================================================== -->
    	<!-- Placed at the end of the document so the pages load faster -->

    	<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>



