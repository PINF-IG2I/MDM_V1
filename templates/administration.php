<?php
/**
* \file administration.php
* \brief This page manage the users and the database
* \author Julien Lammens
* \version 1.0
*/

if ($_SESSION["status"]!="Administrateur")
{
	header("Location:index.php?view=search&message=".urlencode("You need to be Administrator."));
	die("");
}

include_once "libs/modele.php";
$languageList=getLanguages();
$users=listerUtilisateurs();

?>

  <div class="container">
		<!-- USER MANAGEMENT -->
		<center><h3><?php echo $translation["user_management"]?></h3></center>
		<form class="form-inline">
			<input class="form-control mb-2 mr-sm-2 mb-sm-0 col-lg-4 col-lg-offset-4" type="text" placeholder="<?php echo $translation["user_name"]?>" />
			<button type="submit" class="btn btn-primary"><?php echo $translation["search"]?></button>
		</form><br/>
		<button type="button" class="btn btn-default" aria-label="Left Align"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
		<div id="tabUsers" >
			<center>
			<table class="table table-hover">
				<tr>
					<th><?php echo $translation["number"]?></th>
					<th><?php echo $translation["last_name"]?></th>
					<th><?php echo $translation["first_name"]?></th>
					<th><?php echo $translation["status"]?></th>
					<th><?php echo $translation["language"]?></th>
					<th><?php echo $translation["is_connected"]?></th>
				</tr>
				<?php
					foreach ($users as $tabUsers)
					{
						echo "<tr onclick='editUser()' id='$tabUsers[last_name]'>";
						echo "<td>$tabUsers[id_user]</td>";
						echo "<td>$tabUsers[last_name]</td>";
						echo "<td>$tabUsers[first_name]</td>";
						echo "<td>$tabUsers[status]</td>";
						echo "<td>$tabUsers[language]</td>";
						echo "<td>$tabUsers[isConnected]</td>";
						echo "</tr>";
					}
				?>
			</table>
			</center>
		</div>
			<!-- HIDDEN BOX TO EDIT USER -->
			<div id="editUser" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 25px; display:none; position:absolute; width: 45%; height: 60%; border: 1px solid black; top: 100px; background-color: lightgray; padding: 5px;" >
				<center><h3><strong><?php echo $translation["user"]?></strong></h3></center>
				<form class="form-horizontal" action="controleur.php">
					<div class="form-group">
						<label for="number" class="col-sm-3 control-label"><?php echo $translation["number"]?></label>
						<div class="col-xs-4">
							<input id="number" class="form-control" type="text" />
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-3 control-label"><?php echo $translation["password"]?></label>
						<div class="col-xs-4">
							<input id="password" class="form-control" type="password" />
						</div>
					</div>
					<div class="form-group">
						<label for="last_name" class="col-sm-3 control-label"><?php echo $translation["last_name"]?></label>
						<div class="col-sm-4">
							<input id="last_name" class="form-control" type="text" />
						</div>
					</div>
					<div class="form-group">
						<label for="first_name" class="col-sm-3 control-label"><?php echo $translation["first_name"]?></label>
						<div class="col-sm-4">
							<input id="first_name" class="form-control" type="text" />
						</div>
					</div>
					<div class="form-group">
						<label for="language" class="col-sm-3 control-label"><?php echo $translation["language"]?></label>
						<div class="col-sm-4">
							<select id="language" class="form-control">
								<option value="" disabled selected><?php echo $translation["language"]?></option>
								<?php 
									foreach ($languageList as $key => $value) {
									  echo "<option value='".$value["language"]."'>".$value["language"]."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="status" class="col-sm-3 control-label"><?php echo $translation["status"]?></label>
						<div class="col-sm-4">
							<select id="status" class="form-control">
								<option value="" disabled selected><?php echo $translation["status"]?></option>
								<option value="internal"><?php echo $translation["internal"]?></option>
								<option value="external"><?php echo $translation["external"]?></option>
								<option value="inhibited"><?php echo $translation["inhibited"]?></option>
								<option value="manager"><?php echo $translation["manager"]?></option>
								<option value="administrator"><?php echo $translation["administrator"]?></option>
							</select>
						</div>
					</div><br/>
					<center><button type="submit" class="btn btn-success" name="action"><?php echo $translation["edit"]?></button>
					<button type="submit" class="btn btn-danger" name="action"><?php echo $translation["delete"]?></button></center>
				</form><br/>
			</div>
			<!-- END HIDDEN BOX TO EDIT USER -->
			
		<!-- END USER MANAGEMENT -->
		
		<!-- DATABASE MANAGEMENT -->
		<center><h3><?php echo $translation["db_management"]?></h3></center>
		<div id="db_management" >
			<center>
			<form action="controleur.php" >
				<button class="btn btn-default" name="action" value="importDB" ><?php echo $translation["importDB"]?> <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></button>
				<button class="btn btn-success" name="action" value="saveDB" ><?php echo $translation["saveDB"]?> <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></button>
				<button class="btn btn-danger" name="action" value="resetDB" ><?php echo $translation["resetDB"]?> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			</form>
			</center>
		</div>
		<!-- END DATABASE MANAGEMENT -->
		
  </div>
  <script>
	function editUser()
	{
		document.getElementById("editUser").style.display="block";
	}
  </script>