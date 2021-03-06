<?php

class Database
{
    public $permission_table;
    private $conn;
    private $user;
    private $pass;
    private $database;
    private $host;

    public function __construct() {
        $this->permission_table = json_decode(file_get_contents(__DIR__ . "/../data/permissions.json"), true);
        $auth_config = parse_ini_file("auth.ini.php");
        $this->user = $auth_config["username"];
        $this->pass = $auth_config["password"];
        $this->database = $auth_config["database"];
        $this->host = $auth_config["host"];
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->pass);
    }

    public function get_all_users() {
        $users = $this->prepared_query("SELECT * FROM users");
        return $users;
    }

    public function prepared_query($statement, $bindings = []) {
        $stmt = $this->conn->prepare($statement);
        foreach ($bindings as $i => $bind) {
            $stmt->bindValue(($i + 1), $bind);
        }
        $exec = $stmt->execute();
        if (!$exec) {
            return false;
        }
        $output = array();
        while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {
            $output[] = $result;
        }
        $count = count($output);
        if ($count == 0) {
            return false;
        } else {
            return $output;
        }

    }

    public function get_user($id) {
        $user = $this->prepared_query("SELECT id,username,displayname,email,imageid FROM users WHERE id=?", [$id])[0];
        return $user;
    }

    public function delete_user($id) {
        $this->prepared_query("DELETE FROM users WHERE id=?", [$id]);
        $this->prepared_query("DELETE FROM permissions WHERE id_user=?", [$id]);
        return true;
    }

    //user permissions

    public function user_has_permission($id, $array, $all = false) {
        $result = $all;
        $permissions = $this->get_user_permissions($id);
        foreach ($array as $permission) {
            if ($all) {
                if (!in_array($permission, $permissions)) {
                    $result = false;
                }
            } else {
                if (in_array($permission, $permissions)) {
                    $result = true;
                }
            }
        }
        if ($result) return 1;
        else return 0;

    }

    public function get_user_permissions($id) {

        $permissions = [];
        $result = $this->prepared_query("SELECT `permission` FROM permissions WHERE id_user=?", [$id]);
        if ($result) {
            foreach ($result as $k => $v) {
                $permissions[] = $v->permission;
            }
            if ($permissions) {
                return $permissions;
            }
        }
        return [];

    }

    public function set_user_details($data) {
        $result = $this->prepared_query("UPDATE users SET username=?, displayname=?, email=? WHERE id=?", [$data["username"], $data["displayname"], $data["email"], $data["id"]]);
        if ($result) {
            return true;
        }
        return false;
    }

    public function new_user($username, $password) {
        $new_password = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->prepared_query("INSERT INTO users (username, password) VALUES (?,?)", [$username, $new_password]);
        if ($result) {
            return true;
        }
        return false;
    }

    public function set_image($imageid, $id) {
        $result = $this->prepared_query("UPDATE users SET imageid=? WHERE id=?", [$imageid, $id]);
        if ($result) {
            return true;
        }
        return false;
    }

    public function set_permissions($id, $changes) {
        if (isset($changes,$id)) {
            if (isset($changes["add"])) {
                foreach($changes["add"] as $permission){
                    $this->prepared_query("INSERT INTO permissions (id_user, permission) VALUES (?,?)", [$id, $permission]);
                }
            }
            if (isset($changes["remove"])) {
                foreach($changes["remove"] as $permission){
                    $this->prepared_query("DELETE FROM permissions WHERE id_user=? AND permission=?", [$id, $permission]);
                }
            }
        }
    }
}