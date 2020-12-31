<?php
/**
*
* @package Registration Check Extension
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'EMAIL_AVAILABLE' 		=> 'Email address is available and can be registered',
	'EMAIL_NOT_AVAILABLE'	=> '[%1$s] email address is already in use and cannot be registered',

	'NAME_AVAILABLE' 		=> 'Username is available and can be registered',
	'NAME_NOT_AVAILABLE'	=> '[%1$s] username is already in use and cannot be registered',

	'PASSWORDS_MATCH'		=> 'Passwords match',
	'PASSWORDS_NOT_MATCH'	=> 'Passwords do not match',
));
