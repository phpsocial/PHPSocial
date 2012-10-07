<?php
/**
* Smarty plugin
* @package Smarty
* @subpackage plugins
*/


/**
* Smarty choptext modifier plugin
*
* Type: modifier<br>
* Name: choptext<br>
* Date: Nov 9, 2005
* Purpose: chop up a string of text
* Input: string to chop
* Example: {$var|choptext:32:" "}
* @author Monte Ohrt <monte at ohrt dot com>
* @version 1.0
* @param string
* @param string
* @return string
*/
function smarty_modifier_choptext($string, $length=32, $insert_char=' ')
{
return preg_replace("!(?:^|\s)([\w\!\?\.]{" . $length . ",})(?:\s|$)!e",'chunk_split("\\1",' . $length . ',"' . $insert_char. '")',$string);
}

/* vim: set expandtab: */

?>