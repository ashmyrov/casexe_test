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

    function saveGift($gift){
        $sql = 'INSERT INTO `usersgifts` (user_id, gift_id, gift_value,status)
                VALUES (:user_id, :gift_id, :gift_val, :status)';
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':user_id' => $_SESSION['logined']['id'], ':gift_id' => $gift['id'], ':gift_val' => $gift['value'], ':status' => $gift['status']));

    }

    function exchangeGift($points){
        $sql = 'UPDATE `users`
                SET points = points + :money
                WHERE id = :id';
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':id' => $_SESSION['logined']['id'], ':money' => $points));

    }

    function getPoints(){
        $sql = 'SELECT points
                FROM users
                WHERE id = :id LIMIT 1';
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':id' => $_SESSION['logined']['id']));
        $result = $sth->fetch(PDO::FETCH_ASSOC)['points'];
        return $result;
    }
}