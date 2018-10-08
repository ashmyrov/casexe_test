<?php
class Model_Ajax extends Model
{
	function checkUser($log_info){
        $sql = 'SELECT *
                FROM users
                WHERE login = :login AND password = :password LIMIT 1';
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':login' => $log_info['login'], ':password' => md5($log_info['password'])));
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}