<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Echo ALP block
 *
 * @package    block_echoalp
 * @copyright  Russell Boyatt <russell.boyatt@warwick.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_echoalp extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_echoalp');
    }

    function get_content() {
        global $CFG, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $courseid = $this->page->course->id;

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        // Set Echo link
        $link = '/blocks/echoalp/viewecho.php?courseid=' . $courseid;

        // Build block content
        $content = '';
        $content .= html_writer::start_tag('a', array('href' => $link, 'class' => 'name'));
        $content .= html_writer::empty_tag('img', array(
            'src' => $OUTPUT->pix_url('echo360_logo_622x298', 'block_echoalp'),
            'title' => get_string('imagealt', 'block_echoalp'),
            'alt' => get_string('imagealt', 'block_echoalp'),
            'width' => '100%',
            'class' => 'echolinkimage'));
        $content .= html_writer::end_tag('a');

        $this->content->text = $content;

        // user/index.php expect course context, so get one if page has module context.
        $currentcontext = $this->page->context->get_course_context(false);

        //$this->construct_lti_settings($ltitool);
        //lti_launch_tool();

        return $this->content;
    }

    private function construct_lti_settings()
    {

    }

    public function applicable_formats() {
        // Only allow within courses
        return array('all' => false,
                     'site' => false,
                     'site-index' => false,
                     'course-view' => true);
    }

    public function hide_header() {
      if ($this->page->user_is_editing()) {
        return false;
      } else {
        return true;
      }
    }

    public function instance_allow_multiple() {
          return false;
    }

    function has_config() {
        return true;
    }

    public function cron() {
            mtrace( "Hey, my cron script is running" );
             
                 // do something
                  
                      return true;
    }
}
