<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     htmldecode
 * Purpose:  Convert all HTML entities to their applicable characters
 * -------------------------------------------------------------
 */
function smarty_modifier_htmldecode($s)
{
    return TikiLib::htmldecode($s);
}
