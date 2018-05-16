<?php


/*
This file defines some functions to facilitate the production of complex formatting:
tables, forms, ...
*/
// Example :  mkLigneEntete($data,array('pseudo', 'color', 'connected'));
function mkLigneEntete($tabAsso,$listeChamps=false)
{
	// Function called in mkTable, make a header line
	// containing field values to show in mkTable
	// Fields to show are defined from the list 'listeChamps'
	// if not false or the tabAsso array

	if (!$listeChamps)	// listeChamps is false
	{
		// tabAsso est un tableau associatif dont on affiche TOUTES LES CLES
		echo "\t<tr>\n";
		foreach ($tabAsso as $cle => $val)	
		{
			echo "\t\t<th>$cle</th>\n";
		}
		echo "\t</tr>\n";
	}
	else		// Field names are in $listeChamps 	
	{
		echo "\t<tr>\n";
		foreach ($listeChamps as $nomChamp)	
		{
			echo "\t\t<th>$nomChamp</th>\n";
		}
		echo "\t</tr>\n";
	}
}

function mkLigne($tabAsso,$listeChamps=false)
{
	// Function called in mkTable, make a line
	// containing field values to show in mkTable
	// Fields to show are defined from the list 'listeChamps'
	// if not false or the tabAsso array

	if (!$listeChamps)	// listeChamps is false
	{
		// tabAsso is an associative array
		echo "\t<tr>\n";
		foreach ($tabAsso as $cle => $val)	
		{
			echo "\t\t<td>$val</td>\n";
		}
		echo "\t</tr>\n";
	}
	else	// Field names are in $listeChamps 	
	{
		echo "\t<tr>\n";
		foreach ($listeChamps as $nomChamp)	
		{
			echo "\t\t<td>$tabAsso[$nomChamp]</td>\n";
		}
		echo "\t</tr>\n";
	}
}

// Example :  mkTable($users,array('pseudo', 'color', 'connected'));	
function mkTable($tabData,$listeChamps=false)
{

	// Warning : the array might be empty
	if (count($tabData) == 0) return;

	echo "<table border=\"1\">\n";
	// show a header line with field names
	mkLigneEntete($tabData[0],$listeChamps);

	//tabData is an array indexed with integers
	foreach ($tabData as $data)	
	{
		// show a data line with the values
		mkLigne($data,$listeChamps);
	}
	echo "</table>\n";

	// Make a table showing the data passed in parameters
	// If listeChamps is empty, we show all the data of $tabData
	// Else, we only show the fields listed in the array, 
	// in the order of the array
	
}

// Make a select with name = $nomChampSelect

// Make the options of a select from the data passed in first parameters
// $champValue is the value of the options to send to the server
// $champLabel is the name of the labels to show in the option
// $selected contains the id of the selected option by default
// if $champLabel2 is defines, it indicates the name of another field of the array 
// used to make the labels of the options

// Example: 
// $users = listUsers("both");
// mkSelect("idUser",$users,"id","pseudo");
// TESTER AVEC mkSelect("idUser",$users,"id","pseudo",2,"color");

function mkSelect($nomChampSelect, $tabData,$champValue, $champLabel,$selected=false,$champLabel2=false)
{

	$multiple=""; 
	if (preg_match('/.*\[\]$/',$nomChampSelect)) $multiple =" multiple =\"multiple\" ";

	echo "<select $multiple name=\"$nomChampSelect\">\n";
	foreach ($tabData as $data)
	{
		$sel = "";	// by default, no option is selected 
		if ( ($selected) && ($selected == $data[$champValue]) )
			$sel = "selected=\"selected\"";

		echo "<option $sel value=\"$data[$champValue]\">\n";
		echo  $data[$champLabel] . "\n";
		if ($champLabel2) 	// SI on demande d'afficher un second label
			echo  " ($data[$champLabel2])\n";
		echo "</option>\n";
	}
	echo "</select>\n";
}

function mkForm($action="",$method="get")
{
	// Make a form tag
	echo "<form action=\"$action\" method=\"$method\" >\n";
}
function endForm()
{
	// Make an end form tag
	echo "</form>\n";
}

function mkInput($type,$name,$value="",$attrs="")
{
	// Make a form field
	echo "<input $attrs type=\"$type\" name=\"$name\" value=\"$value\"/>\n";
}

function mkRadioCb($type,$name,$value,$checked=false)
{
	// Make a radio or checkbox form field
	// and select this element if the fourt argument is true
	$selectionne = "";	
	if ($checked) 
		$selectionne = "checked=\"checked\"";
	echo "<input type=\"$type\" name=\"$name\" value=\"$value\"  $selectionne />\n";
}

function mkLien($url,$label, $qs="",$attrs="")
{
	echo "<a $attrs href=\"$url?$qs\">$label</a>\n";
}

function mkLiens($tabData,$champLabel, $champCible, $urlBase=false, $nomCible="")
{
	// Make a link list
	// From the data of an associative array
	// Every link points to a url defined by the $champCible field
	
	// If urlBase is not false, we use $urlBase
	// (with its '?') and we add the $nomCible
	// in the request channel, associated to $nomCible, after '&' 

	// Examples: 
	// mkLiens($conversations,"id","theme");
	// will make <a href="1">Multimédia</a> ...

	// mkLiens($conversations,"theme","id","index.php?view=chat","idConv");
	// will make <a href="index.php?view=chat&idConv=1">Multimédia</a> ...

	// parcourir les données de tabData 
	foreach($tabData as $data) {
		// on parcourt uniquement les valeurs
		// a chaque itération, les valeurs sont dans 
		// le tableau $data
		echo '<a href="';
		echo $urlBase . "&" . $nomCible . "=" ;
		echo $data[$champCible];
		echo '">';
		echo $data[$champLabel];
		echo "</a>\n<br />\n";
	}
}
?>

















