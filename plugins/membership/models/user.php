<?php

class User extends Model {

    public static $table_name = 'users';
    public static $id_name = 'user_id';
    public static $db_fields = array('user_id', 'username', 'password_2', 'created_at', 'last_logged_at', 'login_count', 'role_id', 'session_id' , 'email','full_name','reset_code');
    public static $FACEBOOK = 'facebook';
    public static $ANONYMOUS = 'anonymous';
    public static $STANDARD = 'standard';
    public $user_id;
    public $username;
    public $password_2;
    public $created_at;
    public $last_logged_at;
    public $login_count;
    public $role_id;
    public $session_id;
    public $is_logged = false;
    public $email;
    public $full_name;
    public $reset_code;
    public $permissions = [];

    public static function find_by_username($username) {
        $query = " SELECT * from users ";
        $query .= " WHERE username = '" . Model::db()->prep($username) . "' ";
        $query .= " LIMIT 1 ";

        $users = static::find_by_sql($query);
        $user = count($users) ? $users[0] : null;


        return $user;
    }

    public static function find_user($username = null, $password = null, $session_id = null) {

        $query = " SELECT * from users ";

        $where = array();
        if ($username) {
            $where[] = " username = '" . Model::db()->prep($username) . "' ";
            $where[] = " password_2 = '" . md5(Model::db()->prep($password)) . "' ";
        }

//        if ($password) {
//            $where[] = " password_2 = '" . md5(Model::db()->prep($password)) . "' ";
//        }

        if (!$username && !$password && $session_id) {
            $where[] = " session_id = '" . Model::db()->prep($session_id) . "' ";
        }

        if (count($where)) {
            $query .= ' WHERE ' . implode('AND', $where);
        } else {
            return null;
        }

        $query .= " LIMIT 1";

        $users = static::find_by_sql($query);
        $user = count($users) ? $users[0] : null;

        if ($user) {
            
            if($user->role_id){
                $user->is_logged = true;
                $user->permissions = Permission::find_by_role($user->role_id);
                
            } else {
                return null;
            }
            
        }
        
        return $user;
    }
    
    public static function find_by_email($email){
         $query = " SELECT * from users ";
         $query .= " WHERE email = '".Model::db()->prep($email)."' ";
         
         $result = static::find_by_sql($query);
         
         return count($result) ? $result[0] : null;
    }
    
    public static function find_by_reset_code($code){
         $query = " SELECT * from users ";
         $query .= " WHERE reset_code = '".Model::db()->prep($code)."' ";
         
         $result = static::find_by_sql($query);
         
         return count($result) ? $result[0] : null;
    }

    public function is_username_cyrilic() {
        return (strtolower($this->username) != mb_strtolower($this->username, 'UTF-8'));
    }

    public static function get_role($number) {

        switch ($number) {
            case 1:
                return 'Unauthorized';
            case 5:
                return 'Editor';
            case 9:
                return 'Administrator';

            default:
                break;
        }
    }
    
    public static function update_password($user_id, $old_password, $new_password) {

        $query = " SELECT * from users ";
        $query .= " WHERE password_2 = '" . md5(Model::db()->prep($old_password)) . "' ";
        $query .= " AND user_id = '" . Model::db()->prep($user_id) . "' ";
        $query .= " LIMIT 1 ";

        Model::db()->query($query);

        if (Model::db()->affected_rows_count() === 1) {
            $query = " UPDATE users SET ";
            $query .= " password_2 = '" . md5(Model::db()->prep($new_password)) . "' ";
            $query .= " WHERE user_id = '" . Model::db()->prep($user_id) . "' ";
            $query .= " LIMIT 1 ";

            Model::db()->query($query);
            return true;
        }
        
        return false;
    }

}
