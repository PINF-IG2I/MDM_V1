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
		<input class="form-control mb-2 mr-sm-2 mb-sm-0 col-lg-5 col-lg-offset-5" type="text" placeholder="<?php echo $translation["user_name"]?>" />
		<button type="submit" class="btn btn-primary"><?php echo $translation["search"]?></button>
	</form><br/>
	<button data-toggle="modal" data-target="#createUser" type="button" class="btn btn-default" aria-label="Left Align"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
	<div id="tabUsers" >
		<center>
			<table style="user-select: none; -moz-user-select: none; -ms-user-select: none; -webkit-user-select: none;" class="table table-hover" id="usersResult">
				<tr style="cursor:not-allowed;">
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
					echo "<tr style='cursor: pointer;' onclick='editUser(this)' id='$tabUsers[id_user]' data-toggle='modal' data-target='#editUser'>";
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
	<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="modalLabelCreate">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalLabelCreate"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $translation["edit_user"] ?></h4>
				</div>
				<div class="modal-body">
					<form class="well form-horizontal" action="controleur.php" >
						<fieldset>
							<div class="form-group">
								<label for="number" class="col-md-4 control-label"><?php echo $translation["number"]?></label>
								<div class="col-xs-7 inputGroupContainer">
									<input readonly required id="number" name="number" class="form-control" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-md-4 control-label"><?php echo $translation["password"]?></label>
								<div class="col-xs-7 inputGroupContainer">
									<input id="password" name="password" class="form-control" type="password" />
								</div>
							</div>
							<div class="form-group">
								<label for="last_name" class="col-md-4 control-label"><?php echo $translation["last_name"]?></label>
								<div class="col-sm-7 inputGroupContainer">
									<input required id="last_name" name="last_name" class="form-control" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="first_name" class="col-md-4 control-label"><?php echo $translation["first_name"]?></label>
								<div class="col-sm-7 inputGroupContainer">
									<input required id="first_name" name="first_name" class="form-control" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="language" class="col-md-4 control-label"><?php echo $translation["language"]?></label>
								<div class="col-sm-7 inputGroupContainer">
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
								<div class="col-sm-7 inputGroupContainer">
									<select id="status" name="status" class="form-control">
										<option value="" disabled selected><?php echo $translation["status"]?></option>
										<option value="Internal"><?php echo $translation["internal"]?></option>
										<option value="External"><?php echo $translation["external"]?></option>
										<option value="Inhibated"><?php echo $translation["inhibited"]?></option>
										<option value="Manager"><?php echo $translation["manager"]?></option>
										<option value="Administrator"><?php echo $translation["administrator"]?></option>
									</select>
								</div>
							</div><br/>
							<center><button id="changeUser" type="submit" class="btn btn-success" name="action" value="editUser"><?php echo $translation["edit"]?></button>
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUser"><?php echo $translation["delete"]?></button></center>
							</form><br/>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END HIDDEN BOX TO EDIT USER -->

<!-- HIDDEN BOX TO CREATE USER -->
<div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="modalLabelCreate">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalLabelCreate"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $translation["create_user"] ?></h4>
			</div>
			<div class="modal-body">
				<form class="well form-horizontal" action="controleur.php" >
					<fieldset>
						<div class="form-group">
							<label for="last_name" class="col-md-4 control-label"><?php echo $translation["last_name"]?></label>
							<div class="col-sm-7 inputGroupContainer">
								<input required id="last_name" name="last_name" class="form-control" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label for="first_name" class="col-md-4 control-label"><?php echo $translation["first_name"]?></label>
							<div class="col-sm-7 inputGroupContainer">
								<input required id="first_name" name="first_name" class="form-control" type="text" />
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-md-4 control-label"><?php echo $translation["password"]?></label>
							<div class="col-xs-7 inputGroupContainer">
								<input required id="password" name="password" class="form-control" type="password" />
							</div>
						</div>
						<div class="form-group">
							<label for="language" class="col-md-4 control-label"><?php echo $translation["language"]?></label>
							<div class="col-sm-7 inputGroupContainer">
								<select required id="language" name="language" class="form-control">
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
							<div class="col-sm-7 inputGroupContainer">
								<select required id="status" name="status" class="form-control">
									<option value="" disabled selected><?php echo $translation["status"]?></option>
									<option value="Internal"><?php echo $translation["internal"]?></option>
									<option value="External"><?php echo $translation["external"]?></option>
									<option value="Inhibated"><?php echo $translation["inhibited"]?></option>
									<option value="Manager"><?php echo $translation["manager"]?></option>
									<option value="Administrator"><?php echo $translation["administrator"]?></option>
								</select>
							</div>
						</div><br/>
						<center><button id="createUser" type="submit" class="btn btn-success" name="action" value="createUser"><?php echo $translation["create_user"]?></button></center>
					</form><br/>
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
		</div>
	</div>
</div>
</div>
<!-- END HIDDEN BOX TO CREATE USER -->

<!-- HIDDEN DIALOG TO DELETE USER -->
<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalLabel">Important</h4>
			</div>
			<div class="modal-body">
				<p id="messageDelete"></p>
			</div>
			<div class="modal-footer">
				<form action="controleur.php">
					<input id="numberDeleteUser" type="hidden" name="number" value="" />
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $translation["close"]?></button>
					<button type="submit" name="action" value="deleteUser" class="btn btn-danger"><?php echo $translation["delete_user"]?></button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- END HIDDEN DIALOG TO DELETE USER -->

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
		//Display the block editUser
		function editUser(ref) {
			var tabUsers=<?php echo $userJSON; ?>;
			var index = $("tbody tr").index(ref) -1;
			console.log(index);
			$("#number").val(tabUsers[index]["id_user"]);
			$("#last_name").val(tabUsers[index]["last_name"]);
			$("#first_name").val(tabUsers[index]["first_name"]);
			$("#language").val(tabUsers[index]["language"]);
			$("#status").val(tabUsers[index]["status"]);
			$("#numberDeleteUser").val(tabUsers[index]["id_user"]);
			$("#messageDelete").html("<?php echo $translation["sure_delete_user"]?> <strong>"+tabUsers[index]['first_name']+" "+tabUsers[index]['last_name']+"</strong>?");
		}
		
	</script>