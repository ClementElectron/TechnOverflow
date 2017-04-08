TechnOverflow
=============

The goal of this project is to make a personal web page as simple as possible. I was inspired by [about.me](about.me) and [carrd.co](carrd.co). Unfortunately, about.me is too simple (cannot insert links in the text for example) and I do not agree to the carrd.co Terms of Use.

Specifications
--------------

* Lightweight single web page.
* Relatively secure.
* Privacy friendly.
* NoScript friendly.
* Do not need SQL.
* Easy to be hosted (PHP with *basic* functions).
* Under 3-Clause BSD licence.

Requirements
------------

* PHP
* Nothing else!

Notice
------

Remember to [minifie](http://refresh-sf.com/ "Minifier web based tool.") CSS and JS. 
Minified files must be more recent than the originals.

Create your *.htaccess* in order to:
* Redirect bad requests to error.php
* Forbid directory listing
* Force HTTPS instead of HTTP
* Change the noindex settings

Do not forget to change both the chmod and file name of the database file.
