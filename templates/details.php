<?php
/**
* \file details.php
* \brief This page is displayed when a user wants to look into a document
* \author
* \version
*/

redirect("index.php?view=login&msg=".urlencode("You need to be logged in."));


$languageList=getLanguages();


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
   <table class="table table-striped">
    <tbody>
     <tr>
      <td colspan="1">
       <form class="well form-horizontal">
        <fieldset>
         <div class="form-group">
          <label class="col-md-4 control-label"><?php echo $translation["key"]?></label>
          <div class="col-md-8 inputGroupContainer">
           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="Key" name="Key" placeholder=<?php echo $translation["key"]?> class="form-control" required="true" value="" type="text"></div>
         </div>
       </div>
       <div class="form-group">
        <label class="col-md-4 control-label"><?php echo $translation["file"]?></label>
        <div class="col-md-8 inputGroupContainer">
         <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="File" name="File" placeholder=<?php echo $translation["file"]?> class="form-control" required="true" value="" type="text"></div>
       </div>
     </div>
     <div class="form-group">
      <label class="col-md-4 control-label"><?php echo $translation["version"]?></label>
      <div class="col-md-8 inputGroupContainer">
       <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span><input id="Version" name="Version" placeholder=<?php echo $translation["version"]?> class="form-control" required="true" value="" type="text"></div>
     </div>
   </div>
   <div class="form-group">
    <label class="col-md-4 control-label"><?php echo $translation["baseline"]?></label>
    <div class="col-md-8 inputGroupContainer">
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span><input id="city" name="Baseline" placeholder=<?php echo $translation["baseline"]?> class="form-control" required="true" value="" type="text"></div>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["object"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span><input id="Object" name="Object" placeholder=<?php echo $translation["object"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["site"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="Site" name="Site" placeholder=<?php echo $translation["site"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["pic"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span><input id="PIC" name="PIC" placeholder=<?php echo $translation["pic"]?> class="form-control" required="true" value="" type="text">
  </div>
</div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["status"]?></label>
  <div class="col-md-8 inputGroupContainer">
    <div class="input-group">
     <input type="text" class="form-control" aria-label="Text input with dropdown button">
     <div class="input-group-btn">
      <button type="submit" class="btn btn-info btn-fill dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $translation["choose"]?>
      </button>
      <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="#">Inhibé</a>
        <a class="dropdown-item" href="#">Interne</a>
        <a class="dropdown-item" href="#">Externe</a>
        <a class="dropdown-item" href="#">Gestionnaire</a>
        <a class="dropdown-item" href="#">Administrateur</a>
      </div>
    </div>
  </div>
</div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["language"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span><input id="Language" name="Language" placeholder=<?php echo $translation["language"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
</fieldset>
</form>
</td>
<td colspan="1">
 <form class="well form-horizontal">
  <fieldset>
   <div class="form-group" style="text-align:center">
    <label class="radio-inline"><input type="radio" name="optradio"><b><?php echo $translation["installation"]?></b></label>
    <label class="radio-inline"><input type="radio" name="optradio"><b><?php echo $translation["maintenance"]?></b></label>
  </div>
  <div class="form-group">
    <label class="col-md-4 control-label"><?php echo $translation["product"]?></label>
    <div class="col-md-8 inputGroupContainer">
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input id="Product" name="Product" placeholder=<?php echo $translation["product"]?> class="form-control" required="true" value="" type="text"></div>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["component"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input id="Component" name="Component" placeholder=<?php echo $translation["component"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["translation"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="city" name="Translation" placeholder=<?php echo $translation["translation"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["project"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Project" name="Project" placeholder=<?php echo $translation["project"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["translator"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Translator" name="Translator" placeholder=<?php echo $translation["translator"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["previous_ref"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input id="Previous reference" name="Previous reference" placeholder=<?php echo $translation["previous_ref"]?> class="form-control" required="true" value="" type="text">
  </div>
</div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["aec"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="AEC" name="AEC" placeholder=<?php echo $translation["aec"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["network"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="Network" name="Network" placeholder=<?php echo $translation["network"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
</fieldset>
</form>
</td>
<td colspan="1">
 <form class="well form-horizontal">
  <fieldset>
   <div class="form-group">
    <label class="col-md-4 control-label"><?php echo $translation["vbn"]?></label>
    <div class="col-md-8 inputGroupContainer">
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="VBN" name="VBN" placeholder=<?php echo $translation["vbn"]?> class="form-control" required="true" value="" type="text"></div>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["blq"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="BLQ" name="BLQ" placeholder=<?php echo $translation["blq"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group shadow-textarea">
  <label class="col-md-4 control-label"><?php echo $translation["commentaries"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><textarea class="form-control z-depth-1" rows="3"></textarea></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["work1"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work 1" name="Work 1" placeholder=<?php echo $translation["work1"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["work2"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work 2" name="Work 2" placeholder=<?php echo $translation["work2"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["work3"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work 3" name="Work 3" placeholder=<?php echo $translation["work3"]?> class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><?php echo $translation["work4"]?></label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work 4" name="Work 4" placeholder=<?php echo $translation["work4"]?> class="form-control" required="true" value="" type="text">
  </div>
</div>
</div>
<div class="form-group">
 <div class="input-group text-center">
  <div class="btn-group" role="group" aria-label="Basic example">
    <button type="submit" class="btn btn-info btn-fill"><?php echo $translation["save"]?></button>
    <button type="submit" class="btn btn-info btn-fill"><?php echo $translation["delete"]?></button>
    <button type="submit" class="btn btn-info btn-fill"><?php echo $translation["leave"]?></button>
  </div>
</div>
</div>


</fieldset>
</form>
</td>
</tr>
</tbody>
</table>
</div>