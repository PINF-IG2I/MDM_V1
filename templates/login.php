<?php
/**
* \file login.php
* \brief This page is the first one that the user sees when he tries to use the application. This is where he can log in.
* \author
* \version
*/
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
  header("Location:../index.php?view=login");
  die("");
}

if(secure("isConnected","SESSION")){
  header("Location: index.php?view=search");
  die(""); 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Installation and Maintenance Document Manager"/>
  <meta name="author" content="TOPINF">

  <title>MDM - Alstom</title>

  <!-- Bootstrap core CSS -->
  <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Custom styles for this template -->
  <link href="./bootstrap/css/signin.css" rel="stylesheet"/>
</head> 
<body class="text-center">

  <form class="form-signin" action="controleur.php">
    <?php
  if(secure("msg")){//faut le bouger
    $msg=urldecode(secure("msg"));
    echo '<br><div class="alert alert-danger">
    <span>
    <b> Warning - </b> '.$msg.'
    </span>
    </div>';
  }
  ?>
  <img class="mb-4" src="./ressources/logotype_alstom.jpg" alt="" style="border:1px solid lightgrey" width="250" height="auto">
  <h1 class="h3 mb-3 font-weight-normal">Welcome</h1>
  <label for="inputEmail" class="sr-only">Username</label>
  <input type="text" class="form-control" placeholder="Username" required="" autofocus="" name="username">
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="" name="password">

  <button type="submit" class="btn btn-lg btn-primary btn-block" name="action" value="Identification">Log in</button>
  <br/><p class="mt-5 mb-3 text-muted">© TOPINF - IG2I - 
    <script>
      document.write(new Date().getFullYear())
    </script></p>
  </form>
