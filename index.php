<?php

session_start();
define('DEBUG', false);
require('functions.php');

if(empty($_GET['key']) || htmlspecialchars($_GET['key']) != '3s2o5sALyNORreaZK4wozCfK3PhbYqAOPa3RYI5eNov0rv946r')
{
    //exit('It works!');
}

?>
<!DOCTYPE html>
<html lang="en">
    <!-- Do not forget to use spaces instead of tabs. -->
    <!-- W3C HTML validator: https://validator.w3.org/ -->
    <!-- No error found! -->
    <head>
        <meta charset="utf-8" />
        <meta name="robots" content="noindex,nofollow" />
        <meta name="author" content="Clement F." />
        <meta name="description" content="Personal and contact web page." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="design.min.css" type="text/css" />
        <link rel="stylesheet" href="my_hover.min.css" type="text/css" />
        <link rel="stylesheet" href="material-modal.min.css" type="text/css" />
        <link href="images/favicon.svg" type="image/svg+xml" rel="icon" />
        <script src="particles.js"></script>
        <script src="script.js?token=<?=createToken()?>" id="main"></script>
        <title>Clement F. - TechnOverflow</title>
    </head>
    <body>
        <div id="particles-js"></div>
        <section id="main-body">
            <h1 id="about">Clement F.</h1>
            <article>
                <h2>About Me</h2>
                <p class="justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel turpis leo. Integer lobortis hendrerit bibendum. Fusce leo nisi, cursus eget scelerisque at, gravida fermentum augue. Pellentesque nec odio est. Cras consequat quis lectus vitae bibendum. Quisque hendrerit lacus eu neque efficitur, ut gravida sapien iaculis. Ut eleifend leo non arcu malesuada facilisis.</p>
                <p class="justify">Donec consequat varius velit, non elementum ligula rhoncus ac. Duis sollicitudin dui quis ullamcorper porttitor. Aenean velit odio, commodo vel ante vitae, condimentum fermentum magna. Cras tincidunt, mi a feugiat commodo, lectus erat luctus turpis, quis scelerisque justo tellus a tortor. Nam dignissim eget nunc ut viverra. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In gravida semper nisl in elementum.</p>
            </article>
            <article>
                <h2>Contact Me</h2>
                <ul class="contact-list">
                    <li><span class="icoeml"></span> <?=contactLink('mailto:foo@bar.com', 'Contact me by email.', 'foo@bar.com')?></li>
                    <li><span class="icolnk"></span> <?=contactLink('https://www.linkedin.com/in/...', 'LinkedIn', '...')?></li>
                    <li><span class="icotwi"></span> <?=contactLink('https://twitter.com/...', 'Follow me on Twitter.', '@...')?></li>
                    <li><span class="ico5px"></span> <?=contactLink('https://500px.com/...', 'Visit my 500px gallery.', '500px.com/...')?></li>
                    <li><span class="icogit"></span> <?=contactLink('https://github.com/...', 'Visit my GitHub repository.', 'GitHub.com/...')?></li>
                    <li><span class="icokey"></span> <?=contactLink('https://keybase.io/...', 'My KeyBase.io', 'KeyBase.io/...')?></li>
                </ul>
                <p>If you want to, <a href="..." class="hvr-shutter-out-vertical" title="Click to download my PGP public key." target="_blank">download my PGP public key</a>, here you have the fingerprint:</p>
                <p class="center"><code id="fingerprint">...</code></p>
            </article>
            <noscript>
                <article>
                    <h2>Privacy Policy</h2>
                    <p class="justify">If you enable JavaScript, your IP address and the date time will be saved in a database I own. That is not the case since you disabled JS. My purpose is to know how many visitors are reading my web page day after day. In other words, the log is for statistics rather than tracking.</p>
                </article>
            </noscript>
        </section>
        <script type="text/javascript">
            document.write('<footer><p><a href="#" title="Show the privacy policy." onclick="materialAlert();return false;" class="hvr-shutter-out-vertical">Privacy Policy</a></p></footer>');
        </script>
        <div id="materialModal" onclick="closeMaterialAlert(event, false)" class="hide">
            <div id="materialModalCentered">
			<div id="materialModalCentered">
				<div id="materialModalContent" onclick="event.stopPropagation()">
					<h1>Privacy Policy</h1>
					<p id="materialModalText" class="justify">Your IP address and the date time are saved in a database I own. My purpose is to know how many visitors are reading my web page day after day. In other words, the log is for statistics rather than tracking. If you don't want your IP address to be remembered in the future, just disable JavaScript, you won't have any problem reading this page without JS.</p>
					<div id="materialModalButtons"><button id="materialModalButtonOK" class="materialModalButton hvr-box-shadow-outset" onclick="closeMaterialAlert(event, true)">OK</button></div>
				</div>
            </div>
        </div>
    </body>
</html>
