<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AuthBased extends Controller_Base {


    public function before()
    {
        parent::before();
        if (!Auth::instance()->logged_in()) $this->redirect('users/login');
    }


}
