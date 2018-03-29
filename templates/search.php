<?php
/**
* \file search.php
* \brief This page is the main page of the website. It's the one that permits the users to search for documents.
* \author
* \version
*/

redirect("./index.php?view=login&msg=".urlencode("You need to be logged in."));


$languageList=array_keys($languages);

$searchDatas=getSearchDatas();

if(secure("status","SESSION")=='Manager'){
	$id_manager=connectedManager();
	if($id_manager==secure("id_user","SESSION")){
		$_SESSION["authorized"]=1;
	} else if (getIsConnected($id_manager)=="0" || ($id_manager=="")) {
		writeInFile("manager",secure("id_user","SESSION"));
		$_SESSION["authorized"]=1;
	} else $_SESSION["authorized"]=0;
}


if(secure("status","SESSION")=='Manager'){
	$id_manager=connectedManager();
	if($id_manager==secure("id_user","SESSION")){
		$_SESSION["authorized"]=1;
	} else if (getIsConnected($id_manager)=="0" || ($id_manager=="")) {
		writeInFile("manager",secure("id_user","SESSION"));
		$_SESSION["authorized"]=1;
	} else $_SESSION["authorized"]=0;
}


?>


<?php
foreach ($searchDatas["reference"] as $key => $value) $tab_name[]= $value["reference"];
$name = "[";
for($i=0;$i<sizeof($tab_name)-1;$i++) $name.= "\"". $tab_name[$i] . "\",";
	$name .= "\"". $tab_name[sizeof($tab_name)-1] . "\"]";

foreach ($searchDatas["previous_doc"] as $key => $value) $tab_previous_doc
	[]= $value["previous_doc"];
$previous_doc = "[";
for($i=0;$i<sizeof($tab_previous_doc)-1;$i++) $previous_doc.= "\"". $tab_previous_doc[$i] . "\",";
	$previous_doc .= "\"". $tab_previous_doc[sizeof($tab_previous_doc)-1] . "\"]";


foreach ($searchDatas["version"] as $key => $value) $tab_version[]= $value["version"];
$version = "[";
for($i=0;$i<sizeof($tab_version)-1;$i++) $version.= "\"". $tab_version[$i] . "\",";
	$version .= "\"". $tab_version[sizeof($tab_version)-1] . "\"]";

foreach ($searchDatas["pic"] as $key => $value) $tab_pic[]= $value["pic"];
$pic = "[";
for($i=0;$i<sizeof($tab_pic)-1;$i++) $pic.= "\"". $tab_pic[$i] . "\",";
	$pic .= "\"". $tab_pic[sizeof($tab_pic)-1] . "\"]";
?>


