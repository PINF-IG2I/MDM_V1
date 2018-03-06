<?php
/**
* \file details.php
* \brief This page is displayed when a user wants to look into a document
* \author
* \version
*/

redirect("index.php?view=login&msg=".urlencode("You need to be logged in."));

include "/../translations/search_translations.php";



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
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="http://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/#">Link</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="http://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/#">Disabled</a>
          </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
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
          <label class="col-md-4 control-label">Key</label>
          <div class="col-md-8 inputGroupContainer">
           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="Key" name="Key" placeholder="Key" class="form-control" required="true" value="" type="text"></div>
         </div>
       </div>
       <div class="form-group">
        <label class="col-md-4 control-label">File</label>
        <div class="col-md-8 inputGroupContainer">
         <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="File" name="File" placeholder="File" class="form-control" required="true" value="" type="text"></div>
       </div>
     </div>
     <div class="form-group">
      <label class="col-md-4 control-label">Version</label>
      <div class="col-md-8 inputGroupContainer">
       <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="Version" name="Version" placeholder="Version" class="form-control" required="true" value="" type="text"></div>
     </div>
   </div>
   <div class="form-group">
    <label class="col-md-4 control-label">Baseline</label>
    <div class="col-md-8 inputGroupContainer">
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="city" name="Baseline" placeholder="Baseline" class="form-control" required="true" value="" type="text"></div>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 control-label">Object</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Object" name="Object" placeholder="Object" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Site</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="Site" name="Site" placeholder="Site" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">PIC</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="PIC" name="PIC" placeholder="PIC" class="form-control" required="true" value="" type="text">
  </div>
</div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Status</label>
  <div class="col-md-8 inputGroupContainer">
    <div class="input-group">
     <input type="text" class="form-control" aria-label="Text input with dropdown button">
     <div class="input-group-btn">
      <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Choose
      </button>
      <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="#">Inhibé</a>
        <a class="dropdown-item" href="#">Interne</a>
        <a class="dropdown-item" href="#">Externe</a>
      </div>
    </div>
  </div>
</div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Language</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Language" name="Language" placeholder="Language" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
</fieldset>
</form>
</td>
<td colspan="1">
 <form class="well form-horizontal">
  <fieldset>
   <div class="form-group" style="text-align:center">
    <label class="radio-inline"><input type="radio" name="optradio"><b>Installation</b></label>
    <label class="radio-inline"><input type="radio" name="optradio"><b>Maintenance</b></label>
  </div>
  <div class="form-group">
    <label class="col-md-4 control-label">Product</label>
    <div class="col-md-8 inputGroupContainer">
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="Product" name="Product" placeholder="Product" class="form-control" required="true" value="" type="text"></div>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 control-label">Component</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="Component" name="Component" placeholder="Component" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Translation</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="city" name="Translation" placeholder="Translation" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Project</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Project" name="Project" placeholder="Project" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Translator</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="Translator" name="Translator" placeholder="Translator" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Previous reference</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="Previous reference" name="Previous reference" placeholder="Previous reference" class="form-control" required="true" value="" type="text">
  </div>
</div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">AEC</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="AEC" name="AEC" placeholder="AEC" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Network</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Network" name="Network" placeholder="Network" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
</fieldset>
</form>
</td>
<td colspan="1">
 <form class="well form-horizontal">
  <fieldset>
   <div class="form-group">
    <label class="col-md-4 control-label">VBN</label>
    <div class="col-md-8 inputGroupContainer">
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="VBN" name="VBN" placeholder="VBN" class="form-control" required="true" value="" type="text"></div>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 control-label">BLQ</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="BLQ" name="BLQ" placeholder="BLQ" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group shadow-textarea">
  <label class="col-md-4 control-label">Commentaires</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><textarea class="form-control z-depth-1" rows="3"></textarea></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Work 1</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="Work 1" name="Work 1" placeholder="Work 1" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Work 2</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Work 2" name="Work 2" placeholder="Work 2" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Work 3</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="Work 3" name="Work 3" placeholder="Work 3" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Work 4</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="Work 4" name="Work 4" placeholder="Work 4" class="form-control" required="true" value="" type="text">
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