<?php
require('./assets/php/connection.php');
class User
{
    private $user_id;
    private $login;
    private $passw;
    private $email_addr;
    private $db;

    public function __construct()
    {
    }

    public static function getByUsernamePassw($username, $passw)
    {
        $sql = "SELECT * FROM users WHERE login = :username AND passw = :passw";
        $sth = $GLOBALS["pdo"]->prepare($sql);
        $sth->execute(array('username' => $username, 'passw' => $passw));
        $result = $sth->fetchAll();
        if (!empty($result)) {
            $privUser = new User();
            $privUser->user_id = $result[0]["user_id"];
            $privUser->login = $username;
            $privUser->passw = $result[0]["passw"];
            $privUser->email_addr = $result[0]["email_addr"];
            return $privUser;
        } else {
            return false;
        }
    }

    public function getLogin()
    {
        return $this->login;
    }
}
