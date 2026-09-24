<?php
// Homepage presentation; other course screens retain the Boost renderer.
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/course/renderer.php');

class theme_vemser_core_course_renderer extends core_course_renderer {
    /** Render homepage sections without duplicating the native course/news lists. */
    public function frontpage() {
        return $this->render_from_template('theme_vemser/home_content', theme_vemser_home_content());
    }
}
