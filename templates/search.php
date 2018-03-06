<?php
/**
* \file search.php
* \brief This page is the main page of the website. It's the one that permits the users to search for documents.
* \author
* \version
*/

redirect("index.php?view=login&msg=".urlencode("You need to be logged in."));

include "/../translations/search_translations.php";



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

    <!-- Begin page content -->
    <main role="main" class="container">
      <h1 class="mt-5">Sticky footer with fixed navbar</h1>
      <p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS. A fixed navbar has been added with <code>padding-top: 60px;</code> on the <code>body &gt; .container</code>.</p>
      <p>Back to <a href="http://getbootstrap.com/docs/4.0/examples/sticky-footer">the default sticky footer</a> minus the navbar.</p>
    </main>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./bootstrap/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="./bootstrap/js/popper.min.js."></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
  

