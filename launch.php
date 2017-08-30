<?php

require_once("../../config.php");
require_once($CFG->dirroot.'/mod/lti/lib.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');

require_once('ltiecho.php');

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_echoalp', $courseid);
}

require_login($course);
//require_capability('mod/lti:view', $course->parent);

// Setup LTI
$le = new ltiecho();
$ltidata = $le->configurelti($course->id);

$le->display($ltidata);





