<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3-RafaFerri';
 include($path . "/home/module/DAOhome.php");
 
 if (isset($_SESSION["tiempo"])) {  
    $_SESSION["tiempo"] = time(); //Devuelve la fecha actual
}


switch($_GET['option']) {
    case 'list':
        include("home/view/home.html");
    break;
    case 'slider_home':
        try {
            $new_home = new HomePage();
            $occur=$new_home->select_brand_slider();
            
        }catch(Exception $e) {
            die("error");
        }
        $array = array();
        while ( $row = mysqli_fetch_assoc($occur)) {
            $array[] = $row;
        }
        echo json_encode($array);
       
    break;
    case 'buttons_home':
        try {
            $new_home = new HomePage();
            $occur=$new_home->select_types();
        } catch(Exception $e) {
            die("error");
        }
        $array = array();
        while ( $row = mysqli_fetch_assoc($occur)) {
            $array[] = $row;
        }
        echo json_encode($array);
    break;
    case 'categories_menu':
        try {
            $new_home = new HomePage();
            $occur=$new_home->select_categories();
        } catch(Exception $e) {
            die("error");
        }
        $array = array();
        while ( $row = mysqli_fetch_assoc($occur)) {
            $array[] = $row;
        }
        echo json_encode($array);
    break;
    default:

}
?>