<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Users extends Controller_Base {

    public function action_login()
    {
        $u = Arr::get($_POST, 'username', FALSE);
        $p = Arr::get($_POST, 'password', FALSE);
        if ($u && $p) Auth::instance()->login($u, $p);
        if (Auth::instance()->logged_in())
        {
            $this->redirect(URL::base(true));
        }
        else {
            array_push($this->template->styles, "../media/css/custom/sign-in.css");
            $this->template->entry = View::factory('SignIn');
        }
    }
}