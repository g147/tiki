<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

/**
 * @return array
 */
function module_svnup_info()
{
    return [
        'name' => tra('SVN Up Info'),
        'description' => tra('SVN Version and last update information.'),
        'params' => [],
    ];
}

/**
 * @param $mod_reference
 * @param $module_params
 */
function module_svnup($mod_reference, $module_params)
{
}
