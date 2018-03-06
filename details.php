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

  <!-- Bootstrap core CSS -->
  <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="./bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="Status" name="Status" placeholder="Status" class="form-control" required="true" value="" type="text"></div>
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
    <label class="col-md-4 control-label">Version</label>
    <div class="col-md-8 inputGroupContainer">
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span><input id="Version" name="Version" placeholder="Version" class="form-control" required="true" value="" type="text"></div>
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
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="Status" name="Status" placeholder="Status" class="form-control" required="true" value="" type="text"></div>
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
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="Status" name="Status" placeholder="Status" class="form-control" required="true" value="" type="text"></div>
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
</tr>
</tbody>
</table>
</div>