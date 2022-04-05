<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3-RafaFerri';
include($path . "/Conf/conf.php");
include($path . "/middleware_auth.php");

 class ShopPage {
    function select_all_shop($limit) {
        
        $sql ="SELECT c.id id,c.brand_car brand_car,c.model_car model_car,c.price price,c.kilometres kilometres,c.img img,f.bodywork,cd.lat,cd.long,cd.ciudad
        FROM cars c 
        INNER JOIN filter_bodywork f ON c.bodywork = f.id
        INNER JOIN ciudades cd ON c.city = cd.id
        ORDER BY count DESC,c.brand_car ASC LIMIT $limit,5";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $result;
    }
    function update_count($data) {
        $sql = "UPDATE cars SET count=count+1 WHERE id=$data";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        if ($result) {
            $result=true;
        } else {
            $result=false;
        }
        return $result;
        
    }
    function counter() {
        $sql = "SELECT * FROM cars";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        $result=mysqli_num_rows($result);
        mysqli_close();
        return $result;
    }
    
    function more_relation($brand) {
       
        $sql = "SELECT id,img FROM cars WHERE brand_car ='$brand'";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        $array = array();
        while ( $row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }
        mysqli_close();
        return $array;
    }
    function select_filtered_shop($filters,$limit) {
        
        $sql_siltered = array();

        if ($filters["marca"]) {
            $value = $filters["marca"];
            array_push($sql_siltered,"brand_car='$value'");

        }
        if ($filters["modelo"]) {
            $value = $filters["modelo"];
            array_push($sql_siltered," model_car='$value'");
        }
        if ($filters["kilometros"]) {
            if ($filters["kilometros"] == 4) {
                $km_1 = 90000;
                array_push($sql_siltered," kilometres >=".$km_1);
                
            } else {
                if ($filters["kilometros"] == 1) {
                    $km_1 = 0;
                    $km_2 = 4999; 
                } else if ($filters["kilometros"] == 2) {
                    $km_1 = 5000;
                    $km_2 = 29999;
                } else if ($filters["kilometros"] == 3) {
                    $km_1 = 30000;
                    $km_2 = 89999;
                } 
                array_push($sql_siltered," kilometres BETWEEN ".$km_1." AND ".$km_2);   
            }
        }
        if ($filters["precio_1"] && $filters["precio_2"]) {
            
            array_push($sql_siltered," price BETWEEN ".$filters["precio_1"]." AND ".$filters["precio_2"]);
            
        } else if ($filters["precio_1"]) {
            
            array_push($sql_siltered," price >= ".$filters["precio_1"]);
            
        } else if ($filters["precio_2"]) {
            array_push($sql_siltered," price <= ".$filters["precio_2"]);
        }
        if ($filters["tipo"]) {
            array_push($sql_siltered," type=".$filters["tipo"]);
        }
        if ($filters["categoria"]) {
            array_push($sql_siltered," categories=".$filters["categoria"]);
        }   
        if ($filters["carroceria"]) {
            array_push($sql_siltered," c.bodywork=".$filters["carroceria"]);
        }
        if ($filters["ciudad"]) {
            $value = $filters["ciudad"];
            array_push($sql_siltered," cd.ciudad='$value'");
        }
        if ($filters["ordenar"]) {
            $value = $filters["ordenar"];
            if ($value == 0) {
                $order =" ORDER BY count DESC,c.brand_car ASC LIMIT $limit,5";
            } else if ($value == 1) {
                $order =" ORDER BY price DESC,c.brand_car ASC LIMIT $limit,5";

            } else if ($value == 2) {
                $order =" ORDER BY kilometres DESC,c.brand_car ASC LIMIT $limit,5";
            }
        } else {
            $order =" ORDER BY count DESC,c.brand_car ASC LIMIT $limit,5";
        }
        $sql = "SELECT c.id id,c.brand_car brand_car,c.model_car model_car,c.price price,c.kilometres kilometres,c.img img,f.bodywork,cd.lat,cd.long,cd.ciudad
        FROM cars c 
        INNER JOIN filter_bodywork f ON c.bodywork = f.id
        INNER JOIN ciudades cd ON c.city = cd.id WHERE ";
         
         for ( $i=0; $i < sizeof($sql_siltered) ; $i++) {
             if ($i == sizeof($sql_siltered)-1) {
                 $sql = $sql. $sql_siltered[$i];
                } else {
                    $sql = $sql. $sql_siltered[$i] . " AND";
                }
            }
            $sql = $sql. $order;
            $result = mysqli_query($GLOBALS["conn"],$sql);
            mysqli_close();
            return $result;
    }
    function select_only_one_car($id) {
        $sql ="SELECT c.id id,c.car_plate car_plate,c.frame_number frame_number,c.brand_car brand_car,c.model_car model_car,c.CV CV,c.price price,c.kilometres kilometres,c.date date,c.color color,cc.nom categories,t.nom type,c.img img,cd.lat,cd.long,cd.ciudad,c.description description 
        FROM cars c 
        INNER JOIN categories cc ON c.categories = cc.id 
        INNER JOIN type t ON c.type = t.id 
        INNER JOIN ciudades cd ON cd.id = c.city
        WHERE c.id='$id'";

        $result = mysqli_query($GLOBALS["conn"],$sql)->fetch_object();

        mysqli_close();
        return $result;
    }
    function select_cars_images($id) {
        $sql = "SELECT id,img FROM img_cars WHERE id_car='$id'";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        $row_select = mysqli_affected_rows($GLOBALS["conn"]);

        if ($row_select < 1) {
            $array = [-1,"view/img/img_cars/dummies_not_available.jpeg"];
        } else {
            $array = array();
            while ( $row = mysqli_fetch_assoc($result)) {
                $array[] = $row;
            }
        }

        mysqli_close();
        return $array;
    }
    function load_filter($column,$table) {
        $sql = "SELECT id,$column FROM $table";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        $array = array();
        while ( $row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }
        mysqli_close();
        return $array;
    }
    function load_filter_model($id) {
        $sql = "SELECT m.id,m.model_car FROM model_cars m,brand_car b WHERE m.brand_car = b.id AND b.brand='$id'";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        $array = array();
        while ( $row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }
        mysqli_close();
        return $array;
    }
    function check_all_likes($data) {
     
        $token = $data["info_token"];

        $aut = new Middle();
        $user=$aut->decode_jwt($token);

        $sql = "SELECT car FROM `like` WHERE user='$user'";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        $array = array();
        while ( $row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }
        mysqli_close();
        return $array;
    }
    function check_like($data) {
        $id = $data["info-id"];
        $car = $data["info-color"];

        $token = $data["token"];
        
        $aut = new Middle();
        $user=$aut->decode_jwt($token);

        if ( $car == 0) {
            $sql = "INSERT INTO `like`(user,car) VALUES ('$user','$id')";
        } else if ( $car == 1) {
            $sql = "DELETE FROM `like` WHERE user='$user' AND car='$id'";
        } else {
            return "error";
        }

        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $result;
    }

}
?>