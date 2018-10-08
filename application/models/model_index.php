<?php
class Model_Index extends Model
{
    function getPoints(){
        $sql = 'SELECT points
                FROM users
                WHERE id = :id LIMIT 1';
        $sth = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':id' => $_SESSION['logined']['id']));
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result['points'];
    }
}