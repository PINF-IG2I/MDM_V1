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
if(secure("msg")){
  $msg=urldecode(secure("msg"));
  echo '<br><div class="alert alert-danger">
  <button type="button" aria-hidden="true" class="close">
  <i class="nc-icon nc-simple-remove"></i>
  </button>
  <span>
  <b> Warning - </b> '.$msg.'
  </span>
  </div>';
}
?>
<div class="page-header">
	<h1>Login</h1>
</div>

<p class="lead">

 <form role="form" action="controleur.php">
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username" value=""/>
  </div>
  <div class="form-group">
    <label for="pwd">Password</label>
    <input type="password" class="form-control" name="password" value=""/>
  </div>
  <button type="submit" name="action" value="Identification" class="btn btn-default">Enter</button>
</form>

</p>
