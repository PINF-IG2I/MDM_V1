<?php


/*
This file defines some functions to facilitate the production of complex formatting
It is used in conjuction with bootstrap style and it inserts bootstrap classes
*/

function mkHeadLink($label,$view,$currentView="",$class="")
{
	// make a link for the header by inserting the 'active' class if view = currentView

	// E.I: <?=mkHeadLink("Home","home",$view)
	// product <li class="active"><a href="index.php?view=home">Home</a></li> if $view= home

	if ($view == $currentView) 
		$class .= " active";
	return "<li class=\"$class\"> <a href=\"index.php?view=$view\">$label</a></li>";
}

?>
