<?php
    /* ------------------------------------------------------------
        Module #    UserController [ Authentication System ]
        Author #    Avinash Patil
        Date   #    11-Jan-2018
        Usage  #    This module handles user authentication activities 
                    such as sign in, sign out, user registration etc 
                    & fetches timeline data.
        ------------------------------------------------------------*/

	if(session_id() == '') {
        session_start();
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require "./mail.php";
    //require '../dbo/database.php';

    class UserController{

    	private $conn;

        public function __construct(){

        }

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
        // POST - http://localhost:8888/app/api/users/signup
        public function signup(){
            try
            {
                $postBody = file_get_contents("php://input");
                $postBody = json_decode($postBody);

                $username = $postBody->username;
                $email =    $postBody->email;
                $password = $postBody->password;

                $password = password_hash($password,PASSWORD_DEFAULT);

                $db = new Database();

                $user = $db->query('SELECT count(*) count FROM Users 
                            WHERE email=:email', array(':email'=>$email));

                if ($user[0]['count']== "1")
                {
                    echo '{"status": "MSG105", "message": "User already exists."}';
                    return;
                }

                $res = $db->query("INSERT INTO Users (username, password, email) VALUES 
                                    (:username, :password, :email)", 
                            array(  ':username'=>$username, 
                                    ':password'=>$password, 
                                    ':email'=>$email)
                            );

                if(strlen($res) == 0){
                    // Send welcome email after successful signup.
                    try{
                           $mail = new SendEmail($username, $email);
                        }catch(Exception $e){
                           echo '{"status": "MSG205", "message": "Error sending email"}';
                           return;
                        }
                    echo '{"status": "MSG104", "message": "Signup successful"}';
                    return;
                } else {
                    echo '{"status": "MSG202", "message": "Error occured while creating new user."}';
                    //echo '{"status": "Error occured while creating new user."}';
                }
            }catch(Exception $e){
                //echo json_encode(Array('error' => $e->getMessage()));
                echo '{"status": "MSG202", "message": "Error occured while creating new user."}';
            }
        }
        // POST - http://localhost:8888/app/api/users/auth
        public function auth(){
            try
            {
                $postBody = file_get_contents("php://input");

                $postBody = json_decode($postBody);

                $email = $postBody->email;
                $password = $postBody->password;

                //$password = password_hash('pass',PASSWORD_DEFAULT);

                $db = new Database();

                $user = $db->query('SELECT * FROM Users WHERE email =:email', array(':email'=>$email));

                if($user)
                {
                    // $user_password = $user[0]['password'];
                    // $user_id = $user[0]['id'];
                    if(password_verify($password, $user[0]['password']))
                    {
                        $_SESSION['user_id'] = $user[0]['id'];
                        $_SESSION['user_name'] = $user[0]['username'];

                        echo '{"status": "MSG102", "message": "Login Successful"}';
                    }
                    else{
                        echo '{"status": "MSG101", "message": "Invalid Credentials"}';
                    }
                }else{
                    echo '{"status": "MSG103", "message": "No user found. Enter valid email"}';
                    }
            }catch(Exception $e){
                echo '{"status": "MSG201", "message": "Error occured during user authencation."}';
            }
        }   // end of auth

        public function logout(){
            $_SESSION = [];
            session_unset();
            session_destroy();
            echo '{"status": "MSG106", "message": "User logged out successfully"}';
        }

    }
