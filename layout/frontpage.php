<?php
defined('MOODLE_INTERNAL') || die();

$settings = $PAGE->theme->settings;
$context = [
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(['class' => 'vemser-frontpage']),
    'logo' => theme_vemser_home_image('logo') ?: $OUTPUT->image_url('logo-vemser', 'theme_vemser')->out(false),
    'isloggedin' => isloggedin() && !isguestuser(),
    'slides' => [],
];
$defaults = [
    'eyebrow' => 'PESSOAS QUE CONSTROEM O AMANHÃ',
    'title' => 'Desenvolvimento que transforma realidades.',
    'description' => 'Conhecimento, oportunidades e pessoas para construirmos, juntos, grandes conquistas.',
    'button' => 'Explorar cursos',
    'url' => '/course/',
];
for ($i = 1; $i <= 4; $i++) {
    if ($i > 1 && empty($settings->{'slide' . $i . 'title'})) {
        continue;
    }
    $slide = ['first' => $i === 1, 'number' => count($context['slides']) + 1];
    foreach ($defaults as $field => $default) {
        $value = $settings->{'slide' . $i . $field} ?? '';
        $slide[$field] = $i === 1 && trim($value) === '' ? $default : $value;
    }
    $slide['url'] = theme_vemser_home_url($slide['url']);
    if ($slide['url'] && trim($slide['button']) === '') {
        $slide['button'] = 'Saiba mais';
    }
    $slide['image'] = theme_vemser_home_image('slide' . $i . 'image');
    if ($i === 1 && !$slide['image']) {
        $slide['image'] = $OUTPUT->image_url('login-background', 'theme_vemser')->out(false);
    }
    $words = preg_split('/\s+/u', trim($slide['title']));
    $slide['highlight'] = array_pop($words);
    $slide['titlelead'] = implode(' ', $words);
    $context['slides'][] = $slide;
}
$context['hasslides'] = count($context['slides']) > 1;
foreach (['documentsurl', 'trailsurl', 'platformsurl', 'privacyurl', 'cookiesurl', 'supporturl',
        'instagramurl', 'linkedinurl', 'youtubeurl'] as $key) {
    $context[$key] = theme_vemser_home_url($settings->{$key} ?? '');
}
$colours = [
    'primary' => '#ff6500', 'accent' => '#ffa300', 'text' => '#17202d', 'muted' => '#626975',
    'background' => '#ffffff', 'surface' => '#f4f6f8', 'card' => '#ffffff', 'buttontext' => '#ffffff',
];
$context['colours'] = '';
foreach ($colours as $key => $default) {
    $value = $settings->{'home' . $key} ?? $default;
    if (!preg_match('/^#[a-f0-9]{6}$/i', $value)) {
        $value = $default;
    }
    $context['colours'] .= '--vs-' . $key . ':' . $value . ';';
}
echo $OUTPUT->render_from_template('theme_vemser/frontpage', $context);
