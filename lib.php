<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_vemser_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';

    $boostscss = $CFG->dirroot . '/theme/boost/scss/preset/default.scss';

    if (file_exists($boostscss)) {
        $scss .= file_get_contents($boostscss);
    }

    $customscss = $CFG->dirroot . '/theme/vemser/scss/custom.scss';

    if (file_exists($customscss)) {
        $scss .= "\n";
        $scss .= file_get_contents($customscss);
    }

    return $scss;
}

/**
 * SCSS injected before the main SCSS.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_vemser_get_pre_scss($theme) {
    return '';
}

function theme_vemser_pluginfile(
    $course,
    $cm,
    $context,
    $filearea,
    $args,
    $forcedownload,
    array $options = []
) {
    if ($context->contextlevel !== CONTEXT_SYSTEM) {
        send_file_not_found();
    }

    $allowedareas = [
        'logo',
        'slide1image',
    ];

    if (!in_array($filearea, $allowedareas, true)) {
        send_file_not_found();
    }

    $theme = theme_config::load('vemser');
    return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
}