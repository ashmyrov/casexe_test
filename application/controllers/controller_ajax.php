<?php

class Controller_Ajax extends Controller
{
    function __construct()
    {
        $this->model = new Model_Ajax();
    }

    function action_login()
    {
        $data['logined'] = $this->model->checkUser($_POST);
        if ($data['logined']) {
            $_SESSION['logined'] = $data['logined'];
            echo 'success';
        }

    }

    function action_logout()
    {
        unset($_SESSION['logined']);
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/casexe_test/';
        header('Location:' . $host);
    }

    function action_getGift()
    {
        $giftType = random_int(1, 3);
        switch ($giftType) {
            case 1:
                $result['value'] = $this->subjectGift();
                $result['type'] = 1;
                $result['name'] = 'subject';
                break;
            case 2:
                $result['value'] = $this->moneyGift();
                $result['type'] = 2;
                $result['name'] = 'money';
                break;
            case 3:
                $result['value'] = $this->pointsGift();
                $result['type'] = 3;
                $result['name'] = 'points';
                break;
        }
        echo json_encode($result);
    }

    private function subjectGift()
    {
        $subjectsArray = $this->model->subjectsArray();
        return $subjectsArray[random_int(0, count($subjectsArray) - 1)]['name'];
    }

    private function moneyGift()
    {
        $subjectsArray = $this->model->moneyArray();
        return random_int($subjectsArray['min'], $subjectsArray['max']);
    }

    private function pointsGift()
    {
        $subjectsArray = $this->model->pointsArray();
        return random_int($subjectsArray['min'], $subjectsArray['max']);
    }


}
















