<?php
class Controller_Ajax extends Controller
{
    function __construct()
    {
        $this->model = new Model_Ajax();
    }

    function action_login(){
        $data['logined'] = $this->model->checkUser($_POST);
        if($data['logined']){
            $_SESSION['logined'] = $data['logined'];
            echo 'success';
        }

    }

    function action_logout(){
        unset($_SESSION['logined']);
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/casexe_test/';
        header('Location:'.$host);
    }
}
















