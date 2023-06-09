<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

function wikiplugin_flash_info()
{
    return [
        'name' => tra('Flash Video'),
        'documentation' => 'PluginFlash',
        'description' => tra('Embed a video or audio file'),
        'prefs' => ['wikiplugin_flash'],
        'extraparams' => true,
        'tags' => [ 'basic' ],
        'iconname' => 'video',
        'format' => 'html',
        'introduced' => 1,
        'params' => [
            'type' => [
                'required' => true,
                'name' => tra('Flash Type'),
                'description' => tra('Whether you want to insert a Flash from a URL, a fileId from a podcast file
                    gallery or a link to a specific service like Youtube or Vimeo'),
                'since' => '6.1',
                'default' => '',
                'filter' => 'word',
                'options' => [
                    ['text' => tra('Select an option'), 'value' => ''],
                    ['text' => tra('Blip.tv'), 'value' => 'bliptv'],
                    ['text' => tra('File Gallery Podcast'), 'value' => 'fileId'],
                    ['text' => tra('Movie URL'), 'value' => 'url'],
                    ['text' => tra('Vimeo'), 'value' => 'vimeo'],
                    ['text' => tra('Youtube'), 'value' => 'youtube'],
                ],
            ],
            'movie' => [
                'required' => true,
                'name' => tra('Movie URL'),
                'description' => tr('URL to the movie to include, for example, %0', '<code>themes/mytheme/movie.swf</code>'),
                'since' => '1',
                'parentparam' => ['name' => 'type', 'value' => 'url'],
                'filter' => 'url',
                'default' => '',
            ],
            'fileId' => [
                'required' => true,
                'name' => tra('File Gallery Podcast ID'),
                'description' => tra('ID of a file from a podcast gallery - will work only with podcast gallery'),
                'since' => '5.0',
                'parentparam' => ['name' => 'type', 'value' => 'fileId'],
                'default' => '',
                'filter' => 'digits',
                'profile_reference' => 'file',
            ],
            'youtube' => [
                'required' => true,
                'name' => tra('YouTube URL'),
                'description' => tra('Complete URL to the YouTube video.') . ' ' . tra('Example:')
                    . ' <code>http://www.youtube.com/watch?v=1i2ZnU4iR24</code>',
                'since' => '6.1',
                'parentparam' => ['name' => 'type', 'value' => 'youtube'],
                'filter' => 'url',
                'default' => '',
            ],
            'vimeo' => [
                'required' => true,
                'name' => tra('Vimeo URL'),
                'description' => tra('Complete URL to the Vimeo video.') . ' ' . tra('Example:')
                    . ' <code>http://vimeo.com/3319966</code>',
                'since' => '6.1',
                'parentparam' => ['name' => 'type', 'value' => 'vimeo'],
                'filter' => 'url',
                'default' => '',
            ],
            'width' => [
                'required' => false,
                'name' => tra('Width'),
                'description' => tr('Width of movie in pixels (default is %0)', '<code>425</code>'),
                'since' => '1',
                'advanced' => true,
                'filter' => 'digits',
                'default' => 425,
            ],
            'height' => [
                'required' => false,
                'name' => tra('Height'),
                'description' => tr('Height of movie in pixels (default is %0)', '<code>350</code>'),
                'since' => '1',
                'advanced' => true,
                'filter' => 'digits',
                'default' => 350,
            ],
            'quality' => [
                'required' => false,
                'name' => tra('Quality'),
                'description' => tr('Flash video quality. Default value: %0', '<code>high</code>'),
                'since' => '1',
                'advanced' => true,
                'default' => 'high',
                'filter' => 'word',
                'options' => [
                    ['text' => '', 'value' => ''],
                    ['text' => tra('High'), 'value' => 'high'],
                    ['text' => tra('Medium'), 'value' => 'medium'],
                    ['text' => tra('Low'), 'value' => 'low'],
                ]
            ],
            'altimg' => [
                'required' => false,
                'name' => tra('Alternative image URL'),
                'description' => tra('Image to display if Flash is not available.'),
                'since' => '10.2',
                'advanced' => true,
                'filter' => 'url',
                'default' => '',
            ],
        ]
    ];
}

function wikiplugin_flash($data, $params)
{
    global $prefs, $user;
    $userlib = TikiLib::lib('user');
    $tikilib = TikiLib::lib('tiki');

    // Handle file from a podcast file gallery
    if (isset($params['fileId']) && ! isset($params['movie'])) {
        $filegallib = TikiLib::lib('filegal');
        $file_info = $filegallib->get_file_info($params['fileId']);
        if (! $userlib->user_has_perm_on_object($user, $file_info['fileId'], 'file', 'tiki_p_view_file_gallery')) {
            return tra('Permission denied');
        }
        $params['movie'] = $prefs['fgal_podcast_dir'] . $file_info['path'];
    }

    // Handle Youtube video
    if (isset($params['youtube']) && preg_match('|http(s)?://(\w+\.)?youtube\.com/watch\?v=([\w-]+)|', $params['youtube'], $matches)) {
        $params['movie'] = "//www.youtube.com/v/" . $matches[3];
    }

    // Handle Vimeo video
    if (isset($params['vimeo']) && preg_match('|http(s)?://(www\.)?vimeo\.com/(clip:)?(\d+)|', $params['vimeo'], $matches)) {
        $params['movie'] = '//vimeo.com/moogaloop.swf?clip_id=' . $matches[4];
    }

    if ((isset($params['youtube']) || isset($params['vimeo'])) && ! isset($params['movie'])) {
        return tra('Invalid URL');
    }

    unset($params['type']);

    $code = $tikilib->embed_flash($params);

    if ($code === false) {
        return tra('Missing parameter movie to the plugin flash');
    }
    return $code;
}