<!-- Begin page content -->
<main role="main" class="container">
	<?php
	if(managerConnected() && secure("status","SESSION")!='Manager'){
		echo '<div class="alert alert-warning text-center"><strong>';
		echo  $translation["manager_connected"];
		echo '</strong></div>';
	} else if(secure("status","SESSION")=="Manager" && secure("authorized","SESSION")==1){
		echo '<div class="alert alert-success text-center" role="alert"><strong>';
		echo $translation["manager_in_charge"];
		echo '</strong></div>';
	} else if (secure("status","SESSION")=="Manager" && secure("authorized","SESSION")==0){
		echo '<div class="alert alert-info text-center" role="alert"><strong>';
		echo $translation["manager_not_in_charge"];
		echo '</strong></div>';
	}
	?>
	<div class="page-header">
		<h1><?php echo $translation["titlePage"]?></h1>
	</div>
	<?php 
		if(secure("status","SESSION")=='Administrator' || (secure("status","SESSION")=="Manager" && secure("authorized","SESSION")==1)){
		echo'
		<form action="controleur.php" method="post" enctype="multipart/form-data">
		<label for="file">'.$translation["import"].'</label>
		<input type="file" name="file" id="file" />
		<button type="submit" name="action" value="import" >'.$translation["import"].'</button>
		</form>';
		}
	?>
	<form role="form" class="form-horizontal" id="headerSearch">
				
		<!-- doc_number and previous_doc input -->
		<div id="content_search_1">
			<div class="form_search">
				<label for="name"><?php echo $translation["doc_number"] ?></label>
				<input id="doc_number" type="text" name="reference"/>
			</div> 

			<div class="form_search">
				<label for="previous_doc"><?php echo $translation["previous_ref"] ?></label>
				<input id="previous_ref" type="text" name="previous_doc"/>
			</div>	
		</div>

		<!-- version and pic input -->
		<div id="content_search_2">
			<div class="form_search">
				<label for="version"><?php echo $translation["version"] ?></label>
				<input id="version" type="text" name="version"/>
			</div>

			<div class="form_search" >
				<label for="pic"><?php echo $translation["pic"] ?></label>
				<input id="pic" type="text" name="pic"/>
			</div>
		</div>

		<!-- baseline select-->
		<div class="form_search" id="content_search_3">
			<label for="baseline"><?php echo $translation["baseline"] ?></label>
		
			<select multiple name="gatc_baseline">
				<?php
				foreach ($searchDatas["baseline"] as $key => $value) {
					echo "<div><option value='".$value["GATC_baseline"]."'>".$value["GATC_baseline"]."</option></div>";
				}

				?>
			</select>

			<!--<div class="multiselect"  multiple name="gatc_baseline" >

				<?php
					foreach ($searchDatas["baseline"] as $key => $value) {
						echo "<label> <input type='checkbox' value='".$value["GATC_baseline"]."'>".$value["GATC_baseline"]."</label>";
					}
				?>
			</div>-->



		</div>

		<!-- language select -->
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

		<!--  type select, only 2 options available : Installation and Maintenance -->
		<div class="form_search" id="content_search_5">
			<label for="type"><?php echo $translation["type"]?></label>
			<select multiple name="type">
				<option value="installation"><?php echo $translation["installation"]?></option>
				<option value="maintenance"><?php echo $translation["maintenance"]?></option>
			</select>
		</div>


		<!-- product select-->
		<div class="form_search" id="content_search_6">
			<label for="etcs_subsystem"><?php echo $translation["product"]?></label>
			<select multiple name="product">
				<?php
				foreach ($searchDatas["product"] as $key => $value) {
					echo "<option value='".$value["product"]."'>".$value["product"]."</option>";
				}

				?>
			</select>
		</div>

		<!-- component select-->
		<div class="form_search" id="content_search_7">
			<label for="component"><?php echo $translation["component"]?></label>
			<select multiple name="component">
				<?php
				foreach ($searchDatas["component"] as $key => $value) {
					echo "<option value='".$value["component"]."'>".$value["component"]."</option>";
				}

				?> 
			</select>
		</div>

		<!-- site select-->
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


		<br>
		<div class="form_search" id="content_search_9">					
			<button type="button" class="btn btn-primary" id="send"><?php echo $translation["search"]?></button><!-- needs rework -->
		</div>
	</form>


	<div class="lead">
		<div style="display:none" id="hiddenDiv"><?php echo $translation["no_result"] ?></div>
		<div id="resultsPage">
			<div class="page-header">
				<center><h1><?php echo $translation["result"]?></h1></center>
			</div>
			<form action="controleur.php" class="text-center">
				<input type="hidden" name="data"  id="searchValues">
				<button type="submit" id="exportButton" class="btn btn-primary btn-block" name="action" value="exportResults" style="display: none;width:60%;margin:auto"><?php echo $translation["export"]?></button>
			</form>
			<br>
			<div id="results">
			</div>
		</div>
	</div>
</main>

