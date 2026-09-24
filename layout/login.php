<?php

defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes([
    'class' => 'vemser-login-page'
]);

$templatecontext = [
    'sitename' => format_string(
        $SITE->shortname,
        true,
        [
            'context' => context_course::instance(SITEID),
            'escape' => false
        ]
    ),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,

    // Assets do tema VemSer.
    'loginbackground' => $OUTPUT->image_url('login-background', 'theme_vemser'),
    'vemserlogo' => $OUTPUT->image_url('logo-vemser', 'theme_vemser'),
];

echo $OUTPUT->render_from_template('theme_vemser/login', $templatecontext);