<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}
?>


    <div class="page-header">
      <h1>Title</h1>
    </div>

    <p class="lead">Content </p>
