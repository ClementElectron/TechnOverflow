/*
 *
 * Copyright (c) 2017, Clement F.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the names of its contributors may be used to endorse or promote
 *       products derived from this software without specific prior written
 *       permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */
 
/*
 * Minifier: https://javascript-minifier.com/
 */

/// Seconds before calling the PHP script.
var secondsBeforeAddingLogEntry = 5;

/// Server side script to add new visitors in the database.
var newVisitorServerScript = "new_visitor.php";

/// The home page file name.
var homePage = "index.php";

/// Identifier of this JavaScript file (id required in the HTML page).
var scriptId = "main";

/**
 * Get the right object to use AJAX.
 */
function getXMLHttp()
{
    XMLHttp = null;

    if(window.XMLHttpRequest)
    {
        try
        {
            XMLHttp = new XMLHttpRequest();
        }
        catch(e)
        {
        }
    }
    else if(window.ActiveXObject)
    {
        try
        {
            XMLHttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e)
        {
            try
            {
                XMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e)
            {
            }
        }
    }
}

/**
 * Add an entry (PHP function) to the log for a new visitor.
 */
function saveNewVisitor()
{
    getXMLHttp();
    XMLHttp.open("POST", newVisitorServerScript, true); // POST method with async request.
    XMLHttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    XMLHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XMLHttp.send("token=" + paramValue(scriptParams, "token"));
}

/**
 * Select the fingerprint and copy into the clipboard.
 */
function copyFingerprint()
{
    var fingerprint = document.getElementById("fingerprint");
    var selected = false;
    
    // Select the fingerprint.
    if(document.body.createTextRange) // IE.
    {
        var range = document.body.createTextRange();
        range.moveToElementText(fingerprint);
        range.select();
        selected = true;
    }
    else if(window.getSelection) // FF, Opera, Webkit.
    {
        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(fingerprint);
        selection.removeAllRanges();
        selection.addRange(range);
        selected = true;
    }
    
    // Copy the fingerprint into the clipboard.
    if(selected)
    {
        document.execCommand("copy");
    }
}

/**
 * Create the "Copy to clipboard" button and add it after the fingerprint.
 * In that way, no button will appear in the JS-disabled view.
 */
function createFingerprintCopyButton()
{
    var fingerprint = document.getElementById("fingerprint");
    
    if(!isSet(fingerprint))
    {
        return;
    }
    
    // Button properties.
    var copyButton = document.createElement("button");
    copyButton.appendChild(document.createTextNode("Copy"));
    copyButton.className += "hvr-box-shadow-outset";
    copyButton.onclick = copyFingerprint;
    copyButton.title = "Copy to clipboard.";
    
    // Add space between the fingerprint and the button (outside the selection).
    fingerprint.parentNode.appendChild(document.createTextNode(" "));
    
    // Add the button to the page.
    fingerprint.parentNode.appendChild(copyButton);
}

/**
 * Return script params in an array.
 * Exemple: [{"key":"foo","value":""},{"key":"bar","value":"blabla"}]] for "script.js?foo&bar=blabla".
 */
function getScriptParams()
{
    var scriptFilename = document.getElementById(scriptId).getAttribute("src");
    var params = scriptFilename.substring(scriptFilename.indexOf("?") + 1, scriptFilename.length).split("&");
    var paramsLength = params.length;
    var splittedParams = [];
    
    for(var i = 0; i < paramsLength; i++)
    {
        var tab = params[i].split("=");
        splittedParams[i] = {"key": tab[0], "value": tab[1]};
    }
    
    return splittedParams;
}

/**
 * Return false if the key @p param is not a part of @p params. Else return its value.
 * @see getScriptParams()
 */
function paramValue(params, param)
{
    for(var i = 0; i < params.length; i++)
    {
        if(params[i].key == param)
        {
            return params[i].value;
        }
    }
    
    return false;
}

/**
 * Wait a few seconds (set via the HTML) and redirect to index.php.
 * Must be called 1 second after the page is loaded (pseudo-recursive function).
 */
function waitAndGoHome()
{
    var countDownTimer = document.getElementById("countdown-timer");
    var remainingSeconds = parseInt(countDownTimer.innerHTML) -1;
    countDownTimer.innerHTML = remainingSeconds;
    
    if(remainingSeconds > 0)
    {
        window.setTimeout(waitAndGoHome, 1000);
    }
    else
    {
        window.location = homePage;
    }
}

/**
 * See material-modal.js v1.1
 */
