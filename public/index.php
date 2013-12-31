<?
require_once('settings.php');
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=pageTitle($templateName)?></title>
    <link rel="stylesheet" href="stylesheets/app.css" />
    <script src="bower_components/modernizr/modernizr.js"></script>
  </head>
  <body>
    <!-- Partial Credit header -->
    <header id="pc-header">
      <div class="row">
        <div class="large-6 medium-6 small-12 columns">
          <a href="#">
            <img src="images/logo.svg" onerror="this.src=images/logo.png"
            id="pc-logo" alt="Partial Credit A Cappella">
          </a>
          <ul class="header-links">
            <li><a href="#">News</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Photos</a></li>
            <li><a href="#">Auditions</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">YouTube</a></li>
          </ul>
        </div>
        <div class="small-6 show-for-medium-up columns">
          <div class="flex-video widescreen">
            <!-- TODO: make the video configurable -->
            <iframe width="640" height="360" src="//www.youtube-nocookie.com/embed/ZZ6ZuQtcHpE?rel=0" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </header>
    <!-- end Partial Credit header -->

<? templatePrint($templateName, 2); ?>

    <script src="bower_components/jquery/jquery.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
