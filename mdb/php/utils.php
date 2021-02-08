<?php

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

function uploadProfile($productID, $image, $tmp)
{
    global $connect;
    $test = explode(".", $image);
    $extension = end($test);
    $name = rand(100, 9990) . '.' . $extension;
    $location = '../../images/' . $name;
    move_uploaded_file($tmp, $location);
    $finalName = '../images/' . $name;
    $sql = "INSERT INTO images (`name`,`productID`) VALUES('$finalName','$productID')";
    noResultQuery($sql);
}

?>