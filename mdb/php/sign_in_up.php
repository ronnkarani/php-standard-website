<?php
session_start();
require './db_connect.php';
if (isset($_POST['key'])) {
    if ($_POST['key'] == "signup") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        try {
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                $sql = "SELECT * FROM users WHERE username='$username'";
                $users = executer($sql);
                if (count($users) > 0) {
                    exit('username_exist');
                } else {
                    $sql = "SELECT * FROM users WHERE email='$email'";
                    $users = executer($sql);
                    if (count($users) > 0) {
                        exit('email_exist');
                    } else {
                        $encrypted_password = md5($password);

                        $sql = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$encrypted_password')";
                        if (noResultQuery($sql) == 'done') {
                            $sql = "SELECT * FROM users WHERE email='$email' AND username='$username'";
                            $users = executer($sql);
                            $userid= $users[0]['id'];
                            $sql = "INSERT INTO roles (userid, role) VALUES ($userid, 'user')";
                            if(noResultQuery($sql) == 'done'){
                                $sql = "INSERT INTO socialnetwork (userid, facebook, instagram, youtube, googleplus, twitter) VALUES ($userid, null, null, null, null, null)";
                                if(noResultQuery($sql) == 'done'){

                                    exit('created');
                                }

                            }
                        } else {
                            exit('failed');
                        }
                    }
                }
            

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else if ($_POST['key'] == "signin") {
        $password = $_POST['password'];
        $email = $_POST['email'];
        try {
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //check if user exists
            $encrypted_password = md5($password);
            $sql = "SELECT * FROM users WHERE email='$email' AND password='$encrypted_password'";
            $users = executer($sql);
            if (count($users) > 0) {
                $user = $users[0];
                if($user['status'] != 'suspended'){
                    $_SESSION['logged_in_userid'] = $user['id'];
                $_SESSION['logged_in_username'] = $user['username'];
                $userid=$user['id'];
        $sql = "SELECT * FROM roles WHERE userid = '$userid'";
                $roles = executer($sql);
                
                $_SESSION['roles'] = array();
                foreach ($roles as $role) {
                    array_push($_SESSION['roles'], $role['role']);
                }

                // get profile picture

                $sql= "SELECT * FROM images WHERE userid = $userid";
                $images = executer($sql);
                if(count($images)>0){
                    $_SESSION['profile_pic'] = $images[0]['url'];
                }

                exit('signed_in');

                }
                else{
                    exit('suspended');
                }
                

            } else {
                exit('no_such_user');
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    
}
}

function executer($sql)
{
    global $connect;
    $statement = $connect->prepare($sql);
    if ($statement->execute()) {
        $result = $statement->fetchAll();
        return $result;
    }
}

function noResultQuery($sql)
{
    global $connect;
    $statement = $connect->prepare($sql);
    if ($statement->execute()) {
        return "done";
    } else {
        return "failed";
    }
}