<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3-RafaFerri';
include($path . "/Conf/conf.php");
 class HomePage {
    function select_brand_slider() {
        $sql = "SELECT brand,img FROM brand_car";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $result;
    }

    function select_types() {
        $sql = "SELECT id,nom,img FROM type";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $result;
    }

    function select_categories() {
        $sql = "SELECT id,nom,img FROM categories";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $result;
    }
}
?>