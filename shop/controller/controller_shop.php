<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3-RafaFerri';
 include($path . "/shop/module/DAOshop.php");
 
 if (isset($_SESSION["tiempo"])) {  
    $_SESSION["tiempo"] = time(); //Devuelve la fecha actual
}

 switch($_GET['option']) {
    case 'list':
        include("shop/view/shop.html");
        break;
    case 'all':
     
        try {
            $new_shop = new ShopPage();
            $occur=$new_shop->select_all_shop($_POST["limit"]);
        }catch (Exception $e) {
            echo "error";
        }
        $array = array();
        while ( $row = mysqli_fetch_assoc($occur)) {
            $array[] = $row;
        }
        echo json_encode($array);
    break;
    case 'update_count':
        try {
            $new_shop = new ShopPage();
            $occur=$new_shop->update_count($_POST["update"]);
        }catch (Exception $e) {
            echo "error";
        }
        echo json_decode($occur);
    break;
    case 'count':
        try {
            $new_shop = new ShopPage();
            $occur=$new_shop->counter();
        }catch (Exception $e) {
            echo "error";
        }
        echo $occur;
    break;
    case 'relation_car':
        try {
            $new_shop = new ShopPage();
            $occur=$new_shop->more_relation($_POST["brand"]);
        }catch (Exception $e) {
            echo "error";
        }
        echo json_encode($occur);
        break;
    case 'filtered_out':
        try {
            $new_shop = new ShopPage();
            $occur=$new_shop->select_filtered_shop($_GET,$_POST["limit"]);
        }catch (Exception $e) {
            echo "error";
        }
        $array = array();
        while ( $row = mysqli_fetch_assoc($occur)) {
            $array[] = $row;
        }
         echo json_encode($array);
    break;
    case 'one_car':
        $occur = array();
        try {
            $new_shop = new ShopPage();
            $occur[0]=$new_shop->select_only_one_car($_GET['data']);
            
        } catch(Exception $e) {
            echo "error";
        }
        try {
            $occur[1]=$new_shop->select_cars_images($_GET['data']);
        } catch(Exception $e) {
            echo "error";
        }
        $occur[0]=get_object_vars($occur[0]);
       
        echo json_encode($occur);
    break;
    case 'filter_model':
        $occur = array();
            try {
                $new_shop = new ShopPage();
                $occur=$new_shop->load_filter_model($_GET["brand"]);
            
            } catch(Exception $e) {
                echo "error";
            }
        echo json_encode($occur);
    break;
    case 'filter':
        $occur = array();
        try {
            $column = "brand";
            $table = "brand_car";
            $new_shop = new ShopPage();
            $occur[0]=$new_shop->load_filter($column,$table);
            
        } catch(Exception $e) {
            echo "error";
        }
        try {
            $column = "nom";
            $table = "type";
            $occur[1]=$new_shop->load_filter($column,$table);
            
        } catch(Exception $e) {
            echo "error";
        }
        try {
            $column = "nom";
            $table = "categories";
            $occur[2]=$new_shop->load_filter($column,$table);
            
        } catch(Exception $e) {
            echo "error";
        }
        try {
            $column = "bodywork";
            $table = "filter_bodywork";
            $occur[3]=$new_shop->load_filter($column,$table);
            
        } catch(Exception $e) {
            echo "error";
        }
        echo json_encode($occur);
    break;
    case 'check_like':
        try {
            $new_shop = new ShopPage();
            $occur= $new_shop->check_like($_POST);
        }catch(Exception $e) {
            die("error");
        }
        if ($occur) {
            $occur = "cambio en la tabla";
        } else {
            $occur = "Error";
        }
        echo json_encode($occur);
    break;
    case 'charge_all_likes':
        try {
            $new_shop = new ShopPage();
            $occur= $new_shop->check_all_likes($_POST);
        }catch(Exception $e) {
            die("error");
        }
       
        echo json_encode($occur);
    break;
    default;
    }
    
 ?>