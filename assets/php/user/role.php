<?php
require('./assets/php/connection.php');
class Role
{
    protected $permissions;

    protected function __construct()
    {
        $this->permissions = array();
    }

    // Возвращаем объект роли с соответствующими полномочиями
    public static function getRolePerms($role_id)
    {
        $role = new Role();
        $sql = "SELECT t2.perm_desc FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = :role_id";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        $sth->execute(array('role_id' => $role_id));
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $role->permissions[$row["perm_desc"]] = true;
        }
        return $role;
    }
    // Проверка установленных полномочий
    public function hasPerm($permission)
    {
        return isset($this->permissions[$permission]);
    }
    // Вставка новой роли
    public static function insertRole($role_name)
    {
        $sql = "INSERT INTO roles (role_name) VALUES (:role_name)";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        return $sth->execute(array(":role_name" => $role_name));
    }
    public static function insertUserRoles($user_id, $roles)
    {
        $sql = "INSERT INTO user_role (user_id, role_id) VALUES (:user_id, :role_id)";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        foreach ($roles as $role_id) {
            $sth->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $sth->bindParam(":role_id", $role_id, PDO::PARAM_INT);
            $sth->execute();
        }
        return true;
    }
    public static function deleteRoles($roles)
    {
        $sql = "DELETE FROM `user_role` WHERE role_id=:role_id";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        foreach ($roles as $role_id) {
            $sth->bindParam(":role_id", $role_id, PDO::PARAM_INT);
            $sth->execute();
        }
        $sql = "DELETE FROM `role_perm` WHERE role_id=:role_id";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        foreach ($roles as $role_id) {
            $sth->bindParam(":role_id", $role_id, PDO::PARAM_INT);
            $sth->execute();
        }
        $sql = "DELETE FROM `roles` WHERE role_id=:role_id";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        foreach ($roles as $role_id) {
            $sth->bindParam(":role_id", $role_id, PDO::PARAM_INT);
            $sth->execute();
        }
        return true;
    }
    public static function deleteUserRoles($user_id)
    {
        $sql = "DELETE FROM user_role WHERE user_id = :user_id";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        return $sth->execute(array(":user_id" => $user_id));
    }
}
