<?php

class ltiecho {

    private $courseid = null;
    private $endpoint = null;
    private $parameters = null;

    public function display() {

        global $DB, $CFG, $PAGE;

        if($this->endpoint && $this->parameters) {
            $debuglaunch = FALSE;
            $content = lti_post_launch_html($this->parameters, $this->endpoint, $debuglaunch);
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

        $this->endpoint = $endpoint;
        $this->parameters = $parameters;
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