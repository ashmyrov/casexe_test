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

    function subjectsArray(){
        $sql = 'SELECT name FROM `gifts`
                WHERE `type` = 1';
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function moneyArray(){
        $sql = 'SELECT min, max FROM `gifts`
                WHERE `type` = 2';
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function pointsArray(){
        $sql = 'SELECT min, max FROM `gifts`
                WHERE `type` = 3';
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}