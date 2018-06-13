<?php


redirect("./index.php?view=login&msg=".urlencode("You need to be logged in."));
?>

<!-- <div class="jumbotron" style="margin-top:-20px;padding-left:10%">
  <h1>Manuel d'utilisation</h1>      
  <p>En travaux.</p>
</div>

<div class="container">
  <p>Ceci est un guide destiné à l'utilisateur afin qu'il puisse savoir utiliser les différentes fonctionnalités que propose le site.</p>   
</div> -->
<div style="position: absolute;width: 100%;height: 100%; top:0px;left:0px;z-index: 100;">
<?php

	echo "<iframe src=\".\user_manual\user_manual_".$_SESSION["language"].".pdf\" width=\"100%\" style=\"height:100%\"></iframe>";

?>
</div>