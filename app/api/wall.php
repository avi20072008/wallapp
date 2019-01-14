<?php
    /* ------------------------------------------------------------
        Module #    WallController
        Author #    Avinash Patil
        Date   #    11-Jan-2018
        Usage  #    This module shows the messages from all the users 
                    on a site-wide timeline.
        ------------------------------------------------------------*/

	if(session_id() == '') {
        session_start();
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    class WallController{

        //GET - http://localhost:8888/app/api/users/timeline
        public function timeline(){

            try{
                $db = new Database();
                $data = $db->query('SELECT u.username username, t.* 
                                    FROM Users u, timeline t
                                    WHERE u.id = t.user_id ORDER BY created_at DESC');

                echo json_encode($data);
            }catch(Exception $e){
                //echo json_encode(Array('error' => $e->getMessage()));
                echo '{"status": "MSG203", "message": "Error occured while fetching timeline data."}';
            }

        }

        // POST - http://localhost:8888/app/api/users/save
        public function save(){
            try{
                if(isset($_SESSION['user_id']))
                {
                    $user_id = $_SESSION['user_id'];
                } else {
                    echo '{"error": "User is not logged in. Please log in first."}';
                    return;
                }

                $postBody = file_get_contents("php://input");
                $postBody = json_decode($postBody);
                $data = $postBody->comment;

                $data = htmlspecialchars(strip_tags($data));
                $user_id = $_SESSION['user_id'];

                $db = new Database();

                $res = $db->query('INSERT INTO timeline (user_id, comment) 
                            VALUES (:user_id, :comment)', 
                            array(":user_id"=>$user_id, "comment"=>$data));

                if(strlen($res)==0)
                {

                    echo '{"status": "MSG107", "message": "Your comment posted on timeline."}';
                } else{
                    echo '{"status": "MSG205", "message": "Error occured posting comments"}';
                }

            }catch(Exception $e){
                //echo json_encode(Array('error' => $e->getMessage()));
                echo '{"status": "MSG205", "message": "Error occured posting comments"}';
            }
        }

        // GET - http://localhost:8888/app/api/users/read
        public function getUser(){
            
            if(isset($_SESSION['user_id']))
            {
                try 
                {
                    $logged_user = $_SESSION['user_id'];
                    $db = new Database();
                    $res = $db->query('SELECT id, username, email FROM Users WHERE id =:id', array(':id'=>$logged_user));

                    print_r(json_encode($res));
                }catch(Exception $e){
                    //echo json_encode(Array('error' => $e->getMessage()));
                    echo '{"status": "MSG204", "message": "Error occured fetching user data."}';
                }
            }
        }

    } // end of WallController Class.
