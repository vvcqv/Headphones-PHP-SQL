<?php
require('./assets/php/connection.php');
require('./assets/php/user/user.php');

class PrivilegedUser extends User
{
    private $roles;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE login = :username";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        $sth->execute(array('username' => $username));
        $result = $sth->fetchAll();
        if (!empty($result)) {
            $privUser = new PrivilegedUser();
            $privUser->user_id = $result[0]["user_id"];
            $privUser->login = $username;
            $privUser->passw = $result[0]["passw"];
            $privUser->email_addr = $result[0]["email_addr"];
            $privUser->initRoles();
            return $privUser;
        } else {
            return false;
        }
    }

    protected function initRoles()
    {
        $this->roles = array();
        $sql = "SELECT t1.role_id, t2.role_name FROM user_role as t1
                JOIN roles as t2 ON t1.role_id = t2.role_id
                WHERE t1.user_id = :user_id";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        $sth->execute(array("user_id" => $this->user_id));

        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->roles[$row["role_name"]] = Role::getRolePerms($row["role_id"]);
        }
    }

    public function hasRole($role_name)
    {
        return isset($this->roles[$role_name]);
    }

    public function hasPrivilege($perm)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }

        return false;
    }
}
