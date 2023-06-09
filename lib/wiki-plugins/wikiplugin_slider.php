<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

function wikiplugin_slider_info()
{
    return [
        'name' => tra('Slider'),
        'documentation' => 'PluginSlider',
        'description' => tra('Embed a mini-slideshow of content on a page'),
        'prefs' => [ 'wikiplugin_slider' ],
        'body' => tra('Content separated by "/////"'),
        'iconname' => 'tv',
        'introduced' => 8,
        'tags' => [ 'basic' ],
        'last_supported_version' => 'This preference (and all the related code) will be removed after Tiki21',
        'is_superceded_by' => 'Superceded by preference <a href=\'https://doc.tiki.org/PluginSwiper\'>wikiplugin_swiper</a>',
        'params' => [
            'titles' => [
                'required' => false,
                'name' => tra('Slider Titles'),
                'description' => tr('Pipe-separated list of slider titles. Example:')
                    . '<code>slider 1|slider 2|slider 3</code>',
                'since' => '8.0',
                'filter' => 'text',
                'separator' => '|',
                'default' => '',
            ],
            'width' => [
                'required' => false,
                'name' => tra('Width'),
                'description' => tr(
                    'Width in pixels or percentage. Default value is page width, for example, %0 or %1',
                    '<code>200px</code>',
                    '<code>100%</code>'
                ),
                'since' => '8.0',
                'filter' => 'text',
                'default' => 'Slider width',
            ],
            'height' => [
                'required' => false,
                'name' => tra('Height'),
                'description' => tr(
                    'Height in pixels or percentage. Default value is complete slider height.
                    If the %0 parameter set to Yes (%1), then don\'t use percent only use pixels.',
                    '<code>expand</code>',
                    '<code>y</code>'
                ),
                'since' => '8.0',
                'filter' => 'text',
                'default' => 'Slider height',
            ],
            'theme' => [
                'required' => false,
                'name' => tra('Theme'),
                'description' => tra('The theme to use in slider.'),
                'since' => '8.0',
                'filter' => 'text',
                'default' => 'default',
                'options' => [
                    ['text' => 'default', 'value' => ''],
                    ['text' => 'construction', 'value' => 'construction'],
                    ['text' => 'cs-portfolio', 'value' => 'cs-portfolio'],
                    ['text' => 'default1', 'value' => 'default1'],
                    ['text' => 'default2', 'value' => 'default2'],
                    ['text' => 'metallic', 'value' => 'metallic'],
                    ['text' => 'mini-dark', 'value' => 'mini-dark'],
                    ['text' => 'mini-light', 'value' => 'mini-light'],
                    ['text' => 'minimalist-round', 'value' => 'minimalist-round'],
                    ['text' => 'minimalist-square', 'value' => 'minimalist-square'],
                    ['text' => 'office', 'value' => 'office'],
                    ['text' => 'polished', 'value' => 'polished'],
                    ['text' => 'ribbon', 'value' => 'ribbon'],
                    ['text' => 'shiny', 'value' => 'shiny'],
                    ['text' => 'simple', 'value' => 'simple'],
                    ['text' => 'tabs-dark', 'value' => 'tabs-dark'],
                    ['text' => 'tabs-light', 'value' => 'tabs-light']
                ]
            ],
            'expand' => [
                'required' => false,
                'name' => tra('Expand'),
                'description' => tr('Set whether the entire slider expands to fit the parent element. The %0 parameter
                    needs to also be set', '<code>height</code>'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'n',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'resizecontents' => [
                'required' => false,
                'name' => tra('Resize'),
                'description' => tr('Set whether solitary images/objects in the panel will be expanded to fit the viewport'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'showmultiple' => [
                'required' => false,
                'name' => tra('Show Multiple'),
                'description' => tra('Set this value to a number and it will show that many slides at once'),
                'since' => '8.0',
                'filter' => 'digits',
                'default' => '1'
            ],
            'buildarrows' => [
                'required' => false,
                'name' => tra('Arrows'),
                'description' => tra('Set whether to show forward and backward buttons'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'buildnavigation' => [
                'required' => false,
                'name' => tra('Navigation'),
                'description' => tra('Set whether to show a list of anchor links to link to each panel'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'buildstartstop' => [
                'required' => false,
                'name' => tra('Start / Stop'),
                'description' => tra('Set whether to show a start/stop button and add slideshow functionality'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'togglearrows' => [
                'required' => false,
                'name' => tra('Toggle Arrows'),
                'description' => tra('Set whether side navigation arrows slide out on hovering and hide at other times'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'n',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'togglecontrols' => [
                'required' => false,
                'name' => tra('Toggle Controls'),
                'description' => tra('Set whether slide in controls (navigation + play/stop button) on hover and slide
                    change, hide at other times'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'n',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'enablearrows' => [
                'required' => false,
                'name' => tra('Enable Arrows'),
                'description' => tra('Set whether arrows are clickable'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'enablenavigation' => [
                'required' => false,
                'name' => tra('Enable Navigation'),
                'description' => tra('Set whether navigation links are clickable'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'enablestartstop' => [
                'required' => false,
                'name' => tra('Enable Start Stop'),
                'description' => tr(
                    'Set whether the play/stop button is clickable. Previously %0',
                    '<code>enablePlay</code>'
                ),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'enablekeyboard' => [
                'required' => false,
                'name' => tra('Enable Keyboard'),
                'description' => tra('Set whether keyboard arrow keys will work for this slider'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'autoplay' => [
                'required' => false,
                'name' => tra('Auto Play'),
                'description' => tr(
                    'Set whether the slideshow will start running automatically; replaces %0 option',
                    '<code>startStopped</code>'
                ),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'f',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'autoplaylocked' => [
                'required' => false,
                'name' => tra('Auto Play Locked'),
                'description' => tra('Keep playing the slideshow even if the user changes slides'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'n',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'autoplaydelayed' => [
                'required' => false,
                'name' => tra('Auto Play Delayed'),
                'description' => tra('Set whether there will be a delay in advancing slides'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'n',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'pauseonhover' => [
                'required' => false,
                'name' => tra('Pause On Hover'),
                'description' => tra('Set whether the slideshow will pause on hover while the slideshow is active'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'stopatend' => [
                'required' => false,
                'name' => tra('Stop At End'),
                'description' => tra('Set whether the slideshow stops on the last page'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'n',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'delay' => [
                'required' => false,
                'name' => tra('Delay between slides'),
                'description' => tra('Time in milliseconds between slideshow transitions (in AutoPlay mode).'),
                'since' => '10.0',
                'filter' => 'digits',
                'default' => '3000',
            ],
            'playrtl' => [
                'required' => false,
                'name' => tra('Right To Left'),
                'description' => tra('Set whether the slideshow moves right-to-left'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'n',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'resumeonvideoend' => [
                'required' => false,
                'name' => tra('Resume On Video End'),
                'description' => tra('Set whether auto play stops until the video is complete (for supported video types)'),
                'since' => '8.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],
            'animationtime' => [
                'required' => false,
                'name' => tra('Animation Time'),
                'description' => tra('Milliseconds between slides'),
                'since' => '10.0',
                'filter' => 'digits',
                'default' => '600',
            ],
            'hashtags' => [
                'required' => false,
                'name' => tra('Panel Hashtags'),
                'description' => tra('Set whether to include a hashtag in the page URL, allowing links to specific panels'),
                'since' => '13.0',
                'filter' => 'alpha',
                'default' => 'y',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('Yes'), 'value' => 'y'],
                    ['text' => tra('No'), 'value' => 'n']
                ]
            ],

        ],
    ];
}

function wikiplugin_slider($data, $params)
{
    $headerlib = TikiLib::lib('header');

    // set default params
    $plugininfo = wikiplugin_slider_info();
    $default = [];
    foreach ($plugininfo['params'] as $key => $param) {
        $default["$key"] = $param['default'];
    }
    $params = array_merge($default, $params);
    extract($params, EXTR_SKIP);

    $headerlib->add_jsfile('vendor_bundled/vendor/jquery-plugins/anythingslider/js/swfobject.js', true);
    $headerlib->add_jsfile('vendor_bundled/vendor/jquery-plugins/anythingslider/js/jquery.anythingslider.js');
    $headerlib->add_jsfile('vendor_bundled/vendor/jquery-plugins/anythingslider/js/jquery.anythingslider.fx.js');
    $headerlib->add_jsfile('vendor_bundled/vendor/jquery-plugins/anythingslider/js/jquery.anythingslider.video.js');
    $headerlib->add_cssfile('vendor_bundled/vendor/jquery-plugins/anythingslider/css/anythingslider.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/jquery-plugins/anythingslider/css/theme-construction.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/jquery-plugins/anythingslider/css/theme-cs-portfolio.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/jquery-plugins/anythingslider/css/theme-metallic.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/jquery-plugins/anythingslider/css/theme-minimalist-round.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/jquery-plugins/anythingslider/css/theme-minimalist-square.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-default1.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-default2.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-mini-dark.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-mini-light.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-office.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-polished.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-ribbon.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-shiny.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-simple.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-tabs-dark.css');
    $headerlib->add_cssfile('vendor_bundled/vendor/css-tricks/anythingslider-themes/css/theme-tabs-light.css');

    if (isset($theme) && ! empty($theme)) {
        switch (strtolower($theme)) {
            case 'construction':
            case 'cs-portfolio':
            case 'default1':
            case 'default2':
            case 'metallic':
            case 'mini-dark':
            case 'mini-light':
            case 'minimalist-round':
            case 'minimalist-square':
            case 'office':
            case 'polished':
            case 'ribbon':
            case 'shiny':
            case 'simple':
            case 'tabs-dark':
            case 'tabs-light':
                $theme = $theme;
                break;
            default:
                $theme = 'default';
        }
    } else {
        $theme = 'default';
    }

    $animationtime = (int) $animationtime;
    $animationtime = (empty($animationtime) === false ? $animationtime : 600);
    $delay = (int) $delay;
    $delay = (empty($delay) === false ? $delay : 3000);
    $showmultiple = (int) $showmultiple;
    $showmultiple = (empty($showmultiple) === false ? $showmultiple : 1);

    $headerlib->add_jq_onready(
        "function formatText(i, p) {
            var possibleText = $('.tiki-slider-title').eq(i - 1).text();
            return (possibleText ? possibleText : 'slide_' + i);
        }

        $('.tiki-slider').anythingSlider({
            theme               : '$theme',
            expand              : " . makeBool($expand, false) . ",
            resizeContents      : " . makeBool($resizecontents, true) . ",
            showMultiple        : $showmultiple,
            easing              : 'swing',

            buildArrows         : " . makeBool($buildarrows, true) . ",
            buildNavigation     : " . makeBool($buildnavigation, true) . ",
            buildStartStop      : " . makeBool($buildstartstop, true) . ",

            toggleArrows        : " . makeBool($togglearrows, false) . ",
            toggleControls      : " . makeBool($togglecontrols, false) . ",

            startText           : 'Start',
            stopText            : 'Stop',
            forwardText         : '»',
            backText            : '«',
            tooltipClass        : 'tooltip',

            // Function
            enableArrows        : " . makeBool($enablearrows, true) . ",
            enableNavigation    : " . makeBool($enablenavigation, true) . ",
            enableStartStop     : " . makeBool($enablestartstop, true) . ",
            enableKeyboard      : " . makeBool($enablekeyboard, true) . ",

            // Navigation
            startPanel          : 1,
            changeBy            : 1,
            hashTags            : " . makeBool($hashtags, true) . ",

            // Slideshow options
            autoPlay            : " . makeBool($autoplay, false) . ",
            autoPlayLocked      : " . makeBool($autoplaylocked, false) . ",
            autoPlayDelayed     : " . makeBool($autoplaydelayed, false) . ",
            pauseOnHover        : " . makeBool($pauseonhover, true) . ",
            stopAtEnd           : " . makeBool($stopatend, false) . ",
            playRtl             : " . makeBool($playrtl, false) . ",

            // Times
            delay               : $delay,
            resumeDelay         : 15000,
            animationTime       : $animationtime,

            // Video
            resumeOnVideoEnd    : " . makeBool($resumeonvideoend, true) . ",
            addWmodeToObject    : 'opaque',

            navigationFormatter: formatText
        });"
    );

    if (! empty($titles)) {
        $titles = TikiLib::lib('parser')->parse_data($titles, ['suppress_icons' => true]);
        $titles = explode('|', $titles);
    }

    $sliderData = [];
    if (! empty($data)) {
        $data = TikiLib::lib('parser')->parse_data($data, ['suppress_icons' => true]);
        $data = preg_replace('/<p>\/\/\/\/\/\s*<\/p>/', '/////', $data);    // remove surrounding <p> tags on slide boundaries
        $sliderData = explode('/////', $data);
    }

    $ret = '';
    foreach ($sliderData as $i => $slide) {
        $ret .= "<div>
            " . (isset($titles[$i]) ? "<span class='tiki-slider-title' style='display: none;'>" . $titles[$i] . "</span>" : "") . "
            $slide
        </div>";
    }

    if ($expand == 'y') {
        /** if expand eq 'y', "100%" height not working **/
        /** Temp fix: if $height is empty**/
        $height = (empty($height) === false ? $height : '300px');
        $result = "<div style='width: $width; height: $height;'><div class='tiki-slider'>$ret</div></div>";
    } else {
        $result = "<div class='tiki-slider' style='width: $width; height: $height;'>$ret</div>";
    }

    return <<<EOF
    ~np~$result~/np~
EOF;
}
