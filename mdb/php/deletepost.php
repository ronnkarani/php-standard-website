<?php
session_start();
require './db_connect.php';
require './utils.php';

if (isset($_POST['key'])) {
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($_POST['key'] == "delete_post"){
            $postid = $_POST['postid'];
            // delete images
            $sql = "SELECT * FROM images WHERE postid = $postid";
            $images = executer($sql);
            foreach ($images as $image) {
                unlink('../../img/posts/'.$image['url']);
                
            }
            $sql = "DELETE FROM images WHERE postid= $postid";
            noResultQuery($sql);

            // delete quotes
            $sql = "DELETE FROM postquotes WHERE postid = $postid";
            noResultQuery($sql);

            // delete the post
            $sql = "DELETE FROM posts WHERE id = $postid";
            noResultQuery($sql);

            exit('post_deleted');
        }
    }
    catch (PDOException $e) {
    echo $e->getMessage();
    }
}