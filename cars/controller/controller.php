<?php
 $path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3';
 include($path . "/cars/model/DAOUCars.php");
 include($path . "/exceptions/model/DAO_error.php");

if (!isset($_GET['option'])) {
    $_GET['option'] = 'list';
}
switch($_GET['option']) {
    case 'create':
        if ($_GET["back"] ==1 ) {
            $callback = "index.php?module=controller&option=list";
            die('<script>window.location.href="'.$callback .'";</script>');    
            }

        include("cars/model/validate_cars.php");
        if ($_POST) {
            $check=validate();
            if($check) {
                try {
                    $car = new Cars();
                    $ocurrs = $car->create_car($_POST);
                } catch (Exception $e) {
                    $error = new error_car();
                    $error->send_error(0,0);
                    $callback = "index.php?module=exception&option=503";
                    
                    die('<script>window.location.href="'.$callback .'";</script>');    
                }
            if ($ocurrs) {
                $callback = "index.php?module=controller&option=list&create=1";
                die('<script>window.location.href="'.$callback .'";</script>');  
            } else {

                $error = new error_car();
                $error->send_error(0,1);
                $callback = "index.php?module=exception&option=503";
                die('<script>window.location.href="'.$callback .'";</script>');    
            }
            }

        }
        include("cars/view/create_car.php");
    break;
    case 'list':
    try{
        $car = new Cars();
            $ocurrs = $car->select_all_cars();
    } catch (Exception $e) {
        $error = new error_car();
         $error->send_error(1,0);
        $callback = "index.php?module=exception&option=503";
        die('<script>window.location.href="'.$callback .'";</script>');    
    }
    if (!$ocurrs) {
        $error = new error_car();
         $error->send_error(1,1);
        $callback = "index.php?module=exception&option=503";
        die('<script>window.location.href="'.$callback .'";</script>');    
    } else {
        include("cars/view/list_car.php");
    }
    break;
    case 'update':
       if ($_POST) {
       
        try {
            $car = new Cars();
            $ocurrs = $car->update_car($_POST);
        } catch (Exception $e) {
            $error = new error_car();
             $error->send_error(2,0);
            $callback = "index.php?module=exception&option=503";
            die('<script>window.location.href="'.$callback .'";</script>');    
        }
        if ($ocurrs) {
            $callback = "index.php?module=controller&option=list&create=2";
            die('<script>window.location.href="'.$callback .'";</script>');  
        } else {
            $error = new error_car();
             $error->send_error(2,1);
            $callback = "index.php?module=exception&option=503";
            die('<script>window.location.href="'.$callback .'";</script>');    
        }
        

       } else {
        try {
            $car = new Cars();
            $ocurr=$car->select_only_one_car($_GET['id']);
            $ocurr=get_object_vars($ocurr);
        } catch (Exception $e) {
            $error = new error_car();
             $error->send_error(2,2);
            $callback = "index.php?module=exception&option=503";
            die('<script>window.location.href="'.$callback .'";</script>');
        }
        include("cars/view/update_car.php");
    }
    break;
    case 'read':

    try {
        $car = new Cars();
        $ocurr=$car->select_only_one_car($_GET['id']);
    } catch (Exception $e) {
        // Aqui se enviarán los errores a otra tabla para almacenarse;
        $error = new error_car();
         $error->send_error(3,0);
        $callback = "index.php?module=exception&option=503";
        die('<script>window.location.href="'.$callback .'";</script>');
    }
        if (empty($ocurr)) {
            $error = new error_car();
             $error->send_error(3,1);
            $callback = "index.php?module=exception&option=503";
            die('<script>window.location.href="'.$callback .'";</script>');
        } else {
            $ocurr=get_object_vars($ocurr);
            include("cars/view/read_car.php");
        }
    break;
    case 'delete':
        if ($_GET['id']==-1) {
            $callback = "index.php?module=controller&option=list";
            die('<script>window.location.href="'.$callback .'";</script>');
        }
        if (!$_POST) {
            $car = new Cars();
            $prev=$car->search_car_plate($_GET['id']);
            $prev=get_object_vars($prev);

            include("cars/view/delete.php");
        
        } else {
            
            try{
            $car = new Cars();
            $ocurr=$car->delete_car($_GET['id']);
            }
            catch (Exception $e) {
                $error = new error_car();
                 $error->send_error(4,0);
                $callback = "index.php?module=exception&option=503";
                die('<script>window.location.href="'.$callback .'";</script>');
            }
            if ($ocurr) {
                $callback = "index.php?module=controller&option=list";
                die('<script>window.location.href="'.$callback .'";</script>');            
            } else {
                $error = new error_car();
                $error->send_error(4,1);
                $callback = "index.php?module=exception&option=503";
                die('<script>window.location.href="'.$callback .'";</script>');            
            }
        }
        break;
    case 'dummies':
        if ($_POST) {
            try{
                $car = new Cars();
                $delete_complet=$car->delete_all_cars();
            } catch (Exception $e) {
                $callback = "index.php?module=exception&option=503";
                die('<script>window.location.href="'.$callback .'";</script>');
            }
            $data = array();

            foreach ($_POST as $name => $value) {
                $data[]=$name;
            }
            $result = $car->search_car($data);
            unset($data);
            for ($i=0; $i < sizeof($result) ; $i++) {
                foreach ($result[$i] as $key ) {
                    $data[] = $key["id"];
                }
            }
          
            $result = $car->create_dummies($data);
            
            if ($result == 1) {
                $callback = "index.php?module=home";
                die('<script>window.location.href="'.$callback .'";</script>'); 
            } else {
                $callback = "index.php?module=exception&option=503";
                die('<script>window.location.href="'.$callback .'";</script>');  
            }
        } else {
            $callback = "index.php?module=home&error=1";
            die('<script>window.location.href="'.$callback .'";</script>');         
        }
 
        break;
        case 'read_modal':
            try {
                $car = new Cars();
                $ocurr=$car->select_only_one_car($_GET['id']);
            } catch (Exception $e) {
                // Aqui se enviarán los errores a otra tabla para almacenarse;
                $error = new error_car();
                 $error->send_error(3,0);
                $callback = "index.php?module=exception&option=503";
                die('<script>window.location.href="'.$callback .'";</script>');
            }
                if (empty($ocurr)) {
                    $error = new error_car();
                     $error->send_error(3,1);
                    $callback = "index.php?module=exception&option=503";
                    die('<script>window.location.href="'.$callback .'";</script>');
                } else {
                    $ocurr=get_object_vars($ocurr);
                    echo json_encode($ocurr);
                }
            break;
        default;
        $callback = "index.php?module=exception&option=404";
        die('<script>window.location.href="'.$callback .'";</script>'); 
   
        }


?>