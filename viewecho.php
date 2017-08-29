<?php

require_once('../../config.php');
require_once('ltiecho.php');

// Make sure nobody caches this page
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
header("Pragma: no-cache");

global $DB, $OUTPUT, $PAGE;

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_echoalp', $courseid);
}

require_login($course);

// Setup page
$PAGE->set_url('/blocks/echoalp/viewecho.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('viewecho', 'block_echoalp'));
$PAGE->set_course($course);

// Breadcrumbs
$settingsnode = $PAGE->settingsnav->add(get_string('pluginname', 'block_echoalp'));
$editurl = new moodle_url('/blocks/echoalp/viewecho.php', array('courseid' => $courseid));
$editnode = $settingsnode->add(get_string('pluginname', 'block_echoalp'), $editurl);
$editnode->make_active();

// Setup LTI
$le = new ltiecho();
$ltidata = $le->configurelti($course->id);

// Display LTI
echo $OUTPUT->header();
$le->display($ltidata);
echo $OUTPUT->footer();

?>