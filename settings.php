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

require_once($CFG->dirroot.'/mod/lti/locallib.php');

$settings->add(new admin_setting_heading('echoalpblock',
                                         "Echo ALP block",
                                         "Echo ALP configuration options"));

// Which pre-configured LTI tool to use
$lttypes = $DB->get_records('lti_types', array('course' => 1));
$optionslti = array();
foreach($lttypes as $lt) {
    $optionslti[ $lt->id ] = $lt->name;
}
if(count($optionslti) > 0){
    $settings->add( new admin_setting_configselect("echoalp/ltitool",
                                                "LTI tool",
                                                "Preconfigured LTI to use for block",
                                                "1",
                                                $optionslti) );
}

// How to open
$openoptions = array(LTI_LAUNCH_CONTAINER_EMBED => get_string('embed', 'lti'),
                     LTI_LAUNCH_CONTAINER_EMBED_NO_BLOCKS => get_string('embed_no_blocks', 'lti'),
                     LTI_LAUNCH_CONTAINER_WINDOW => get_string('new_window', 'lti'),
                     LTI_LAUNCH_CONTAINER_REPLACE_MOODLE_WINDOW => get_string('existing_window', 'lti'));

$settings->add( new admin_setting_configselect("echoalp/ltiopen",
    "Launch container",
    "How to open the Echo link",
    LTI_LAUNCH_CONTAINER_WINDOW,
    $openoptions) );
