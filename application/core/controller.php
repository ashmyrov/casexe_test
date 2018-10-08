<?php
class Controller {
	
	public $id;
	
	function __construct()
	{
		$this->model = new Model();
		$this->view = new View();
	}


}