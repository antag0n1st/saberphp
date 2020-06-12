<?php

Load::script('controllers/admin');

class UsersController extends AdminController {

    public function __construct() {
        parent::__construct();
        
        $this->need(PERMISSION_USER_MANAGEMENT);
    }

    public function main() {
        $this->manage();
    }

    public function manage() {
        $this->set_view('list_users');

        $this->set_menu('user-management', 'manage');

        $users = User::find_all();
        Load::assign('users', $users);
        
        $roles = Role::find_all();
        Load::assign('roles', $roles);
       
    }
    
    public function kick_out($id){
        $this->no_layout();
        
        KnownSession::drop_sessions($id);
        
        $this->set_confirmation('The user was kicked out');
        URL::redirect_to_refferer();
        
    }

    public function roles() {
        $this->set_view('list_roles');
        $this->set_menu('user-management', 'roles');

        $roles = Role::find_all();
        Load::assign('roles', $roles);
    }

    public function add_role() {
        $this->set_view('details_role');
        $this->set_menu('user-management', 'roles');

        if (isset($_POST) and $_POST) {
            $role = new Role();
            $role->name = $this->get_post('name');
            $role->description = $this->get_post('description');
            $role->updated_at = TimeHelper::DateTimeAdjusted();
            $role->save();

            URL::redirect('users/roles');
        }
    }

    public function edit_role($id) {
        $this->set_view('details_role');
        $this->set_menu('user-management', 'roles');

        $role = Role::find_by_id($id);

        if (isset($_POST) and $_POST) {

            $role->name = $this->get_post('name');
            $role->description = $this->get_post('description');
            $role->updated_at = TimeHelper::DateTimeAdjusted();
            $role->save();

            URL::redirect('users/roles');
        }

        Load::assign('role', $role);
    }

    public function delete_role($id) {
        $this->no_layout();

        $role = Role::find_by_id($id);
        $role->delete();

        URL::redirect_to_refferer();
    }

    public function permissions() {
        
        $this->set_view('list_permissions');
        $this->set_menu('user-management', 'permissions');

        $permissions = Permission::find_all();
        Load::assign('permissions', $permissions);
    }

    public function add_permission() {
        $this->set_view('details_permission');
        $this->set_menu('user-management', 'permissions');

        if (isset($_POST) and $_POST) {
            $permission = new Permission();
            $permission->name = $this->get_post('name');
            $permission->description = $this->get_post('description');
            $permission->save();

            URL::redirect('users/permissions');
        }
    }
    
    public function edit_permission($id) {
        $this->set_view('details_permission');
        $this->set_menu('user-management', 'permissions');

        $permission = Permission::find_by_id($id);

        if (isset($_POST) and $_POST) {

            $permission->name = $this->get_post('name');
            $permission->description = $this->get_post('description');
            $permission->save();

            URL::redirect('users/permissions');
        }

        Load::assign('permission', $permission);
    }
    
    public function delete_permission($id) {
        $this->no_layout();

        $permission = Permission::find_by_id($id);
        $permission->delete();

        URL::redirect_to_refferer();
    }
    
    public function assign_permissions($role_id = 0) {
        
        $this->set_menu('user-management', 'permissions');

        if(isset($_POST) and $_POST){
            $prs = $this->get_post('permissions');
            Permission::delete_by_role($role_id);
            $prs = $prs ? $prs : [];
            Permission::add_permissions($role_id, $prs);
            URL::redirect('users/roles');
        }
        
        $permissions = Permission::find_all();
        
        
        $perm = Permission::find_by_role($role_id);
        
//        echo "<pre>";
//        print_r($permissions);
//        print_r($perm);
        
        foreach ($perm as $k => $v) {
            foreach ($permissions as &$permission) {
              
//                print_r($v." - ".$permission->id." \n");
                if($v == $permission->id){                    
                    $permission->is_assigned = true;                    
                } 
            }
        }
        
        Load::assign('permissions', $permissions);
        
    }

    public function change_role($role, $id) {

        $this->no_layout();

        /* @var $user User */
        $user = User::find_by_id($id);
        $user->role_id = $role;
        $user->save();
        $roles = Role::find_all();

        $this->set_confirmation('User <b>' . $user->username . '</b> is now <b>' . Role::match($role, $roles) . "</b>");

        URL::redirect_to_refferer();
    }

    public function delete($id) {
        $this->no_layout();

        /* @var $user User */
        $user = User::find_by_id($id);
        $user->delete();

        $this->set_confirmation('User <b>' . $user->username . '</b> is deleted.');


        URL::redirect_to_refferer();
    }

}

?>