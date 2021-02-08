<?php
session_start();
require './db_connect.php';
require './utils.php';

if (isset($_POST['key'])) {
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($_POST['key'] == "get_services"){
            $start = $_POST['start'];
            $limit = $_POST['limit'];
            
            $sql = "SELECT * FROM services limit $start,$limit";
            $services = executer($sql);
            if(count($services)>0){
                $response ='';
                foreach ($services as $service) {
                    $serviceid = $service['id'];
                    $sql = "SELECT * FROM images WHERE serviceid = $serviceid";
                    $images = executer($sql);
                    $image = $images[0]['url'];
                    $response .= '
                    <tr id="row-'.$serviceid.'">
                    <td><img src="../../img/services/'.$image.'" class="avatar"></td>
                    <td>'.$service['name'].'</td>
                    <td>'.$service['status'].'</td>
                    <td>'.$service['created_at'].'</td>
                    <td class="text-center d-flex justify-content-between">
                    <a href="#editModal" data-serviceid="'.$serviceid.'" 
                    onclick="Services.editService('.$serviceid.')"
                    class="edit" title="Edit" data-toggle="modal"><i class="fas fa-pen"></i></a>
                    <a href="#deleteModal" class="delete" title="Delete" onclick="Services.deleteService('.$serviceid.')" data-toggle="modal"><i class="fas fa-trash"></i></a>
                    </td>

                    </tr>
                    ';
                }
                exit($response);
            }else{
                exit('no_more');
            }
        }elseif($_POST['key'] == "add_service"){
            $name = $_POST['service-name'];
            $status = $_POST['status'];
            $description = $_POST['description'];
            $image = $_FILES['service-image']['name'];
            $tmp = $_FILES['service-image']['tmp_name'];

            $sql = "SELECT * FROM services WHERE `name` = '$name'";
            $services = executer($sql);
            if(count($services)>0){

                exit('name_exist');
            }else{
                $sql = "INSERT INTO services (`name`, `description`, `status`) VALUES ('$name', '$description', '$status')";
                if(noResultQuery($sql)=='done'){
                    $sql = "SELECT id FROM services WHERE `name` = '$name'";
                    $services = executer($sql);
                    $serviceid = $services[0]['id'];


                    $test = explode(".", $image);
                    $extension = end($test);
                    $date   = date('l');
                    $name = rand(100, 9990).''.$date.'.'.$extension;
                    $location = '../../img/services/' . $name;
                    move_uploaded_file($tmp, $location);

                    $sql = "INSERT INTO images (`url`, purpose, serviceid) VALUES ('$name', 'service', '$serviceid')";
                    if(noResultQuery($sql)=='done'){

                        exit('service_added');
                        }else{
                            exit('failed');
                        }
                    
                }else{
                    exit('failed');
                }
            }

        }

        elseif($_POST['key']== "get_service_details"){
            $serviceid = $_POST['serviceid'];
            $sql = "SELECT * FROM services WHERE id = $serviceid";
            $services = executer($sql);
            if(count($services)>0){
                $service = $services[0];
                // get image
                $sql = "SELECT url FROM images WHERE serviceid = $serviceid";
                $images = executer($sql);
                $image = $images[0]['url'];
                $response = array(
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'status' => $service['status'],
                    'image' => $image,
                );
                exit(json_encode( $response));
            }else{
                exit('not_found');
            }
        }
        elseif($_POST['key']== "edit_service"){
            $serviceid = $_POST['serviceid'];
            $name = $_POST['service-name'];
            $status = $_POST['status'];
            $description = $_POST['description'];
            $image = $_FILES['service-image']['name'];
            $tmp = $_FILES['service-image']['tmp_name'];
            // exit($serviceid);
            
            $sql = "SELECT * FROM `services` WHERE `name` = '$name' AND `id` !=$serviceid";
            $services = executer($sql);
            if(count($services)>0){
                exit('name_exist');
            }
            else{
                $sql = "UPDATE `services` SET `name` = '$name', `status` = '$status', `description` = '$description' WHERE id = '$serviceid'";
                if(noResultQuery($sql) == "done"){
                    if($image != null){

                        $sql = "SELECT * FROM images WHERE serviceid='$serviceid'";
                        $images = executer($sql);
                        $image1 = $images[0]['url'];
                        
    
                        $test = explode(".", $image);
                        $extension = end($test);
                        $date   = date('l');
                        $name = rand(100, 9990).''.$date.'.'.$extension;
                        $location = '../../img/services/'.$name;
                        move_uploaded_file($tmp, $location);
    
                        $sql = "UPDATE images set `url` = '$name' WHERE `serviceid` = '$serviceid'";
                        $result = noResultQuery($sql);
                        unlink('../../img/services/'.$image1);

                        exit('service_updated');
                        
                    }else{

                        exit('service_updated');
                    }

                }else{
                    exit("failed");
                }
            }
        }elseif ($_POST['key'] == "delete_service") {
            $serviceid = $_POST['serviceid'];
            
                $sql = "SELECT * FROM images WHERE serviceid='$serviceid'";
                $images = executer($sql);
                $image = $images[0]['url'];
                unlink('../../img/services/'.$image);
                $sql = "DELETE FROM services WHERE `id`='$serviceid'";
            $result = noResultQuery($sql);
                exit('service_deleted');
           
        }
    } 
    catch (PDOException $e) {
    echo $e->getMessage();
    }
}