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

$settings->add(new admin_setting_heading('echoalpblock',
                                         "Echo ALP block",
                                         "Echo ALP configuration options"));

$lttypes = $DB->get_records('lti_types', array('course' => 1));
$optionslti = array();

foreach($lttypes as $lt) {
    $optionslti[ $lt->id ] = $lt->name;
}

$settings->add( new admin_setting_configselect("echoalp/ltitool",
                                                "LTI tool",
                                                "Preconfigured LTI to use for block",
                                                "1",
                                                $optionslti) );


