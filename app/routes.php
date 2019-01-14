<?php
	 /* ----------------------------------------------------------------
		Module # 	Routes
		Author # 	Avinash Patil
		Date   # 	13-Jan-2018
		Usage  #	This module handles all the routes of WALL App.
					It properly redirects requests based on HTTP headers.
		----------------------------------------------------------------- */

	header("Access-Control-Allow-Orgin: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

	require './api/user.php';
	require './api/wall.php';
    require './dbo/database.php';

    try{
		$controller = isset($_GET['container'])?$_GET['container']:'';
		$method = isset($_GET['method'])?$_GET['method']:'';

		if(strlen($method) == 0)
		{
			$controller = $method;
		}

		if(trim($controller) == 'users')
		{

				if($_SERVER["REQUEST_METHOD"] == 'GET')
				{
					if($method == 'read')
					{
						$user = new UserController();
						$user->getUser();
					}
					else if($method == 'guest')
					{
						$user = new UserController();
						$user->timeline();
					} 
					else if($method == 'logout'){
						$user = new UserController();
						$user->logout();
					}
				} else if($_SERVER["REQUEST_METHOD"] == 'POST')
					{
						if($method == 'signup')
						{
							$user = new UserController();
							$user->signup();

						}else if($method == 'auth'){

							$user = new UserController();
							$user->auth();
						}
				} else {
					 http_response_code(405);
				}

		} else if(trim($controller) == 'wall')
		{

			if($_SERVER["REQUEST_METHOD"] == 'GET')
			{
				if($method == 'timeline')
				{
					$wall = new WallController();
					$wall->timeline();
				}

			} else if($_SERVER["REQUEST_METHOD"] == 'POST')
			{
				if($method == 'save'){
					$wall = new WallController();
					$wall->save();
				}
			} else {
				http_response_code(405);
			}

		} else {
			http_response_code(405);
		}



	}catch (Exception $e) {
        echo json_encode(Array('error' => $e->getMessage()));
    }