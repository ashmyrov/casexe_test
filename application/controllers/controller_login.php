<?php


class Controller_Login extends Controller
{
    function __construct()
    {
        $this->model = new Model_Login();
        $this->view = new View();
    }

    function action_index()
    {
        $data['home_link'] = $this->model->home_link;
        $this->view->generate('login_view.php', 'main_login_view.php');
    }

    function action_login()
    {

        $this->view->generate('login_view.php', 'main_view.php');
    }

}