<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

function smarty_function_trackeroutput($params, $smarty)
{
    $trklib = TikiLib::lib('trk');
    return $trklib->field_render_value($params);
}
