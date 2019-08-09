<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller_Template {

    public function before()
    {
        parent::before();
        if (Request::initial()->is_ajax()) $this->template->set_filename('ajax_template');
        if (!Request::initial()->is_ajax())
        {
            $this->template->styles = array(
                "../media/css/bootstrap/bootstrap.min.css",
            );

            $this->template->scripts = array();
        }
    }


}
