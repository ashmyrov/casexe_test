<?php

/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route
{

	static function start()
	{

        if(!Route::checklogin()){
            $controller_name = 'Login';
        }else {

            // контроллер и действие по умолчанию
            $controller_name = 'Index';

        }
            $id = false;
            // получаем имя контроллера
            if (!empty($_GET['route'])) {
                $controller_name = $_GET['route'];
            }

            // получаем id
            if (!empty($_GET['id'])) {
                $id = $_GET['id'];
            }

            // получаем имя экшена
            if (isset($_GET['route']) && ($_GET['route'] == 'ajax' && !empty($_GET['action']))) {
                $action = $_GET['action'];
            } else {
                $action = 'index';
            }




		// добавляем префиксы
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		
		/*echo "Model: $model_name <br>";
		echo "Controller: $controller_name <br>";
		echo "id: $id <br>";*/
		
		// подцепляем файл с классом модели (файла модели может и не быть)
		$model_file = strtolower($model_name).'.php';
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path))
		{
			include "application/models/".$model_file;
		}
        else
        {
            /*
            правильно было бы кинуть здесь исключение,
            но для упрощения сразу сделаем редирект на страницу 404
            */
            Route::ErrorPage404();
        }

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include "application/controllers/".$controller_file;
		}
		else
		{
			/*
			правильно было бы кинуть здесь исключение,
			но для упрощения сразу сделаем редирект на страницу 404
			*/
			Route::ErrorPage404();
		}
		
		// создаем контроллер
		$controller = new $controller_name();
		$controller->id = $id;
		$method='action_'.$action;
		if(method_exists($controller, $method))
		{
			// вызываем действие контроллера
			$controller->$method();
		}
		else
		{
			// здесь также разумнее было бы кинуть исключение
			Route::ErrorPage404();
		}
	
	}

    static function ErrorPage404()
	{

        $host = 'http://'.$_SERVER['HTTP_HOST'].'/casexe_test/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
    }

    static function checklogin(){
	    if(isset($_SESSION['logined'])){
	        return true;
        }else{
            return false;
        }

    }

    
}
