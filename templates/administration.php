<?php
/**
* \file administration.php
* \brief This page manage the users and the database
* \author Julien Lammens
* \version 1.0
*/



if (secure("status","SESSION")!="Administrator")
{
	header("Location:index.php?view=search&message=".urlencode("You need to be Administrator."));
	die("");
}

include_once "libs/modele.php";

$users=listUsers();
$userJSON=json_encode($users);

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
					echo "<tr onclick='editUser(this)' id='$tabUsers[id_user]'>";
					echo "<td>$tabUsers[id_user]</td>";
					echo "<td>$tabUsers[last_name]</td>";
					echo "<td>$tabUsers[first_name]</td>";
					echo "<td>$tabUsers[status]</td>";
					echo "<td>$tabUsers[language]</td>";
					if ($tabUsers["isConnected"]==1)
						echo "<td>1 <a href='controleur.php?action=forceLogout&id=$tabUsers[id_user]' title='$translation[disconnect]' ><button type='button' class='btn-danger' id='disconnect'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button></a></td>";
					else 
						echo "<td>$tabUsers[isConnected]</td>";
					echo "</tr>";
				}
				?>
			</table>
		</center>
	</div>
	<!-- HIDDEN BOX TO EDIT USER -->
	<table id="editUser" class="table table-striped">
		<tbody>
			<tr>
				<div>
					<center><h3><strong><?php echo $translation["user"]?></strong></h3></center>
					<td colspan="1">
						<form class="well form-horizontal" action="controleur.php" >
							<fieldset>
								<div class="form-group">
									<label for="number" class="col-md-4 control-label"><?php echo $translation["number"]?></label>
									<div class="col-xs-4 inputGroupContainer">
										<input readonly required id="number" name="number" class="form-control" type="text" />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-md-4 control-label"><?php echo $translation["password"]?></label>
									<div class="col-xs-4 inputGroupContainer">
										<input id="password" name="password" class="form-control" type="password" />
									</div>
								</div>
								<div class="form-group">
									<label for="last_name" class="col-md-4 control-label"><?php echo $translation["last_name"]?></label>
									<div class="col-sm-4 inputGroupContainer">
										<input required id="last_name" name="last_name" class="form-control" type="text" />
									</div>
								</div>
								<div class="form-group">
									<label for="first_name" class="col-md-4 control-label"><?php echo $translation["first_name"]?></label>
									<div class="col-sm-4 inputGroupContainer">
										<input required id="first_name" name="first_name" class="form-control" type="text" />
									</div>
								</div>
								<div class="form-group">
									<label for="language" class="col-md-4 control-label"><?php echo $translation["language"]?></label>
									<div class="col-sm-4 inputGroupContainer">
										<select id="language" name="language" class="form-control">
											<option value="" disabled selected><?php echo $translation["language"]?></option>
											<?php 
											foreach ($languageList as $key => $value) {
												echo "<option value='".$value."'>".$value."</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="status" class="col-md-4 control-label"><?php echo $translation["status"]?></label>
									<div class="col-sm-4 inputGroupContainer">
										<select id="status" name="status" class="form-control">
											<option value="" disabled selected><?php echo $translation["status"]?></option>
											<option value="Interne"><?php echo $translation["internal"]?></option>
											<option value="Externe"><?php echo $translation["external"]?></option>
											<option value="Inhibé"><?php echo $translation["inhibited"]?></option>
											<option value="Gestionnaire"><?php echo $translation["manager"]?></option>
											<option value="Administrateur"><?php echo $translation["administrator"]?></option>
										</select>
									</div>
								</div><br/>
								<center><button id="changeUser" type="submit" class="btn btn-success" name="action" value="editUser"><?php echo $translation["edit"]?></button>
									<button id="deleteUser" type="submit" class="btn btn-danger" vname="action"><?php echo $translation["delete"]?></button></center>
								</form><br/>
							</fieldset>
						</form>
					</td>
				</div>
			</tr></tbody></table>
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

		$(document).ready(function() {
			$('#editUser').dialog({
				autoOpen: false,
				width:400,
				title:"<?php echo $translation["user"] ?>",
				modal:true
			});
			$('#editUser').dialog('close');
		});

		function editUser(ref) {
			var tabUsers=<?php echo $userJSON; ?>;
			console.log(tabUsers);
			$("#number").val(tabUsers[ref.id-1]["id_user"]);
			$("#last_name").val(tabUsers[ref.id-1]["last_name"]);
			$("#first_name").val(tabUsers[ref.id-1]["first_name"]);
			$("#language").val(tabUsers[ref.id-1]["language"]);
			$("#status").val(tabUsers[ref.id-1]["status"]);
			$('#editUser').dialog('open');
		}

	</script>