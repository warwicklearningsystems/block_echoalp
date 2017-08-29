<?php

class ltiecho {

    private $courseid = null;
    private $ltidata = null;

    public function display() {

        global $DB, $CFG, $PAGE;

        if($this->ltidata) {
            $debuglaunch = FALSE;
            $content = lti_post_launch_html($this->ltidata->parameters, $this->ltidata->endpoint, $debuglaunch);
            echo $content;
        }
    }

    public function configurelti($courseid)
    {
        // Configure the LTI instance ready for launch
        global $DB, $CFG, $PAGE;
        require_once($CFG->dirroot . '/mod/lti/lib.php');
        require_once($CFG->dirroot . '/mod/lti/locallib.php');

        $this->courseid = $courseid;

        $i = new stdClass();
        $i->id = "COURSE" . $courseid;
        $i->typeid = $this->getLTIType();
        $i->course = $courseid;
        $i->instructorcustomparameters = array();
        $i->launchcontainer = LTI_LAUNCH_CONTAINER_EMBED_NO_BLOCKS;

        list($endpoint, $parms) = lti_get_launch_data($i);

        $parameters = array();
        foreach ($parms as $name => $value) {
            $parameters[$name] = $value;
        }

        $this->ltidata->endpoint = $endpoint;
        $this->ltidata->parameters = $parameters;
        //$result['warnings'] = $warnings;
    }

    private function getLTIType()
    {
      $ltitype = 120;

      $lticonfigtype = get_config('echoalp', 'ltitool');
      if($lticonfigtype != '') {
          $ltitype =  $lticonfigtype;
      }

      return $ltitype;
    }

}