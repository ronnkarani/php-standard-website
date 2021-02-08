<?php
session_start();
require './db_connect.php';
require './utils.php';

if (isset($_POST['key'])) {
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($_POST['key'] == "get_products"){
            $start = $_POST['start'];
            $limit = $_POST['limit'];
            
            $sql = "SELECT * FROM products limit $start,$limit";
            $products = executer($sql);
            if(count($products)>0){
                $response ='';
                foreach ($products as $product) {
                    $productid = $product['id'];
                    $sql = "SELECT * FROM images WHERE productid = $productid";
                    $images = executer($sql);
                    $image = $images[0]['url'];
                    $response .= '
                    <tr id="row-'.$productid.'">
                    <td><img src="../../img/products/'.$image.'" class="avatar"></td>
                    <td>'.$product['name'].'</td>
                    <td>'.$product['status'].'</td>
                    <td>'.$product['created_at'].'</td>
                    <td class="text-center d-flex justify-content-between">
                    <a href="#editModal" data-productid="'.$productid.'" 
                    onclick="Products.editProduct('.$productid.')"
                    class="edit" title="Edit" data-toggle="modal"><i class="fas fa-pen"></i></a>
                    <a href="#deleteModal" class="delete" title="Delete" onclick="Products.deleteProduct('.$productid.')" data-toggle="modal"><i class="fas fa-trash"></i></a>
                    </td>

                    </tr>
                    ';
                }
                exit($response);
            }else{
                exit('no_more');
            }
        }elseif($_POST['key'] == "add_product"){
            $name = $_POST['product-name'];
            $status = $_POST['status'];
            $description = $_POST['description'];
            $image = $_FILES['product-image']['name'];
            $tmp = $_FILES['product-image']['tmp_name'];

            $sql = "SELECT * FROM products WHERE `name` = '$name'";
            $products = executer($sql);
            if(count($products)>0){

                exit('name_exist');
            }else{
                $sql = "INSERT INTO products (`name`, `description`, `status`) VALUES ('$name', '$description', '$status')";
                if(noResultQuery($sql)=='done'){
                    $sql = "SELECT id FROM products WHERE `name` = '$name'";
                    $products = executer($sql);
                    $productid = $products[0]['id'];


                    $test = explode(".", $image);
                    $extension = end($test);
                    $date   = date('l');
                    $name = rand(100, 9990).''.$date.'.'.$extension;
                    $location = '../../img/products/' . $name;
                    move_uploaded_file($tmp, $location);

                    $sql = "INSERT INTO images (`url`, purpose, productid) VALUES ('$name', 'product', '$productid')";
                    if(noResultQuery($sql)=='done'){

                        exit('product_added');
                        }else{
                            exit('failed');
                        }
                    
                }else{
                    exit('failed');
                }
            }

        }elseif ($_POST['key'] == "delete_product") {
            $productid = $_POST['productid'];
            
                $sql = "SELECT * FROM images WHERE productid='$productid'";
                $images = executer($sql);
                $image = $images[0]['url'];
                unlink('../../img/products/'.$image);
                $sql = "DELETE FROM products WHERE `id`='$productid'";
            $result = noResultQuery($sql);
                exit('product_deleted');
           
        }elseif($_POST['key']== "get_product_details"){
            $productid = $_POST['productid'];
            $sql = "SELECT * FROM products WHERE id = $productid";
            $products = executer($sql);
            if(count($products)>0){
                $product = $products[0];
                // get image
                $sql = "SELECT url FROM images WHERE productid = $productid";
                $images = executer($sql);
                $image = $images[0]['url'];
                $response = array(
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'status' => $product['status'],
                    'image' => $image,
                );
                exit(json_encode( $response));
            }else{
                exit('not_found');
            }
        }elseif($_POST['key']== "edit_product"){
            $productid = $_POST['productid'];
            $name = $_POST['product-name'];
            $status = $_POST['status'];
            $description = $_POST['description'];
            $image = $_FILES['product-image']['name'];
            $tmp = $_FILES['product-image']['tmp_name'];
            // exit($productid);
            
            $sql = "SELECT * FROM `products` WHERE `name` = '$name' AND `id` !=$productid";
            $products = executer($sql);
            if(count($products)>0){
                exit('name_exist');
            }
            else{
                $sql = "UPDATE `products` SET `name` = '$name', `status` = '$status', `description` = '$description' WHERE id = '$productid'";
                if(noResultQuery($sql) == "done"){
                    if($image != null){

                        $sql = "SELECT * FROM images WHERE productid='$productid'";
                        $images = executer($sql);
                        $image1 = $images[0]['url'];
                        
    
                        $test = explode(".", $image);
                        $extension = end($test);
                        $date   = date('l');
                        $name = rand(100, 9990).''.$date.'.'.$extension;
                        $location = '../../img/products/'.$name;
                        move_uploaded_file($tmp, $location);
    
                        $sql = "UPDATE images set `url` = '$name' WHERE `productid` = '$productid'";
                        if(noResultQuery($sql)=='done'){
                        unlink('../../img/products/'.$image1);

                        exit('product_updated');
                        }else{
                            exit('failed');
                        }
                    }else{

                        exit('product_updated');
                    }

                }else{
                    exit("failed");
                }
            }
        }
    } 
    catch (PDOException $e) {
    echo $e->getMessage();
    }
}