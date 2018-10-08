<?php
class Controller_Index extends Controller
{
		function __construct()
	{
		$this->model = new Model_Index();
		$this->view = new View();
	}
	function action_index()
	{
        $data['points'] = $this->model->getPoints();
		$this->view->generate('index_view.php', 'main_view.php',$data);
	}
	
}