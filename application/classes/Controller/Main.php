<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_AuthBased {

    public function action_show()
    {
    }

    public function action_userRoles()
    {
        $user = Auth::instance()->get_user();
        $roles = [];
        foreach($user->roles->find_all() as $role)
        {
            $roles[] = $role->name;
        }
        $this->template->entry = View::factory('Roles', array('roles'=>$roles));
    }

    public function action_showUsers()
    {
        $m_users = ORM::factory('User')->find_all();
        $auth = Auth::instance()->get_user();
        $authrole = $auth->roles->order_by('id', 'asc')->find();
        $users = [];
        foreach($m_users as $user)
        {
            $role = $user->roles->order_by('id', 'asc')->find();
            $editable = false;
            if($authrole->name == 'admin')
            {
                $editable = true;
            }
            else if ($authrole->name == 'manager')
            {
                if($role->id >= $authrole->id)
                {
                    $editable = true;
                }
            }
            if(!$role->loaded())
            {
                $role = '';
            }
            else
            {
                $role = $role->name;
            }
            $users[] = array(
                'id' => $user->id,
                'login' => $user->username,
                'firstname' => $user->firstname,
                'secondname' => $user->secondname,
                'middlename' => $user->middlename,
                'role' => $role,
                'editable' => $editable
            );
        }
        array_push($this->template->styles, "../media/css/custom/offcanvas.css");
        $this->template->entry = View::factory('Users', array('users'=>$users));
    }
    
    public function action_editUser()
    {
        array_push($this->template->styles, "../media/css/custom/checkout.css");
        array_push($this->template->scripts, "../media/js/custom/checkout.js");
        ($id = $this->request->param('id')) ? $user = ORM::factory('User', $id) : $user = ORM::factory('User');
        $secondname = $user->secondname;
        $firstname = $user->firstname;
        $middlename = $user->middlename;
        $email = $user->email;
        $login = $user->username;
        $roles = ORM::factory('Role')->find_all()->as_array();
        $userRoles = $user->roles->find_all()->as_array();
        foreach($roles as $key=>&$role)
        {
            if($role->id == 999)
            {
                unset($role);
                unset($roles[$key]);
            }
            else
            {
                if(in_array($role, $userRoles))
                {
                    $role->checked = true;
                }
            }
        }
        $this->template->entry = View::factory('EditUser')
            ->bind('secondname', $secondname)
            ->bind('firstname', $firstname)
            ->bind('middlename', $middlename)
            ->bind('email', $email)
            ->bind('login', $login)
            ->bind('roles', $roles);
    }

    public function before()
    {
        parent::before();
    }
}