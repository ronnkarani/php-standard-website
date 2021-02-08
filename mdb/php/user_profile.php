<?php
session_start();
require './db_connect.php';
require './utils.php';

if (isset($_POST['key'])) {
    if ($_POST['key'] == "get_details") {
        $userid = $_POST['userid'];
        try {
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT users.username,users.firstname, users.lastname,users.about, users.mobile, users.website, users.email FROM users WHERE users.id = $userid";
            $users = executer($sql);
            if(count($users) > 0){
                $user = $users[0];
                $details = array(
                    'username'=> $user['username'],
                    'firstname'=> $user['firstname'],
                    'lastname'=> $user['lastname'],
                    'mobile'=> $user['mobile'],
                    'website'=> $user['website'],
                    'about'=> $user['about'],
                    'email'=> $user['email'],
                );

                // get profile pic
                $sql = "SELECT * FROM images WHERE userid = $userid";
                $images= executer($sql);
                if(count($images) > 0){
                    $image = $images[0]['url'];
                }else{
                    $image = null;
                }

                // get social links
                $sql = "SELECT * FROM socialnetwork WHERE userid = $userid";
                $sociallinks = executer($sql);
                if (count($sociallinks) > 0) {
                    $social = array(
                        'facebook' => $sociallinks[0]['facebook'],
                        'twitter' => $sociallinks[0]['twitter'],
                        'instagram' => $sociallinks[0]['instagram'],
                        'youtube' => $sociallinks[0]['youtube'],
                        'googleplus' => $sociallinks[0]['googleplus'],
                    );
                }
                else{
                    $social = null;
                }

                $response = array(
                    'details' =>$details,
                    'image' => $image,
                    'social' => $social,
                );
                exit(json_encode($response));
                
            }
            } 
            catch (PDOException $e) {
            echo $e->getMessage();
            }
    } elseif ($_POST['key'] == "change_password") {
        $userid = $_POST['userid'];
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];

        try {
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $oldPasswordEnc = md5($oldPassword);
            $sql = "SELECT * FROM users WHERE id = $userid AND password = '$oldPasswordEnc'";
            $users = executer($sql);
            if(count($users)>0){
                $newPasswordEnc = md5($newPassword);
                if($newPasswordEnc == $oldPasswordEnc){
                    exit("same");
                }else{

                    $sql = "UPDATE users SET password = '$newPasswordEnc' WHERE id = $userid";
                    if(noResultQuery($sql) == 'done'){
                        exit('password_updated');
                    }
                }
            }else{
                exit('wrong_password');
            }

            } 
            catch (PDOException $e) {
            echo $e->getMessage();
            }
    }elseif ($_POST['key'] == "update_details") {
        $userid = $_POST['userid'];
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $website = $_POST['website'];
        $about = $_POST['about'];
        $mobile = $_POST['mobile'];


        try {
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql ="SELECT * FROM users WHERE username = '$username' AND id != $userid";
            $users = executer($sql);
            if(count($users)>0){
                exit('username_exist');
            }else{
                $sql = "UPDATE users SET username = '$username'";
                if($firstname !=  null){
                    $sql .= ", firstname = '$firstname'";
                }
                if($lastname !=  null){
                    $sql .= ", lastname = '$lastname'";
                }
                if($website !=  null){
                    $sql .= ", website = '$website'";
                }
                if($about !=  null){
                    $sql .= ", about = '$about'";
                }
                if($mobile !=  null){
                    $sql .= ", mobile = '$mobile'";
                }
                $sql .= " WHERE id = $userid";
                if(noResultQuery($sql) == 'done'){
                    exit('details_updated');
                }else{
                    exit('error');
                }
            }
            
        } 
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }elseif ($_POST['key'] == "update_social") {
        $userid = $_POST['userid'];
        $facebook = $_POST['facebook'];
        $twitter = $_POST['twitter'];
        $instagram = $_POST['instagram'];
        $youtube = $_POST['youtube'];
        $googleplus = $_POST['googleplus'];

        try {
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if($facebook !=  null){
                $sql = "UPDATE socialnetwork SET facebook =  '$facebook' WHERE userid = $userid";
                $result = noResultQuery($sql);
            }
            if($twitter !=  null){
                $sql = "UPDATE socialnetwork SET twitter =  '$twitter' WHERE userid = $userid";
                $result = noResultQuery($sql);
            }
            
            if($instagram !=  null){
                $sql = "UPDATE socialnetwork SET instagram =  '$instagram' WHERE userid = $userid";
                $result = noResultQuery($sql);
            }
            if($googleplus !=  null){
                $sql = "UPDATE socialnetwork SET googleplus =  '$googleplus' WHERE userid = $userid";
                $result = noResultQuery($sql);
            }

            if($youtube !=  null){
                $sql = "UPDATE socialnetwork SET youtube =  '$youtube' WHERE userid = $userid";
                $result = noResultQuery($sql);
            }

            exit('social_updated');
        } 
        catch (PDOException $e) {
            exit( $e->getMessage());
        }

    }
    elseif ($_POST['key'] == "remove_profile") {
        $userid = $_POST['userid'];
        try {
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql ="SELECT url FROM images WHERE userid = $userid";
        $images = executer($sql);
        if(count($images)>0){
            $image = $images[0]['url'];
            if(unlink("../../img/profiles/".$image)){
                $sql = "DELETE FROM images WHERE userid = $userid";
                if(noResultQuery($sql) == "done"){
                    unset($_SESSION['profile_pic']);
                    exit("removed");
                }
            }else{
                exit("failed_delete");
            }
        }else{
            exit("no_profile");
        }
        }
        catch (PDOException $e) {
            exit( $e->getMessage());
        }
        
    }
}



if(isset($_FILES['profile-pic']['name'])){
    try {
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $userid = $_POST['userid'];
    $image = $_FILES['profile-pic']['name'];
    $tmp = $_FILES['profile-pic']['tmp_name'];

    $test = explode(".", $image);
    $extension = end($test);
    $date   = date('l');
    $name = rand(100, 9990).''.$date.'.'.$extension;
    $location = '../../img/profiles/' . $name;
    move_uploaded_file($tmp, $location);
    $sql = "SELECT * FROM images WHERE userid = $userid";
    $images = executer($sql);
    if(count($images)>0){
        
        $sql = "UPDATE images SET url = '$name' WHERE userid= $userid";
    }else{
        $sql = "INSERT INTO images (url, purpose, userid) VALUES ('$name','profile',$userid)";
    }
    if(noResultQuery($sql) == 'done'){
        unlink("../../img/profiles/".$images[0]['url']);
        $response = array('image_name' => $name);
        $_SESSION['profile_pic'] = $name;
        exit(json_encode($response));
    }else{
        exit('error');
    }
    } 
        catch (PDOException $e) {
            exit( $e->getMessage());
        }
}

