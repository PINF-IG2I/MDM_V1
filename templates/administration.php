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

$users=listerUtilisateurs();

?>
<!DOCTYPE html>
<!-- saved from url=(0064)http://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/# -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>MDM - Alstom</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Bootstrap core CSS -->
  <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="./bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>




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


  <div class="container">
		<!-- USER MANAGEMENT -->
		<center><h3><?php echo $translation["user_management"]?></h3></center>
		<form class="form-inline">
			<input class="form-control mb-2 mr-sm-2 mb-sm-0 col-lg-4 col-lg-offset-4" type="text" placeholder="<?php echo $translation["user_name"]?>" />
			<button type="submit" class="btn btn-primary"><?php echo $translation["search"]?></button>
		</form>
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
						echo "<tr>";
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
		<!-- END USER MANAGEMENT -->
		
		<!-- DATABASE MANAGEMENT -->
		<center><h3><?php echo $translation["db_management"]?></h3></center>
		<div id="db_management" >
			<center>
			<form action="controleur.php" >
				<button class="btn btn-default" name="action" value="importDB" ><?php echo $translation["importDB"]?> <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></button>
				<button class="btn btn-default" name="action" value="saveDB" ><?php echo $translation["saveDB"]?> <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></button>
				<button class="btn btn-danger" name="action" value="resetDB" ><?php echo $translation["resetDB"]?> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			</form>
			</center>
		</div>
		<!-- END DATABASE MANAGEMENT -->
		
  </div>