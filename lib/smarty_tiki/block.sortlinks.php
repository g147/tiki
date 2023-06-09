<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 *
 * -------------------------------------------------------------
 * File: block.sortlinks.php
 * Type: block
 * Name: sortlinks
 * Purpose: sort a list of options or links lines on the value of the line. Each line has the form <..>value</...>
 * inspiration : block repeat - Scott Matthewman <scott@matthewman.net>
 * -------------------------------------------------------------
 */
function smarty_block_sortlinks($params, $content, $smarty, &$repeat)
{
    if ($repeat || ! empty($content)) {
        $links = preg_split("/\n/", $content);
        $links2 = [];
        foreach ($links as $value) {
            preg_match('/.*(<[^>]*>)(.*)(<\/[^¨>]*>)/U', $value, $splitted);
//    $splitted=preg_split("/[<>]/",$value,-1,PREG_SPLIT_NO_EMPTY);
            if (isset($splitted[2])) {
                $splitted[2] = str_replace(["Î","É","È"], ['I','E','E'], $splitted[2]);
                $links2[$splitted[2]] = $value;
            }
        }

        if (isset($params['case']) && $params['case'] == false) {
            uksort($links2, 'strcasecmp');
        } else {
            ksort($links2);
        }
        foreach ($links2 as $value) {
            echo $value;
        }
    }
}
