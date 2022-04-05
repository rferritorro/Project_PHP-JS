<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3-RafaFerri';
include($path . "/Conf/conf.php");
class DAOsearch {
    
    function type_select() {
        $array = array();
        $sql ="SELECT id,nom FROM type";

        $result = mysqli_query($GLOBALS["conn"],$sql);
        while ( $row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }
        mysqli_close();
        return $array;
    }
    function brand_select($data) {
        if ($data == false) {

            $sql ="SELECT id,brand FROM brand_car";
        } else {
            $sql ="SELECT DISTINCT brand_car brand FROM cars WHERE type = $data;";
        }
        $result = mysqli_query($GLOBALS["conn"],$sql);
        while ( $row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }
        mysqli_close();
        return $array;
    }
    function auto_select($data) {
        $type =$data["type"];
        $brand =$data["brand"];
        $city= $data["city"];

        if ($type && $brand) {
      
            $sql ="SELECT DISTINCT c.ciudad FROM cars cc INNER JOIN ciudades c ON cc.city = c.id WHERE cc.type = '$type' AND cc.brand_car = '$brand' AND c.ciudad LIKE '$city%'";
        } else if (!$type && !$brand) {
            if ($city) {
                $sql ="SELECT DISTINCT c.ciudad FROM cars cc INNER JOIN ciudades c ON cc.city = c.id WHERE c.ciudad LIKE '$city%'";
            } else {
                $sql ="SELECT DISTINCT id,ciudad FROM ciudades";
            }
         }

        if (!$type && $brand ) {

            $sql ="SELECT DISTINCT c.ciudad FROM cars cc INNER JOIN ciudades c ON cc.city = c.id WHERE cc.brand_car = '$brand' AND c.ciudad LIKE '$city%'";

        } else if (!$brand && $type) {

            $sql ="SELECT DISTINCT c.ciudad FROM cars cc INNER JOIN ciudades c ON cc.city = c.id WHERE cc.type = '$type' AND c.ciudad LIKE '$city%'";

        }
       
        $result = mysqli_query($GLOBALS["conn"],$sql);
        while ( $row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }
        mysqli_close();
        return $array;
    }

}
?>