<?php 
if(secure("status","SESSION")=="Administrator" OR secure("status","SESSION")=="Manager" && secure("authorized","SESSION")==1) {
	?>

	<div class="modal fade" id="editDoc" tabindex="-1" role="dialog" aria-labelledby="modalLabelCreate">
		<form  action="controleur.php">
			<div class="modal-dialog" role="document" style="width:80%;height:100%">
				<div class="modal-content" style="height:100%;overflow:auto">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modalLabelCreate"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?php echo $translation["update_document"] ?></h4>
					</div>
					<div class="modal-body" style="overflow-x:auto">
						<table class="table table-striped" id="editDoc">
							<td>
								<div class="well form-horizontal">
									<fieldset>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["key"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input readonly required id="Key" name="document.id_doc" placeholder=<?php echo $translation["key"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["reference"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="Reference" name="reference" placeholder=<?php echo $translation["reference"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["object"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span><input id="Object" name="subject" placeholder=<?php echo $translation["object"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["version"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span><input id="Version" name="version" placeholder=<?php echo $translation["version"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["baseline"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span><input id="Baseline" name="GATC_baseline" placeholder=<?php echo $translation["baseline"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["site"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="Site" name="site" placeholder=<?php echo $translation["site"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["pic"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group">
													<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span><input id="PIC" name="pic" placeholder=<?php echo $translation["pic"]?> class="form-control" value="" type="text">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["status"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group">
													<input type="text" class="form-control" name="document_version.status" aria-label="Text input with dropdown button" id="displayStatus">
													<div class="input-group-btn">
														<div class="btn-group" style="overflow:visible;z-index:99">
															<button class="btn btn-info btn-fill dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $translation["choose"] ?>
																<span class="caret"></span>
															</button>
															<ul class="dropdown-menu dropdown-menu-right" id="statusDoc">
																<li><a class="dropdown-item" href="#"><?php echo $translation["internal"]?></a></li>
																<li><a class="dropdown-item" href="#"><?php echo $translation["public"]?></a></li>
																<li><a class="dropdown-item" href="#"><?php echo $translation["draft"]?></a></li>
																<li><a class="dropdown-item" href="#"><?php echo $translation["future"]?></a></li>
																<li><a class="dropdown-item" href="#"><?php echo $translation["obsolete"]?></a></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["initialLanguage"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span><input id="initialLanguage" name="initial_language" placeholder=<?php echo $translation["initialLanguage"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group" style="text-align:center">
											<label class="checkbox-inline"><input type="checkbox" name="installation" id="Installation" value="1"><b><?php echo $translation["installation"]?></b></label>
											<label class="checkbox-inline"><input type="checkbox" name="maintenance" id="Maintenance" value="1"><b><?php echo $translation["maintenance"]?></b></label>
										</div>
									</fieldset>
								</div>
							</td>
							<td colspan="1">
								<div class="well form-horizontal">
									<fieldset>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["product"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input id="Product" name="product" placeholder=<?php echo $translation["product"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["component"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input id="Component" name="component" placeholder=<?php echo $translation["component"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["translation"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Translation" name="document_language.language" placeholder=<?php echo $translation["translation"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["project"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Project" name="project" placeholder=<?php echo $translation["project"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["translator"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Translator" name="translator" placeholder=<?php echo $translation["translator"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["previous_ref"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group">
													<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input id="Previous reference" name="previous_doc" placeholder=<?php echo $translation["previous_ref"]?> class="form-control" value="" type="text">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["aec"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="form-inline">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
														<input id="AEC" name="aec_link" placeholder=<?php echo $translation["aec"]?> class="form-control" value="" type="text">
													</div>
													&nbsp;
													<div class="input-group">
														<b><?php echo $translation["availability_aec"]?></b>
														&nbsp;
														<input type="checkbox" name="availability_aec" id="availability_aec" value="1">
													</div>
													&nbsp;
													<div class="input-group">
														<b><?php echo $translation["up_to_date_aec"]?></b>
														&nbsp;
														<input type="checkbox" name="different_aec" id="aec_different" value="1">
													</div>
												</div>

											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["x_link"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="form-inline">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
														<input id="x_link" name="x_link" placeholder=<?php echo $translation["x_link"]?> class="form-control" value="" type="text">
													</div>
													&nbsp;
													<div class="input-group">
														<b><?php echo $translation["availability_x"]?></b>
														&nbsp;
														<input type="checkbox" name="availability_x" id="availability_x" value="1">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["ftp_link"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="form-inline">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
														<input id="ftp_link" name="ftp_link" placeholder=<?php echo $translation["ftp_link"]?> class="form-control" value="" type="text">
													</div>
													&nbsp;
													<div class="input-group">
														<b><?php echo $translation["availability_ftp"]?></b>
														&nbsp;
														<input type="checkbox" name="availability_ftp" id="availability_ftp" value="1">
													</div>
												</div>
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
												<div class="form-inline">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
														<input id="VBN" name="sharepoint_vbn_link" placeholder=<?php echo $translation["vbn"]?> class="form-control" value="" type="text">
													</div>
													&nbsp;
													<div class="input-group">
														<b><?php echo $translation["availability_sharepoint_vbn"]?></b>
														&nbsp;
														<input type="checkbox" name="availability_sharepoint_vbn" id="availability_sharepoint_vbn" value="1">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["blq"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="form-inline">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
														<input id="BLQ" name="sharepoint_blq_link" placeholder=<?php echo $translation["blq"]?> class="form-control" value="" type="text">
													</div>
													&nbsp;
													<div class="input-group">
														<b><?php echo $translation["availability_sharepoint_blq"]?></b>
														&nbsp;
														<input type="checkbox" name="availability_sharepoint_blq" id="availability_sharepoint_blq" value="1">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["commentaries"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group" style="width:100%"><textarea class="form-control z-depth-1" id="Commentaries" name="remarks" rows="3" ></textarea></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["work1"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work_1" name="working_field_1" placeholder=<?php echo $translation["work1"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["work2"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work_2" name="working_field_2" placeholder=<?php echo $translation["work2"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["work3"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work_3" name="working_field_3" placeholder=<?php echo $translation["work3"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["work4"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group">
													<span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work_4" name="working_field_4" placeholder=<?php echo $translation["work4"]?> class="form-control" value="" type="text">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group" style="margin:0 auto">
												<div class="btn-group" role="group" aria-label="Basic example">
													<button type="button" data-target="#changeDoc" data-toggle="modal" class="btn btn-info btn-fill"><?php echo $translation["save"]?></button>
													<button type="button" data-target="#deleteDoc" data-toggle="modal" class="btn btn-info btn-fill"><?php echo $translation["delete"]?></button>
													<button type="button" id="leaveEdit" class="btn btn-info btn-fill" data-dismiss="modal" aria-label="Close"><?php echo $translation["leave"]?></button>
												</div>
											</div>
										</div>
									</fieldset>
								</div>
							</td>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>






	<?php 
}
else {
	?>

	<div class="modal fade" id="editDoc" tabindex="-1" role="dialog" aria-labelledby="modalLabelCreate">
		<form  action="controleur.php">
			<div class="modal-dialog" role="document" style="width:80%;height:100%">
				<div class="modal-content" style="height:100%;overflow:auto">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modalLabelCreate"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?php echo $translation["details_document"] ?></h4>
					</div>
					<div class="modal-body" style="overflow-x:auto">
						<table class="table table-striped" id="editDoc">
							<td>
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
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input readonly id="File" name="File" placeholder=<?php echo $translation["file"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["version"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span><input readonly id="Version" name="Version" placeholder=<?php echo $translation["version"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["baseline"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span><input readonly id="Baseline" name="Baseline" placeholder=<?php echo $translation["baseline"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["object"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span><input readonly id="Object" name="Object" placeholder=<?php echo $translation["object"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["site"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input readonly id="Site" name="Site" placeholder=<?php echo $translation["site"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["pic"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group">
													<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span><input readonly id="PIC" name="PIC" placeholder=<?php echo $translation["pic"]?> class="form-control" value="" type="text">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["status"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group">
													<span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span>
													<input readonly type="text" class="form-control" name="status" id="displayStatus">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["initialLanguage"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group">
													<span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span><input readonly id="initialLanguage" name="initialLanguage" placeholder=<?php echo $translation["initialLanguage"]?> class="form-control" value="" type="text">
												</div>
											</div>
										</div>
									</fieldset>
								</div>
							</td>
							<td colspan="1">
								<div class="well form-horizontal">
									<fieldset>
										<div class="form-group" style="text-align:center">
											<label class="checkbox-inline"><input type="checkbox" disabled="disabled" name="optradio" id="Installation"><b><?php echo $translation["installation"]?></b></label>
											<label class="checkbox-inline"><input type="checkbox" disabled="disabled" name="optradio" id="Maintenance"><b><?php echo $translation["maintenance"]?></b></label>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["product"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input readonly id="Product" name="Product" placeholder=<?php echo $translation["product"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["component"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input readonly id="Component" name="Component" placeholder=<?php echo $translation["component"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["translation"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input readonly id="Translation" name="Translation" placeholder=<?php echo $translation["translation"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["project"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input readonly id="Project" name="Project" placeholder=<?php echo $translation["project"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["translator"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input readonly id="Translator" name="Translator" placeholder=<?php echo $translation["translator"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["previous_ref"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group">
													<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input readonly id="Previous reference" name="Previous reference" placeholder=<?php echo $translation["previous_ref"]?> class="form-control" value="" type="text">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["aec"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="form-inline">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
														<input readonly id="AEC" name="AEC" placeholder=<?php echo $translation["aec"]?> class="form-control" value="" type="text">
													</div>
													&nbsp;
													<div class="input-group">
														<b><?php echo $translation["up_to_date_aec"]?></b>
														&nbsp;
														<input type="checkbox" disabled="disabled" name="aec_different" id="aec_different">
													</div>
												</div>

											</div>
										</div>
									</fieldset>
								</div>
							</td>
							<td colspan="1">
								<div class="well form-horizontal">
									<fieldset>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["x_link"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input readonly id="x_link" name="x_link" placeholder=<?php echo $translation["network"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["ftp_link"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input readonly id="ftp_link" name="ftp_link" placeholder=<?php echo $translation["ftp_link"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["vbn"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input readonly id="VBN" name="VBN" placeholder=<?php echo $translation["vbn"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["blq"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input readonly id="BLQ" name="BLQ" placeholder=<?php echo $translation["blq"]?> class="form-control" value="" type="text"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $translation["commentaries"]?></label>
											<div class="col-md-8 inputGroupContainer">
												<div class="input-group" style="width:100%"><textarea readonly class="form-control z-depth-1" id="Commentaries" name="Commentaries" rows="3" ></textarea></div>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group" style="margin:0 auto">
												<div class="btn-group" role="group" aria-label="Basic example">
													<button type="button" id="leaveEdit" class="btn btn-info btn-fill" data-dismiss="modal" aria-label="Close"><?php echo $translation["leave"]?></button>
												</div>
											</div>
										</div>


									</fieldset>
								</div>
							</td>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>

	<?php 
}
?>

<!-- MODAL TO DELETE THE DOCUMENT -->
<div class="modal fade" id="deleteDoc" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalLabel">Important</h4>
			</div>
			<div class="modal-body">
				<p><?php echo $translation["sure_delete_doc"] ?> ?</p>
			</div>
			<div class="modal-footer">
				<form action="controleur.php">
					<input id="numberDeleteDoc" type="hidden" name="id_doc" value="" />
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $translation["close"]?></button>
					<button type="submit" name="action" value="deleteDoc" class="btn btn-danger"><?php echo $translation["delete"]?></button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- MODAL TO EDIT THE DOCUMENT -->
<div class="modal fade" id="changeDoc" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalLabel">Important</h4>
			</div>
			<div class="modal-body">
				<p><?php echo $translation["sure_edit_doc"] ?></p>
			</div>
			<div class="modal-footer">
				<form action="controleur.php">
					<input id="numberDeleteDoc" type="hidden" name="id_doc" value="" />
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $translation["close"]?></button>
					<button type="submit" name="action" value="changeDoc" class="btn btn-success"><?php echo $translation["edit"]?></button>
				</form>
			</div>
		</div>
	</div>
</div>



    <!-- Bootstrap core JavaScript
    	================================================== -->
    	<!-- Placed at the end of the document so the pages load faster -->

    	<script>
    		function editDocu() {
    			console.log(tabDocs);
    			var index=$("#tableResults tr").index(this);
    			$("#Key").val(tabDocs[index]["id_doc"]);
    			$("#initialLanguage").val(tabDocs[index]["initial_language"]);
    			$("#Version").val(tabDocs[index]["version"]);
    			$("#Reference").val(tabDocs[index]["reference"]);
    			$("#Object").val(tabDocs[index]["subject"]);
    			$("#Baseline").val(tabDocs[index]["GATC_baseline"]);
    			$("#Site").val(tabDocs[index]["site"]);
    			$("#PIC").val(tabDocs[index]["pic"]);
    			$("#Component").val(tabDocs[index]["component"]);
    			$("#Product").val(tabDocs[index]["product"]);
    			$("#Project").val(tabDocs[index]["project"]);
    			$("#Translation").val(tabDocs[index]["language"]);
    			$("#Translator").val(tabDocs[index]["translator"]);
    			if(tabDocs[index]["installation"]==1)
    				$("#Installation").attr('checked',true);
    			if(tabDocs[index]["maintenance"]==1)
    				$("#Maintenance").attr('checked',true);
    			$("#Commentaries").val(tabDocs[index]["remarks"]);
    			$("#Work_1").val(tabDocs[index]["working_field_1"]);
    			$("#Work_2").val(tabDocs[index]["working_field_2"]);
    			$("#Work_3").val(tabDocs[index]["working_field_3"]);
    			$("#Work_4").val(tabDocs[index]["working_field_4"]);
    			$("#numberDeleteDoc").val(tabDocs[index]["id_doc"]);
    			$("#displayStatus").val(tabDocs[index]["status"]);
    		}

    		$(document).ready( function() {

    			var autocompleteName = <?php echo $name; ?>;
    			var autopreviousDoc= <?php echo $previous_doc; ?>;
    			var autoversion= <?php echo $version; ?>;
    			var autopic= <?php echo $pic; ?>;
    			$( "#doc_number" ).autocomplete({ source: autocompleteName });
    			$( "#previous_ref" ).autocomplete({ source: autopreviousDoc });
    			$( "#version" ).autocomplete({ source: autoversion });
    			$( "#pic" ).autocomplete({ source: autopic });
    		});

    		jQuery.fn.multiselect = function() {
			$(this).each(function() {
			    var checkboxes = $(this).find("input:checkbox");
			    checkboxes.each(function() {
			        var checkbox = $(this);
			        // Highlight pre-selected checkboxes
			        if (checkbox.prop("checked"))
			            checkbox.parent().addClass("multiselect-on");

			        // Highlight checkboxes that the user selects
			        checkbox.click(function() {
			            if (checkbox.prop("checked"))
			                checkbox.parent().addClass("multiselect-on");
			            else
			                checkbox.parent().removeClass("multiselect-on");
			        });
			    });
			});
			};

    		//window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')
    	</script>



