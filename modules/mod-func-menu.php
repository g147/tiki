<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

/**
 * @return array
 */
function module_menu_info()
{
    return [
        'name' => tra('Menu'),
        'description' => tra('Displays a menu or a structure as a menu.'),
        'params' => [
            'id' => [
                'name' => tra('Menu'),
                'description' => tra('Identifier of a menu (from tiki-admin_menus.php)'),
                'filter' => 'int',
                'profile_reference' => 'menu',
            ],
            'structureId' => [
                'name' => tra('Structure'),
                'description' => tra('Identifier of a structure of wiki pages (name or number from tiki-admin_structures.php)'),
                'filter' => 'text',
                'profile_reference' => 'structure',
            ],
            'type' => [
                'name' => tra('Type'),
                'description' => tra('Direction for menu: horiz or vert (default vert)'),
                'filter' => 'text',
            ],
            // FIXME: There are 3 types of menus: Bootstrap, CSS or classic (JavaScript). There should be a single option to select between the 3, or 1 should be removed (CSS).
            'css' => [
                'name' => tra('CSS/Superfish'),
                'description' => tra('Use CSS Superfish menu (if bootstrap = n). y|n (default y)'),
                'filter' => 'alpha',
            ],
            'bootstrap' => [
                'name' => tra('Use Bootstrap menus'),
                'description' => tra('') . ' ( y / n )',
                'default' => 'y',
            ],
            'megamenu' => [
                'name' => tra('Use Smartmenu Megamenu'),
                'description' => tra('This is a Smartmenu that has a flattened structure of level 1 (Smartmenu preference must be turned on).') . ' ( y / n )',
                'default' => 'n',
            ],
            'megamenu_static' => [
                'name' => tra('Use Static Megamenu'),
                'description' => tra('This is a full-width navbar-nav Megamenu') . ' ( y / n )',
                'default' => 'y',
            ],
            // TODO - needs image url field
            // 'megamenu_images' => [
            //  'name' => tra('Use Megamenu Images'),
            //  'description' => tra('Adds an image to each Megamenu') . ' ( y / n )',
            //  'default' => 'n',
            // ],

            'navbar_toggle' => [
                'name' => tra('Show Navbar Toggle Button'),
                'description' => tra('Used in Bootstrap navbar menus when viewport is too narrow for menu items') . ' ( y / n )',
                'default' => 'y',
            ],
            'navbar_brand' => [
                'name' => tra('The URL of the navbar brand (logo)'),
                'description' => tra('Used in Bootstrap navbar menus, if there is a brand logo to be attached to the menu'),
                'default' => '',
            ],
            'navbar_class' => [
                'name' => tra('CSS class(es) for the menu nav element'),
                'description' => tra('Default specified is for Bootstrap menus. Replace "navbar-light bg-light" with "navbar-dark bg-dark" for a dark navbar. For a vertical Smartmenu, use "navbar navbar-expand-lg."'),
                'default' => 'navbar navbar-expand-lg navbar-light bg-light',
            ],
            'menu_id' => [
                'name' => tra('DOM #id'),
                'description' => tra('Id of the menu in the DOM'),
            ],
            'menu_class' => [
                'name' => tra('CSS class'),
                'description' => tra('Class of the menu container'),
                'filter' => 'text',
            ],
            'sectionLevel' => [
                'name' => tra('Limit low visibles levels'),
                'description' => tra('All the submenus beginning at this level will be displayed if the url matches one of the option of this level or above or below.'),
                'filter' => 'int',
            ],
            'toLevel' => [
                'name' => tra('Limit top visible levels'),
                'description' => tra('Do not display options higher than this level.'),
                'filter' => 'int',
            ],
            'link_on_section' => [
                'name' => tra('Link on Section'),
                'description' => tra('Create links on menu sections') . ' ' . tra('(y/n default y)'),
                'filter' => 'alpha',
            ],
            'translate' => [
                'name' => tra('Translate'),
                'description' => tra('Translate labels') . ' ' . tra('(y/n default y)'),
                'filter' => 'alpha',
            ],
            'menu_cookie' => [
                'name' => tra('Menu Cookie'),
                'description' => tra('Open the menu to show current option if possible') . ' ' . tra('(y/n default y)'),
                'filter' => 'alpha',
            ],
            'show_namespace' => [
                'name' => tra('Show Namespace'),
                'description' => tra('Show namespace prefix in page names') . ' ( y / n )', // Do not translate y/n
                'default' => 'y'
            ],
            'setSelected' => [
                'name' => tra('Set Selected'),
                'description' => tra('Process all menu items to show currently selected item and other dynamic states. Useful when disabled on very large menus where performance becomes an issue.') . ' ( y / n )',
                'default' => 'y'
            ],
        ]
    ];
}

/**
 * @param $mod_reference
 * @param $module_params
 */
function module_menu($mod_reference, $module_params)
{
    $smarty = TikiLib::lib('smarty');
    $smarty->assign('module_error', '');
    if (empty($module_params['id']) && empty($module_params['structureId'])) {
        $smarty->assign('module_error', tr('One of these parameters has to be set:') . ' ' . tr('Menu') . ', ' . tr('Structure') . '.');
    }
    if (! empty($module_params['structureId'])) {
        $structlib = TikiLib::lib('struct');

        if (empty($module_params['title'])) {
            $smarty->assign('tpl_module_title', $module_params['structureId']);
        }
    }
    $smarty->assign('module_type', ! empty($module_params['css']) && $module_params['css'] === 'y' ? 'cssmenu' : 'menu');
    $show_namespace = isset($module_params['show_namespace']) ? $module_params['show_namespace'] : 'y';
    $smarty->assign('show_namespace', $show_namespace);
}
