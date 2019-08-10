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
        $users = [];
        foreach($m_users as $user)
        {
            $role = Model_User::getParentUserRole($user);
            $editable = Model_User::havePrivelegeOnUser(Auth::instance()->get_user(), $user);
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

    protected function filterRolesFromPost(&$roles, $post)
    {
        foreach($roles as $key=>&$role)
        {
            if(array_key_exists('role_' . $role->id, $post))
            {
                $role->checked = true;
            }
        }
    }
    
    public function action_editUser()
    {
        ($id = $this->request->param('id')) ? $user = ORM::factory('User', $id) : $user = ORM::factory('User');
        if($user->loaded())
        {
            if(!Model_User::havePrivelegeOnUser(Auth::instance()->get_user(), $user))
            {
                $this->template->entry = View::factory('EditUserDenied');
                return;
            }
        }
        $this->template->entry = View::factory('EditUser')
            ->bind('secondname', $secondname)
            ->bind('firstname', $firstname)
            ->bind('middlename', $middlename)
            ->bind('email', $email)
            ->bind('login', $login)
            ->bind('roles', $roles)
            ->bind('id', $id)
            ->bind('info', $info)
            ->bind('infoClass', $infoClass)
            ->bind('passwordRequired', $passwordRequired);
        $passwordRequired = false;
        if($id == null)
        {
            $passwordRequired = true;
        }
        $infoClass = "text-muted";
        array_push($this->template->styles, "../media/css/custom/checkout.css");
        array_push($this->template->scripts, "../media/js/custom/checkout.js");
        $info = "";
        if($this->request->post())
        {
            if(empty(Arr::get($_POST, 'password', '')) && !$user->loaded())
            {
                $infoClass = "text-danger";
                $info = "Ошибка при сохранении пользователя: пароль не может быть пустым";
            }
            else{
                try {
                    $user->set('secondname', Arr::get($_POST, 'secondName', ' '))
                        ->set('firstname', Arr::get($_POST, 'firstName', ' '))
                        ->set('middlename', Arr::get($_POST, 'middleName', ' '))
                        ->set('email', Arr::get($_POST, 'email', ' '))
                        ->set('username', Arr::get($_POST, 'login', ' '));
                    $password = Arr::get($_POST, 'password', '');
                    if(!($user->loaded() && empty($password)))
                    {
                        $user->set('password', $password);
                    }
                    $user->save();
                    $passwordRequired = false;
                    $keys = array_keys($_POST);
                    $postRoles = preg_grep('/role_{1}/i',$keys);
                    if(count($postRoles) > 1)
                    {
                        $infoClass = "text-warning";
                        $info = "Выберите одну роль";
                    }
                    else{
                        $roles = ORM::factory('Role')->find_all()->as_array();
                        if($user->loaded())
                        {
                            $userRoles = $user->roles->find_all()->as_array();
                            foreach($roles as $role)
                            {
                                if($role->id == 999)
                                    continue;
                                if(!Role::havePrivelegeOnRole(Model_User::getParentUserRole(Auth::instance()->get_user()),
                                    $role))
                                    continue;
                                if(array_key_exists('role_' . $role->id, $_POST))
                                {
                                    if(!in_array($role, $userRoles))
                                    {
                                        $user->add('roles', $role);
                                    }
                                }
                                else if(in_array($role, $userRoles))
                                {
                                    $user->remove('roles', $role);
                                }
                            }
                        }
                        $infoClass = "text-success";
                        $info = "Изменения сохранены";
                    }
                }
                catch (Exception $e) {
                    $infoClass = "text-danger";
                    $info = "Ошибка при сохранении пользователя: "  . $e->getMessage();
                }
            }
        }

        $roles = Role::getRolesForUsersWithDisabledFlag(Auth::instance()->get_user());
        if($user->loaded())
        {
            $secondname = $user->secondname;
            $firstname = $user->firstname;
            $middlename = $user->middlename;
            $email = $user->email;
            $login = $user->username;
            $id = $user->id;
            if(isset($postRoles))
            {
                if(count($postRoles) > 1)
                {
                    $this->filterRolesFromPost($roles, $_POST);
                }
                else{
                    Role::checkUserRoles($user, $roles);
                }
            }
            else{
                Role::checkUserRoles($user, $roles);
            }
        }
        else{
            $secondname = Arr::get($_POST, 'secondName', '');
            $firstname = Arr::get($_POST, 'firstName', '');
            $middlename = Arr::get($_POST, 'middleName', '');
            $email = Arr::get($_POST, 'email', '');
            $login = Arr::get($_POST, 'login', '');
            $this->filterRolesFromPost($roles, $_POST);
        }
    }

    public function before()
    {
        parent::before();
    }
}