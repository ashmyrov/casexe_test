<?php
class Controller_404 extends Controller
{
	function action_index()
	{
		//$data = $this->action_main();
		$this->view->generate('404_view.php', 'main_view.php');
	}

}