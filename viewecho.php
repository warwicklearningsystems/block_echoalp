<?php

require_once('../../config.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');
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
//$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('viewecho', 'block_echoalp'));
$pagetitle = strip_tags($course->shortname.': '. get_string('viewecho', 'block_echoalp'));
$PAGE->set_title($pagetitle);
$PAGE->set_course($course);

$launchcontainer = get_config('echoalp', 'ltiopen');

if ($launchcontainer == LTI_LAUNCH_CONTAINER_EMBED_NO_BLOCKS) {
    $PAGE->set_pagelayout('frametop'); // Most frametops don't include footer, and pre-post blocks.
    $PAGE->blocks->show_only_fake_blocks(); // Disable blocks for layouts which do include pre-post blocks.
} else if ($launchcontainer == LTI_LAUNCH_CONTAINER_REPLACE_MOODLE_WINDOW) {
    redirect('launch.php?courseid=' . $course->id);
} else {
    $PAGE->set_pagelayout('incourse');
}

// Breadcrumbs
$settingsnode = $PAGE->settingsnav->add(get_string('pluginname', 'block_echoalp'));
$editurl = new moodle_url('/blocks/echoalp/viewecho.php', array('courseid' => $courseid));
$editnode = $settingsnode->add(get_string('pluginname', 'block_echoalp'), $editurl);
$editnode->make_active();

// Display the output
echo $OUTPUT->header();

// Decide how to display
if ( $launchcontainer == LTI_LAUNCH_CONTAINER_WINDOW ) {
    echo "<script language=\"javascript\">//<![CDATA[\n";
    echo "window.open('launch.php?courseid=" . $course->id . "');";
    echo "//]]\n";
    echo "</script>\n";
    echo "<p>".get_string("echo_in_newwindow", "block_echoalp")."</p>\n";

    $url = new moodle_url('/blocks/echoalp/launch.php', array('courseid' => $course->id));
    echo html_writer::start_tag('p');
    echo html_writer::link($url, get_string("echo_in_newwindow_open", "block_echoalp"), array('target' => '_blank'));
    echo html_writer::end_tag('p');

} else {
    // Request the launch content with an iframe tag.
    echo '<iframe id="contentframe" height="600px" width="100%" src="launch.php?courseid='.$course->id.'"></iframe>';

    // Output script to make the iframe tag be as large as possible.
    $resize = '
        <script type="text/javascript">
        //<![CDATA[
            YUI().use("node", "event", function(Y) {
                var doc = Y.one("body");
                var frame = Y.one("#contentframe");
                var padding = 15; //The bottom of the iframe wasn\'t visible on some themes. Probably because of border widths, etc.
                var lastHeight;
                var resize = function(e) {
                    var viewportHeight = doc.get("winHeight");
                    if(lastHeight !== Math.min(doc.get("docHeight"), viewportHeight)){
                        frame.setStyle("height", viewportHeight - frame.getY() - padding + "px");
                        lastHeight = Math.min(doc.get("docHeight"), doc.get("winHeight"));
                    }
                };

                resize();

                Y.on("windowresize", resize);
            });
        //]]
        </script>
';

    echo $resize;
}

echo $OUTPUT->footer();
?>