<?php

defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes([
    'class' => 'vemser-frontpage'
]);

// ==========================================================
// LOGO
// ==========================================================

$logo = $OUTPUT->image_url(
    'logo-vemser',
    'theme_vemser'
)->out(false);

if (!empty($PAGE->theme->settings->logo)) {
    $adminlogo = $PAGE->theme->setting_file_url(
        'logo',
        'logo'
    );

    if (!empty($adminlogo)) {
        $logo = $adminlogo;
    }
}


// ==========================================================
// HERO - SLIDE 1
// ==========================================================

$slide1image = $OUTPUT->image_url(
    'login-background',
    'theme_vemser'
)->out(false);

if (!empty($PAGE->theme->settings->slide1image)) {
    $adminslideimage = $PAGE->theme->setting_file_url(
        'slide1image',
        'slide1image'
    );

    if (!empty($adminslideimage)) {
        $slide1image = $adminslideimage;
    }
}


// Texto superior.
$slide1eyebrow = !empty($PAGE->theme->settings->slide1eyebrow)
    ? $PAGE->theme->settings->slide1eyebrow
    : 'PESSOAS QUE CONSTROEM O AMANHÃ';


// Título.
$slide1title = !empty($PAGE->theme->settings->slide1title)
    ? $PAGE->theme->settings->slide1title
    : 'Desenvolvimento que transforma realidades.';


// Descrição.
$slide1description = !empty($PAGE->theme->settings->slide1description)
    ? $PAGE->theme->settings->slide1description
    : 'Conhecimento, oportunidades e pessoas para construirmos, juntos, grandes conquistas.';


// Botão.
$slide1button = !empty($PAGE->theme->settings->slide1button)
    ? $PAGE->theme->settings->slide1button
    : 'Explorar cursos';


// URL.
$slide1url = !empty($PAGE->theme->settings->slide1url)
    ? $PAGE->theme->settings->slide1url
    : $CFG->wwwroot . '/course/';


// ==========================================================
// TEMPLATE
// ==========================================================

$templatecontext = [
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,

    'logo' => $logo,

    'slide1image' => $slide1image,
    'slide1eyebrow' => $slide1eyebrow,
    'slide1title' => $slide1title,
    'slide1description' => $slide1description,
    'slide1button' => $slide1button,
    'slide1url' => $slide1url,

    'isloggedin' => isloggedin() && !isguestuser(),
];

echo $OUTPUT->render_from_template(
    'theme_vemser/frontpage',
    $templatecontext
);