<?php
session_start();
require '../mdb/php/db_connect.php';
require '../mdb/php/utils.php';

if (isset($_POST['key'])) {
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($_POST['key'] == "get_services"){
            $sql = "SELECT services.name, services.description, images.url FROM services INNER JOIN images ON services.id = images.serviceid WHERE services.status = 'visible'";
            $services = executer($sql);
            if(count($services)>0){
                $response = '';
                foreach ($services as $service ) {
                    $response .= '
                    <div class="col-md-6 card bg-transparent text-white">
                <h3 class="card-header">'.$service['name'].'</h3>
                <div class="row card-body">
                    <div class="col-lg-6">
                        <img src="../img/services/'.$service['url'].'" alt="" class="img-fluid">
                    </div>
                    <div class="col-lg-6">
                        <p>'.$service['description'].'</p>
                    </div>
                </div>
            </div>
                    ';
                }
                $res = array('services'=>$response);
                exit(json_encode($res));
            }
            else{
                exit('no_services');
            }
        }

    } catch (PDOException $e) {
    echo $e->getMessage();
    }
}
        