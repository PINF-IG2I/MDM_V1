<?php
redirect("index.php?view=login&msg=".urlencode("You need to be logged in."));

include "/../translations/search_translations.php";



?>

<form role="form" action="controleur.php">

	<input type="submit" name="action" value="<?php echo $translation['search']?>">
</form>