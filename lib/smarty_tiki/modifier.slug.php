<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

/**
 * Smarty modifier plugin to convert a string suitable for a URL using the current SEFURL slug settings wiki_url_scheme
 *
 * - type:     modifier
 * - name:     slug
 * - purpose:  to return a usable SEFURL URL component string
 * - note:     also removes non-parse wiki tags generated by the list plugin
 *
 * Example: href="Page-Name-{$row.object_id}-{$row.title|slug}"
 *
 * @param string to be slugified
 * @param int  $length    defaults to 70
 * @param bool $mixedCase set true to preserve capitalisation
 * @param bool $breakWords set true to break words
 *
 * @return string
 *
 * @throws SmartyException
 */

function smarty_modifier_slug($string, $length = 70, $mixedCase = false, $breakWords = false)
{
    global $prefs;
    TikiLib::lib('smarty')->loadPlugin('smarty_modifier_nonp');

    if (! $breakWords) {
        $offset = strrpos($string, ' ', $length - strlen($string));
        if ($offset) {
            $length = $offset;
        }
    }
    $string = substr(smarty_modifier_nonp($string), 0, $length);
    if (! $mixedCase) {
        $string = mb_strtolower($string);
    }

    $asciiOnly = $prefs['url_only_ascii'] === 'y';

    /** @var \Tiki\Wiki\SlugManager $slugManager */
    $slugManager = TikiLib::lib('slugmanager');
    // when used as a modifier in a smarty template (e.g. {$row.title|slug})
    // we don't want the -2 at the end if a wiki page also exists, so disable the validator fn
    $slugManager->setValidationCallback(function () {
        return false;
    });
    $str = $slugManager->generate($prefs['wiki_url_scheme'], $string, $asciiOnly);

    if (! $asciiOnly) {
        $str = urlencode($str);
    }
    return $str;
}
