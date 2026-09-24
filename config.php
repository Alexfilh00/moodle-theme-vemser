<?php

defined('MOODLE_INTERNAL') || die();

$THEME->name = 'vemser';

$THEME->parents = ['boost'];

$THEME->sheets = [];

$THEME->editor_sheets = [];

$THEME->scss = function($theme) {
    return theme_vemser_get_main_scss_content($theme);
};

$THEME->layouts = [

    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'options' => [
            'langmenu' => true,
        ],
    ],

    'frontpage' => [
        'file' => 'frontpage.php',
        'regions' => [],
        'options' => [
            'nonavbar' => true,
        ],
    ],

];

$THEME->enable_dock = false;
$THEME->yuicssmodules = [];

$THEME->rendererfactory = 'theme_overridden_renderer_factory';

$THEME->prescsscallback = 'theme_vemser_get_pre_scss';