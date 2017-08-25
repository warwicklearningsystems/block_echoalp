<?php

class ltiecho {

    function display($course) {

        global $DB, $CFG, $PAGE;

        $debuglaunch = FALSE;
        $ltidata = $this->configurelti(1, $course->id);
        $content = lti_post_launch_html($ltidata->parameters, $ltidata->endpoint, $debuglaunch);
        echo $content;
    }

    private function configurelti($ltitypeid, $courseid)
    {
        global $DB, $CFG, $PAGE;
        require_once($CFG->dirroot . '/mod/lti/lib.php');
        require_once($CFG->dirroot . '/mod/lti/locallib.php');

        $i = new stdClass();
        $i->id = 11351351351;
        $i->typeid = $ltitypeid;
        $i->course = $courseid;
        $i->instructorcustomparameters = array();

        list($endpoint, $parms) = lti_get_launch_data($i);

        $parameters = array();
        foreach ($parms as $name => $value) {
            $parameters[$name] = $value;
        }

        $result = new stdClass();
        $result->endpoint = $endpoint;
        $result->parameters = $parameters;
        //$result['warnings'] = $warnings;

        return $result;
    }



}