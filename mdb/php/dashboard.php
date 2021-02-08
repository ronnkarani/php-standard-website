<?php
session_start();
require './db_connect.php';
require './utils.php';

if (isset($_POST['key'])) {
    if ($_POST['key'] == "get_details") {
        try {
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // get Products
            $sql = "SELECT * FROM products";
            $products = executer($sql);
            $totalproducts = count($products);
            // get blogs or posts
            $sql = "SELECT * FROM posts";
            $posts = executer($sql);
            $totalposts = count($posts);
            // get users
            $sql = "SELECT * FROM users";
            $users = executer($sql);
            $totalusers = count($users);
            // get services
            $sql = "SELECT * FROM services";
            $services = executer($sql);
            $totalservices = count($services);
            // get comments
            $sql = "SELECT * FROM comments";
            $comments = executer($sql);
            $totalcomments = count($comments);

            $response = array(
                'products' => $totalproducts,
                'posts' => $totalposts,
                'users' => $totalusers,
                'services' => $totalservices,
                'comments' => $totalcomments,
            );

            exit(json_encode($response));



        } 
        catch (PDOException $e) {
        echo $e->getMessage();
        }
    }
}

?>