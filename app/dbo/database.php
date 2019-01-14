<?php 
	 /* ------------------------------------------------------
		Module # 	Database Class
		Author # 	Avinash Patil
		Date   # 	12-Jan-2018
		Usage  #	This module creates database connections
					and excute queries & return results.
		---------------------------------------------------------*/
		require 'config/config.php';

		class Database {

			//DB Params
			// private $host = HOST;
			// private $db_name = DBNAME;
			// private $username = USERNAME;
			// private $password = PASSWORD;
			private $conn;

			public function __construct(){

				$this->conn = null;

				try{
					$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USERNAME, PASSWORD);

					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->conn = $conn;
				}
				catch(PDOException $e){
					echo 'Connection failed: ' . $e->getMessage();
        			exit;
				}
			}

	        public function query($query, $params=array())
	        {
	        	$query = trim($query);
	            $statement = $this->conn->prepare($query);

	            try{
	            	$statement->execute($params);

		            if(explode(' ', $query)[0] == 'SELECT'){
		                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
		                return $data;
		            }

	            }catch(Exception $e){
	            	return $e->getMessage();
	            }
	        }
		}

 ?>