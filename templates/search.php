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
$docs = listerDocs();
$docJSON = json_encode($docs);

?>

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
</div>
<div class="lead">
	<div id="resultsPage">
		<h1><?php echo $translation["result"]?></h1>
		<div id="results">
		</div>
	</div>
</div>
</main>

<table class="table table-striped" id="editDoc">
	<form action="controleur.php">
		<tbody>
			<tr>
				<td colspan="1">
					<div class="well form-horizontal">
						<fieldset>
							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo $translation["key"]?></label>
								<div class="col-md-8 inputGroupContainer">
									<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input readonly required id="Key" name="id_doc" placeholder=<?php echo $translation["key"]?> class="form-control" value="" type="text"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo $translation["file"]?></label>
								<div class="col-md-8 inputGroupContainer">
									<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="File" name="File" placeholder=<?php echo $translation["file"]?> class="form-control" value="" type="text"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo $translation["version"]?></label>
								<div class="col-md-8 inputGroupContainer">
									<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span><input id="Version" name="Version" placeholder=<?php echo $translation["version"]?> class="form-control" value="" type="text"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo $translation["baseline"]?></label>
								<div class="col-md-8 inputGroupContainer">
									<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span><input id="Baseline" name="Baseline" placeholder=<?php echo $translation["baseline"]?> class="form-control" value="" type="text"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo $translation["object"]?></label>
								<div class="col-md-8 inputGroupContainer">
									<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span><input id="Object" name="Object" placeholder=<?php echo $translation["object"]?> class="form-control" value="" type="text"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo $translation["site"]?></label>
								<div class="col-md-8 inputGroupContainer">
									<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="Site" name="Site" placeholder=<?php echo $translation["site"]?> class="form-control" value="" type="text"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo $translation["pic"]?></label>
								<div class="col-md-8 inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span><input id="PIC" name="PIC" placeholder=<?php echo $translation["pic"]?> class="form-control" value="" type="text">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label"><?php echo $translation["status"]?></label>
								<div class="col-md-8 inputGroupContainer">
									<div class="input-group">
										<input type="text" class="form-control" aria-label="Text input with dropdown button">
										<div class="dropdown">
											<button class="btn btn-info btn-fill dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $translation["choose"] ?>
												<span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right">
													<li><a class="dropdown-item" href="#"><?php echo $translation["inhibited"]?></a></li>
													<li><a class="dropdown-item" href="#"><?php echo $translation["intern"]?></a></li>
													<li><a class="dropdown-item" href="#"><?php echo $translation["extern"]?></a></li>
													<li><a class="dropdown-item" href="#"><?php echo $translation["manager"]?></a></li>
													<li><a class="dropdown-item" href="#"><?php echo $translation["administrator"]?></a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["initialLanguage"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span><input id="initialLanguage" name="initialLanguage" placeholder=<?php echo $translation["initialLanguage"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
							</fieldset>
						</div>
					</td>
					<td colspan="1">
						<div class="well form-horizontal">
							<fieldset>
								<div class="form-group" style="text-align:center">
									<label class="radio-inline"><input type="radio" name="optradio" id="Installation"><b><?php echo $translation["installation"]?></b></label>
									<label class="radio-inline"><input type="radio" name="optradio" id="Maintenance"><b><?php echo $translation["maintenance"]?></b></label>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["product"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input id="Product" name="Product" placeholder=<?php echo $translation["product"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["component"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input id="Component" name="Component" placeholder=<?php echo $translation["component"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["translation"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Translation" name="Translation" placeholder=<?php echo $translation["translation"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["project"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Project" name="Project" placeholder=<?php echo $translation["project"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["translator"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Translator" name="Translator" placeholder=<?php echo $translation["translator"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["previous_ref"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input id="Previous reference" name="Previous reference" placeholder=<?php echo $translation["previous_ref"]?> class="form-control" value="" type="text">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["aec"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="AEC" name="AEC" placeholder=<?php echo $translation["aec"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["network"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="Network" name="Network" placeholder=<?php echo $translation["network"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
							</fieldset>
						</div>
					</td>
					<td colspan="1">
						<div class="well form-horizontal">
							<fieldset>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["vbn"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="VBN" name="VBN" placeholder=<?php echo $translation["vbn"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["blq"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="BLQ" name="BLQ" placeholder=<?php echo $translation["blq"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group shadow-textarea">
									<label class="col-md-4 control-label"><?php echo $translation["commentaries"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><textarea class="form-control z-depth-1" id="Commentaries" rows="3"></textarea></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["work1"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work_1" name="Work 1" placeholder=<?php echo $translation["work1"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["work2"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work_2" name="Work 2" placeholder=<?php echo $translation["work2"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["work3"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work_3" name="Work 3" placeholder=<?php echo $translation["work3"]?> class="form-control" value="" type="text"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label"><?php echo $translation["work4"]?></label>
									<div class="col-md-8 inputGroupContainer">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work_4" name="Work 4" placeholder=<?php echo $translation["work4"]?> class="form-control" value="" type="text">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group" style="margin:0 auto">
										<div class="btn-group" role="group" aria-label="Basic example">
											<button type="submit" name="action" class="btn btn-info btn-fill"><?php echo $translation["save"]?></button>
											<button type="submit" value="deleteDoc" name="action" class="btn btn-info btn-fill"><?php echo $translation["delete"]?></button>
											<button type="submit" id="leaveEdit" class="btn btn-info btn-fill"><?php echo $translation["leave"]?></button>
										</div>
									</div>
								</div>


							</fieldset>
						</div>
					</td>
				</tr>
			</tbody>
		</form>
	</table>


    <!-- Bootstrap core JavaScript
    	================================================== -->
    	<!-- Placed at the end of the document so the pages load faster -->

    	<script>
    		function editDocu() {
    			var tabDocs = <?php echo $docJSON; ?>;
    			console.log(tabDocs);
    			$("#Key").val(tabDocs[this.id-1]["id_doc"]);
    			$("#initialLanguage").val(tabDocs[this.id-1]["initial_language"]);
    			$("#Version").val(tabDocs[this.id-1]["version"]);
    			$("#File").val(tabDocs[this.id-1]["name"]);
    			$("#Object").val(tabDocs[this.id-1]["subject"]);
    			$("#Baseline").val(tabDocs[this.id-1]["GATC_baseline"]);
    			$("#Site").val(tabDocs[this.id-1]["site"]);
    			$("#PIC").val(tabDocs[this.id-1]["PIC"]);
    			$("#Component").val(tabDocs[this.id-1]["component_name"]);
    			$("#Product").val(tabDocs[this.id-1]["subsystem_name"]);
    			$("#Project").val(tabDocs[this.id-1]["project"]);
    			$("#Translation").val(tabDocs[this.id-1]["language"]);
    			$("#Translator").val(tabDocs[this.id-1]["translator"]);
    			if(tabDocs[this.id-1]["installation"]==1)
    				$("#Installation").attr('checked',true);
    			if(tabDocs[this.id-1]["maintenance"]==1)
    				$("#Maintenance").attr('checked',true);
    			$("#Commentaries").val(tabDocs[this.id-1]["remarks"]);
    			$("#Work_1").val(tabDocs[this.id-1]["working_field_1"]);
    			$("#Work_2").val(tabDocs[this.id-1]["working_field_2"]);
    			$("#Work_3").val(tabDocs[this.id-1]["working_field_3"]);
    			$("#Work_4").val(tabDocs[this.id-1]["working_field_4"]);
    			$('#editDoc').dialog('open');
    		}


    		window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')
    	</script>



