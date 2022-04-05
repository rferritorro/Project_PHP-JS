<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3-RafaFerri';
 include($path . "/search/module/DAOsearch.php");

 switch($_GET['option']) {
    case 'type':
        $occur = array();
        try {
            $search = new DAOsearch();
            $occur=$search->type_select();
        }catch (Exception $e) {
            echo "error";
        }
   
        echo json_encode($occur);
         
    break;
    case 'brand':
        $occur = array();
        if ($_POST["value"]) {
            $data=$_POST["value"];
            try {
                $search = new DAOsearch();
                $occur=$search->brand_select($data);
            }catch (Exception $e) {
                echo "error";
            }

        } else {
            try {
                $search = new DAOsearch();
                $occur=$search->brand_select($data=false);
            }catch (Exception $e) {
                echo "error";
            }
        }
        echo json_encode($occur);
         
    break;
    case 'autocomplete':
        $occur = array();
        try {
            $search = new DAOsearch();
            $occur=$search->auto_select($_POST);
        }catch (Exception $e) {
            echo "error";
        }
        echo json_encode($occur);
    break;
 }
 ?>