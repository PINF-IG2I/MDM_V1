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
       <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span><input id="Version" name="Version" placeholder="Version" class="form-control" required="true" value="" type="text"></div>
     </div>
   </div>
   <div class="form-group">
    <label class="col-md-4 control-label">Baseline</label>
    <div class="col-md-8 inputGroupContainer">
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span><input id="city" name="Baseline" placeholder="Baseline" class="form-control" required="true" value="" type="text"></div>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 control-label">Object</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span><input id="Object" name="Object" placeholder="Object" class="form-control" required="true" value="" type="text"></div>
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
    <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign"></i></span><input id="PIC" name="PIC" placeholder="PIC" class="form-control" required="true" value="" type="text">
  </div>
</div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Status</label>
  <div class="col-md-8 inputGroupContainer">
    <div class="input-group">
     <input type="text" class="form-control" aria-label="Text input with dropdown button">
     <div class="input-group-btn">
      <button type="submit" class="btn btn-info btn-fill dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Choose
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
  <label class="col-md-4 control-label">Language</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span><input id="Language" name="Language" placeholder="Language" class="form-control" required="true" value="" type="text"></div>
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
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input id="Product" name="Product" placeholder="Product" class="form-control" required="true" value="" type="text"></div>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 control-label">Component</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input id="Component" name="Component" placeholder="Component" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Translation</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="city" name="Translation" placeholder="Translation" class="form-control" required="true" value="" type="text"></div>
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
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span><input id="Translator" name="Translator" placeholder="Translator" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Previous reference</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input id="Previous reference" name="Previous reference" placeholder="Previous reference" class="form-control" required="true" value="" type="text">
  </div>
</div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">AEC</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="AEC" name="AEC" placeholder="AEC" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Network</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="Network" name="Network" placeholder="Network" class="form-control" required="true" value="" type="text"></div>
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
     <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="VBN" name="VBN" placeholder="VBN" class="form-control" required="true" value="" type="text"></div>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-4 control-label">BLQ</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span><input id="BLQ" name="BLQ" placeholder="BLQ" class="form-control" required="true" value="" type="text"></div>
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
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work 1" name="Work 1" placeholder="Work 1" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Work 2</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work 2" name="Work 2" placeholder="Work 2" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Work 3</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work 3" name="Work 3" placeholder="Work 3" class="form-control" required="true" value="" type="text"></div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Work 4</label>
  <div class="col-md-8 inputGroupContainer">
   <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span><input id="Work 4" name="Work 4" placeholder="Work 4" class="form-control" required="true" value="" type="text">
  </div>
</div>
</div>
<div class="form-group">
 <div class="input-group text-center">
  <div class="btn-group" role="group" aria-label="Basic example">
    <button type="submit" class="btn btn-info btn-fill">Save</button>
    <button type="submit" class="btn btn-info btn-fill">Delete</button>
    <button type="submit" class="btn btn-info btn-fill">Leave</button>
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



