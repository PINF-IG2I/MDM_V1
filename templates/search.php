<?php
redirect("index.php?view=login&msg=".urlencode("You need to be logged in."));

include "/../translations/search_translations.php";
$languageList=getLanguages();
?>

<!-- <div class="lead">
	<form role="form" action="controleur.php">

		<input type="submit" class="btn btn-default" name="action" value="<?php echo $translation['search']?>"/>
	</form>
</div> -->
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
  <script src="./js/jquery.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#selectLanguage").change(function(){
        $.ajax({
         url : "controleur.php",
         data : {
          'action' : 'changeLanguage',
          'language' : $("#selectLanguage option:selected").val()
        },
        success : location.reload()
      });
    });

    });


  </script>
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

  <!-- Begin page content -->
  <main role="main" class="container">
    <div class="page-header">
      <h1><?php echo $translation["titlePage"]?></h1>
      <div id="headerSearch">
        <form action="controleur.php">
          <label for="doc_number"><input t
        </form>
      </div>
      <hr/> 
    </div>
    <p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS. A fixed navbar has been added with <code>padding-top: 60px;</code> on the <code>body &gt; .container</code>.</p>
    <p>Back to <a href="http://getbootstrap.com/docs/4.0/examples/sticky-footer">the default sticky footer</a> minus the navbar.</p>
  </main>


    <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->

      <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
      <script src="./bootstrap/js/popper.min.js."></script>
      <script src="./bootstrap/js/bootstrap.min.js"></script>
      <script src="./bootstrap/js/bootstrap-select.min.js"></script>
      <script src="./bootstrap/js/bootstrap.bundle.js"></script>

    </body>
    </html>


