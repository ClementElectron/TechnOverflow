<?php

define('DEBUG', false);
require('functions.php');

?>
<!DOCTYPE html>
<html lang="en">
    <!-- Do not forget to use spaces instead of tabs. -->
    <head>
        <meta charset="utf-8" />
        <meta name="robots" content="noindex,nofollow" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?=insertMin('design.css')?>" type="text/css" />
        <link rel="stylesheet" href="<?=insertMin('my_hover.css')?>" type="text/css" />
        <link rel="stylesheet" href="<?=insertMin('material-modal.css')?>" type="text/css" />
        <link href="images/favicon.svg" type="image/svg+xml" rel="icon" />
        <script src="<?=insertMin('script.js')?>?donottrack&amp;gohome" id="main"></script>
        <title>TechnOverflow</title>
    </head>
    <body>
        <section id="main-body">
            <h1>Error!</h1>
            <p class="center">Are you lost? <a href="index.php" class="hvr-shutter-out-vertical" title="Home Page">Go back to the home page</a> (redirecting in <span id="countdown-timer">5</span>s).</p>
        </section>
    </body>
</html>
