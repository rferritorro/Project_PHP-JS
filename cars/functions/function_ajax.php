<?php
    session_start();
if ($_POST['type'] == 0) {
    $_SESSION['type'] = 0;
    $_SESSION['brand'] = $_POST['brand'];
   


    if ($_POST['brand']) { 
        try {
            $car = new Cars();
            $ocurr=$car->select_model($_POST['brand']);
            $data = array();
            foreach ($ocurr as $row) {
                $data[]=$row["model_car"];
            }
        } catch (Exception $e) {
            $callback = "index.php?module=503";
            die('<script>window.location.href="'.$callback .'";</script>');
        }

        if (empty($ocurr)) {
            $callback = "index.php?module=503";
            die('<script>window.location.href="'.$callback .'";</script>');
        } else {
            echo json_encode($data);
        }
    }
} else if ($_POST['type'] == 1) {
    $_SESSION['type'] = 1;
    include "../../exceptions/model/DAO_error.php";

    $error = new error_car();
    $ocurr = $error->read_error();
    $data = array();
  
    foreach ($ocurr as $key ) {
        $data[] = [$key["time"],$key["description"]];
    }
    echo json_encode($data);

} else if ($_POST['type'] == 2) {
    include "../model/DAOUCars.php";
    try {
        $car = new Cars();
        $ocurr=$car->charge_dummies();
    } catch(Exception $e) {
        $callback = "index.php?module=503";
        die('<script>window.location.href="'.$callback .'";</script>');
    }
    $data = array();
  
    foreach ($ocurr as $key ) {
        $data[] = [$key["brand"],$key["img"]];
    }
    echo json_encode($data);
}
?>