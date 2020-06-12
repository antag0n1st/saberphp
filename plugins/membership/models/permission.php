<?php

class Permission {

    public static function find_all() {

        $consts = get_defined_constants(true)['user'];

        $objects = [];
        
        Load::script('config/permissions_description');
        
        global $_permission_description;
        
        foreach ($consts as $key => $value) {
            if (substr($key, 0, 11) === "PERMISSION_") {
                $o = new stdClass();
                $o->id = $value;
                $o->name = str_replace("_", " ", $key);
                $o->description = $_permission_description[$value];
                $o->is_assigned = false;
                $objects[] = $o;
            }
        }

        return $objects;
    }

    public static function find_by_role($role_id) {

        $query = " SELECT * FROM permission_role AS pr ";
        $query .= " WHERE pr.role_id = '" . Model::db()->prep($role_id) . "'; ";

        $result = Model::db()->query($query);

        $permissions = [];

        while ($row = Model::db()->fetch_assoc($result)) {
            $permissions[] = $row['permission_id'];
        }

        return $permissions;
    }

    public static function delete_by_role($role_id) {

        $query = " DELETE from permission_role ";
        $query .= " WHERE role_id = '" . Model::db()->prep($role_id) . "'; ";

        Model::db()->query($query);
    }

    public static function add_permissions($role_id, $permissions = []) {
        $query = " INSERT INTO permission_role (role_id,permission_id) ";
        $query .= " VALUES ";
        $data = [];
        foreach ($permissions as $key => $permission) {
            $data[] = "('" . Model::db()->prep($role_id) . "','" . Model::db()->prep($permission) . "')";
        }

        if (count($data)) {
            $query .= implode(",", $data);
            Model::db()->query($query);
        }
    }

}
