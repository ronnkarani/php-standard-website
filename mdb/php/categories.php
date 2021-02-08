<?php
session_start();
require './db_connect.php';
require './utils.php';

if (isset($_POST['key'])) {
    try{
        if ($_POST['key'] == "get_categories") {
            $start = $_POST['start'];
            $limit = $_POST['limit'];

            $sql = "SELECT * FROM categories limit $start,$limit";
            $categories = executer($sql);
            if(count($categories) >0){
                $response = '';
                foreach ($categories as $category) {
                    $response .= '<tr id="row-'.$category['id'].'">
                    <td id="category-'.$category['id'].'">'.$category['name'].'</td>
                    <td>
                        <a href="#editModal" class="edit" title="edit" data-toggle="modal" 
                        data-categoryid="'.$category['id'].'"
                        data-target="#editModal"><i class="material-icons">&#xE254;</i></a>
                        <a href="#deleteModal" class="delete" 
                        onclick="Categories.deleteCategory('.$category['id'].')"
                        title="Delete" data-toggle="modal"><i class="material-icons">&#xE872;</i></a>
                    </td>
                    </tr>';
                }
                exit($response);
            }
            else{
                exit("no_more");
            }
        }
        elseif ($_POST['key'] == "update_category") {
            $categoryid = $_POST['categoryid'];
            $categoryname = $_POST['categoryname'];

            $sql = "SELECT * FROM categories WHERE name = '$categoryname'";
            $categories = executer($sql);
            if(count($categories) > 0){
                if($categories[0]['id'] != $categoryid){
                    exit('exist');
                }
            }

            $sql = "UPDATE categories SET name = '$categoryname' WHERE id = $categoryid";
            if(noResultQuery($sql) == 'done' ){
                exit('updated');
            }else{
                exit('failed');
            }
        }
        elseif ($_POST['key'] == "add_category") {
            $categoryname = $_POST['categoryname'];

            $sql = "SELECT * FROM categories WHERE name = '$categoryname'";
            $categories = executer($sql);
            if(count($categories) > 0){
                exit('exist');
            }

            $sql = "INSERT INTO categories (name) VALUES('$categoryname')";
            if(noResultQuery($sql) == 'done' ){
                exit('category_added');
            }else{
                exit('failed');
            }
        }
        elseif ($_POST['key'] == "delete_category") {
            $categoryid = $_POST['categoryid'];

            $sql = "SELECT * FROM posts WHERE category = $categoryid";
            $posts = executer($sql);
            if(count($posts) > 0){
                exit('in_use');
            }else{
                $sql = "DELETE FROM categories WHERE id = $categoryid";
                if(noResultQuery($sql) == 'done' ){
                    exit('category_deleted');
                }else{
                    exit('failed');
                }
            }

            
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
     }
}