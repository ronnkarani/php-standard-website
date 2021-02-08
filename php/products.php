<?php
session_start();
require '../mdb/php/db_connect.php';
require '../mdb/php/utils.php';

if (isset($_POST['key'])) {
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($_POST['key'] == "get_products"){
            $sql = "SELECT products.name, products.description, images.url FROM products INNER JOIN images ON products.id = images.productid WHERE products.status = 'visible'";
            $products = executer($sql);
            if(count($products)>0){
                $response = '';
                foreach ($products as $product ) {
                    $response .= '
                    <div class="col-lg-4">
                        <div class="ts-item set-bg" data-setbg="./img/products/'.$product['url'].'">
                            <div class="ts_text">
                                <h4>'.$product['name'].'</h4>
                                <span>'.$product['description'].'</span>

                            </div>
                        </div>
                    </div>
                    ';
                }
                $res = array('products'=>$response);
                exit(json_encode($res));
            }
            else{
                exit('no_products');
            }
        }

    } catch (PDOException $e) {
    echo $e->getMessage();
    }
}
        