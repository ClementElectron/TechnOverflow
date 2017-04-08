<?php

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

/**
 * Check the HTTP header if the request comes from AJAX. Consider false positive.
 */
function isXMLHTTPRequest()
{
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']))
    {
        if(strtolower(htmlspecialchars($_SERVER['HTTP_X_REQUESTED_WITH'])) == 'xmlhttprequest')
        {
            return true;
        }
    }
    return false;
}

/**
 * Generate a new token. STP against CSRF attack.
 */
function createToken($length = 16)
{
    if(function_exists('random_bytes'))
    {
        $token = bin2hex(random_bytes($length));
    }
    else if(function_exists('openssl_random_pseudo_bytes'))
    {
        $token = bin2hex(openssl_random_pseudo_bytes($length));
    }
    else
    {
        $token = mt_rand(); // Not a CSPRNG but still okay for this kind of token.
    }
    
    return $_SESSION['token'] = $token;
}

/**
 * Compare the token from the user with the token from the session. Reset the token anyway.
 * @return True if positive match.
 */
function checkToken()
{
    $okay = !empty($_POST['token']) && htmlspecialchars($_POST['token']) == $_SESSION['token'];
    $_SESSION['token'] = NULL; // Use the token only one time, like a candom.
    return $okay;
}

/**
 * Add an entry to the log for a new visitor. Both the date and the IP address (end user or proxy) is saved.
 * @param sessionLifetime Seconds before the old user is considered new.
 * @return FALSE if something went wrong, TRUE otherwise.
 */
function savingNewVisitor($sessionLifetime)
{
    if(!empty($_SESSION['lastVisit']) && (intval($_SESSION['lastVisit']) + $sessionLifetime) < time()) // Refresh the old visitor.
    {
        session_unset();
    }

    if(empty($_SESSION['lastVisit'])) // User who have not visited this page for the last seconds.
    {
        if ($databaseFile = @fopen('z4w98xs9p57p915654h8e65l104c6t7.csv', 'a')) // Open (or create) the log if possible.
        {
            $newEntry = date('ymd').','.$_SERVER['REMOTE_ADDR']."\n"; // Format: yymmdd,IP\n
            $fwriteOk = @fwrite($databaseFile, $newEntry, strlen($newEntry));
            $fcloseOk = @fclose($databaseFile);
            $_SESSION['lastVisit'] = time();
            return $fcloseOk && $fwriteOk;
        }
        else
        {
            return false;
        }
    }
    
    return true;
}

/**
 * Convert all characters of @p str to the equivalent HTML code. Simple way to abfuscate text against basic spambots.
 * @param str String to encode.
 * @return Encoded string.
 */
function encodeToHtmlEntities($str)
{
    $str = mb_convert_encoding($str, 'UTF-32', 'UTF-8'); // Convert UTF-8 (variable-width) to UTF-32 (fixed-width).
    $arr = unpack('N*', $str); // Create an array with the characters (unsigned 32 bit) of the string.
    $arr = array_map(function($c) {return '&#'.$c.';';}, $arr);  // Concatenate to become HTML code.
    return implode('', $arr);
}

/**
 * Create a link with @p href and @p text obfuscated.
 * @param href Link.
 * @param title Tooltip description.
 * @param text Visible description.
 * @return HTML 'a' tag with class and a link opened in a new tab.
 */
function contactLink($href, $title, $text)
{
    return '<a href="'.encodeToHtmlEntities($href).'" class="hvr-shutter-out-vertical" target="_blank" title="'.$title.'">'.encodeToHtmlEntities($text).'</a>';
}

/**
 * Insert '.min' before the file extension if debug mode is disabled (DEBUG constant set to false).
 * Returns @p filename if the minified version does not exist or has been changed before the unminified version.
 * @param filename File name without '.min'.
 * @return File name with or without '.min'.
 */
function insertMin($filename)
{
    if(defined('DEBUG') && DEBUG == false)
    {
        $arr = explode('.', $filename);
        array_splice($arr, count($arr) -1, 0, array('min'));
        $filenameMin = implode('.', $arr);
        return ((file_exists($filenameMin) && (filemtime($filename) < filemtime($filenameMin))) ? $filenameMin : $filename);
    }
    else
    {
        return $filename;
    }
}

?>