function materialAlert(title, text, callback)
{
    var materialModal = document.getElementById("materialModal");
    updateTopPosition(materialModal);
    materialModal.className = "show";
}

/**
 * See material-modal.js v1.1
 */
function closeMaterialAlert(e, result)
{
    e.stopPropagation();
    document.getElementById("materialModal").className = "hide";
}

/**
 * Get the distance between the absolute and the relative position.
 */
function getPageOffset()
{
    if(typeof(window.pageYOffset) == "number")
    {
        // Netscape compliant.
        return window.pageYOffset;
    }
    else if(document.body && document.body.scrollTop)
    {
        // DOM compliant.
        return document.body.scrollTop;
    }
    else if(document.documentElement && document.documentElement.scrollTop)
    {
        // IE6 standards compliant mode.
        return document.documentElement.scrollTop;
    }
}

/**
 * Return true if @p el is defined and not null.
 */
function isSet(el)
{
    return typeof el !== "undefined" && el !== null;
}

/**
 * Update the top position of any block to the top of the page (even when the user scrolls).
 */
function updateTopPosition(el)
{
    if(isSet(el))
    {
        el.style.top = getPageOffset() + "px";
    }
}

/**
 * Get the window width and height.
 */
function getWindowSize()
{
    windowWidth = 1024;
    windowHeight = 768;
    
    // Internet Explorer (backward-compatibility mode).
    if(document.body && document.body.offsetWidth)
    {
        windowWidth = document.body.offsetWidth;
        windowHeight = document.body.offsetHeight;
    }

    // Internet Explorer (standards mode).
    if(document.compatMode == "CSS1Compat"
       && document.documentElement
       && document.documentElement.offsetWidth)
    {
        windowWidth = document.documentElement.offsetWidth;
        windowHeight = document.documentElement.offsetHeight;
    }

    // In most other browsers - as well as IE9 (standards mode).
    if(window.innerWidth && window.innerHeight)
    {
        windowWidth = window.innerWidth;
        windowHeight = window.innerHeight;
    }
}

/**
 * Get the height of a block.
 * @param el Element.
 * @return Height in pixels.
 */
function getHeight(el)
{
    var offset = 0;

    if(el.offsetHeight)
    {
        offset = el.offsetHeight;
    }
    else if(el.style.pixelHeight)
    {
        offset = el.style.pixelHeight;
    }

    return offset;
}

/**
 * Return true if the scroll bar exists, false otherwise.
 */
function hasVScroll()
{
    if(window.innerHeight)
    {
        return document.body.offsetHeight > window.innerHeight;
    }

    return document.documentElement.scrollHeight > document.documentElement.offsetHeight
           || document.body.scrollHeight > document.body.offsetHeight;
}

/**
 * Vertical align the main body to the page, or to the top if a scroll bar exists.
 */
function centerMainBodySmartly()
{
    var mainBody = document.getElementById("main-body");
    mainBody.style.marginTop = (hasVScroll() ? 30 : ((windowHeight - getHeight(mainBody)) / 2)) + "px";
}

/**
 * Load particles.js if required (id exists in HTML code).
 */
function loadParticles()
{
    if(isSet(document.getElementById("particles-js")))
    {
        particlesJS.load("particles-js", "particles.json", null);
    }
}

/**
 * Get the window size, move the background and wait a few seconds before saving the visit.
 */
window.onload = function()
{
    scriptParams = getScriptParams(); // Script parameters set as global.
    
    if(paramValue(scriptParams, "donottrack") === false)
    {
        window.setTimeout(saveNewVisitor, secondsBeforeAddingLogEntry * 1000);
    }
    
    if(paramValue(scriptParams, "gohome") !== false)
    {
        window.setTimeout(waitAndGoHome, 1000);
    }
    
    getWindowSize();
    createFingerprintCopyButton();
    var materialModal = document.getElementById("materialModal");
    materialModal.style.visibility = "visible";
    updateTopPosition(materialModal);
    loadParticles();
    centerMainBodySmartly();
}

/**
 * Refresh the window size.
 */
window.onresize = function()
{
    getWindowSize();
    centerMainBodySmartly();
    updateTopPosition(document.getElementById("materialModal"));
    updateTopPosition(document.getElementById("particles-js"));
}

/**
 * Move the background (parallax).
 */
window.onscroll = function()
{
    updateTopPosition(document.getElementById("materialModal"));
    updateTopPosition(document.getElementById("particles-js"));
}

/**
 * Override. Trick to refresh the page (i.e. prevent caching the page). So the script runs as expected.
 */
window.onunload = function()
{
}
