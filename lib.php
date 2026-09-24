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
        'documentsimage',
    ];

    $slotimage = preg_match('/^(quick(?:[1-9]|10)|supplier[1-4]|slide[2-4])image$/', $filearea);
    if (!in_array($filearea, $allowedareas, true) && !$slotimage) {
        send_file_not_found();
    }

    $theme = theme_config::load('vemser');
    return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
}

/** Resolve a configured link, allowing only local paths and HTTP(S) destinations. */
function theme_vemser_home_url($value) {
    global $CFG;
    $value = trim((string)$value);
    if ($value === '' || preg_match('/[\x00-\x20\\\\]/', $value)) {
        return '';
    }
    if (strpos($value, '/') === 0 && strpos($value, '//') !== 0) {
        return $CFG->wwwroot . $value;
    }
    if (preg_match('~^https?://~i', $value) && filter_var($value, FILTER_VALIDATE_URL)) {
        return $value;
    }
    return '';
}

/** Image configured by the site administrator. */
function theme_vemser_home_image($name) {
    global $PAGE;
    return $PAGE->theme->setting_file_url($name, $name) ?: '';
}

/** Configuration shared by settings and the homepage. */
function theme_vemser_home_link_defaults() {
    return [
        'quick' => ['E-mail', 'WinThor', 'RM TOTVS', 'Agile', 'Scopi', 'GLPI', '3CX',
            'Base de Conhecimento', 'Gestão de Pessoas', 'Planilha de Entregas'],
        'supplier' => ['Biancogrês', 'Incenor', 'Suvinil', 'Quartzolit'],
    ];
}

/** Build the public homepage using Moodle visibility and forum access rules. */
function theme_vemser_home_content() {
    global $CFG, $PAGE, $DB, $SITE;
    require_once($CFG->dirroot . '/mod/forum/lib.php');
    $settings = $PAGE->theme->settings;
    $data = ['courses' => [], 'news' => [], 'coursesurl' => (new moodle_url('/course/index.php'))->out(false)];

    foreach (theme_vemser_home_link_defaults() as $group => $names) {
        $data[$group] = [];
        foreach ($names as $index => $default) {
            $key = $group . ($index + 1);
            $name = $settings->{$key . 'name'} ?? $default;
            if (trim($name) === '') {
                continue;
            }
            $data[$group][] = [
                'name' => $name,
                'url' => theme_vemser_home_url($settings->{$key . 'url'} ?? ''),
                'image' => theme_vemser_home_image($key . 'image'),
                'initial' => core_text::strtoupper(core_text::substr($name, 0, 1)),
            ];
        }
        $data['has' . $group] = !empty($data[$group]);
    }

    $courses = core_course_category::top()->get_courses([
        'recursive' => true, 'limit' => 6, 'summary' => true, 'sort' => ['sortorder' => 1],
    ]);
    foreach ($courses as $course) {
        $context = context_course::instance($course->id);
        $category = core_course_category::get($course->category, IGNORE_MISSING);
        $data['courses'][] = [
            'name' => format_string($course->fullname, true, ['context' => $context]),
            'url' => (new moodle_url('/course/view.php', ['id' => $course->id]))->out(false),
            'image' => \core_course\external\course_summary_exporter::get_course_image($course),
            'category' => $category ? format_string($category->name, true,
                ['context' => context_coursecat::instance($category->id)]) : '',
        ];
    }

    // Read an existing news forum; do not create one during rendering.
    $forum = $DB->get_record('forum', ['course' => SITEID, 'type' => 'news'], '*', IGNORE_MULTIPLE);
    if ($forum) {
        $modinfo = get_fast_modinfo($SITE);
        $instances = $modinfo->get_instances_of('forum');
        $cm = $instances[$forum->id] ?? null;
        if ($cm && $cm->uservisible && has_capability('mod/forum:viewdiscussion', $cm->context)) {
            $data['newsurl'] = (new moodle_url('/mod/forum/view.php', ['id' => $cm->id]))->out(false);
            foreach (forum_get_discussions($cm, 'd.pinned DESC, p.created DESC', true, -1, 3) as $post) {
                $discussion = clone $post;
                $discussion->id = $post->discussionid;
                if (!forum_user_can_see_post($forum, $discussion, $post, null, $cm)) {
                    continue;
                }
                $image = '';
                foreach (['post', 'attachment'] as $area) {
                    foreach (get_file_storage()->get_area_files($cm->context->id, 'mod_forum', $area,
                            $post->id, 'sortorder, id', false) as $file) {
                        if ($file->is_valid_image()) {
                            $image = moodle_url::make_pluginfile_url($cm->context->id, 'mod_forum', $area,
                                $post->id, $file->get_filepath(), $file->get_filename())->out(false);
                            break 2;
                        }
                    }
                }
                $message = format_text($post->message, $post->messageformat,
                    ['context' => $cm->context, 'filter' => false, 'para' => false]);
                $data['news'][] = [
                    'name' => format_string($post->subject, true, ['context' => $cm->context]),
                    'url' => (new moodle_url('/mod/forum/discuss.php', ['d' => $post->discussionid]))->out(false),
                    'date' => userdate($post->created, get_string('strftimedate', 'langconfig')),
                    'datetime' => date('c', $post->created),
                    'summary' => shorten_text(trim(html_to_text($message, 0, false)), 130),
                    'image' => $image,
                ];
            }
        }
    }
    foreach (['platformsurl', 'suppliersurl'] as $key) {
        $data[$key] = theme_vemser_home_url($settings->{$key} ?? '');
    }
    $data['documentsurl'] = theme_vemser_home_url($settings->documentsurl ?? '');
    $data['documentsimage'] = theme_vemser_home_image('documentsimage');
    return $data;
}
