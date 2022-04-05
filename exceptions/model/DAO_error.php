<?php
 $path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3-RafaFerri';
 include($path . "/Conf/conf.php");
// if (isset($_SESSION['type'])) {
//     include("../../Conf/conf.php");
// } else {

//     include("Conf/conf.php");
// }

class error_car {
    function read_error() {
        $sql= "SELECT time,description FROM error_cars ORDER BY time DESC";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        $total_rows = mysqli_affected_rows($GLOBALS["conn"]);
       
        mysqli_close();
    return $result;
}
    function send_error($type,$option) {
        if ($type == 0) {
            if ($option == 0) {
                $error = "Ha habido un error al enviar los datos para crear";    
            } else if ( $option == 1) {
                $error = "Ha habido un error al crear el vehiculo";    
            }
        } else if ($type == 1 ) {
            if ($option == 0) {
                $error = "Ha habido un error al enviar los datos para listar el vehículo";    
            } else if ( $option == 1) {
                $error = "Ha habido un error al listar el vehiculo";    
            }        
        } else if ($type == 2 ) {
            if ($option == 0) {
                $error = "Ha habido al enviar los datos para actualizar";    
            } else if ( $option == 1) {
                $error = "Ha habido un error al actualizar el vehiculo";    
            } else if ( $option == 2) {
                $error = "Ha habido un error al cargar los datos del vehiculo";    

            }  
        } else if ($type == 3 ) {
            if ($option == 0) {
                $error = "Ha habido al enviar los datos para leer lo";    
            } else if ( $option == 1) {
                $error = "Ha habido un error al leer el vehiculo";    
            }   
        } else if ($type == 4 ) {
            if ($option == 0) {
                $error = "Ha habido al enviar los datos para eliminar lo";    
            } else if ( $option == 1) {
                $error = "Ha habido un error al eliminar el vehiculo";    
            }        
            } 
        $time = date("Y-m-d H:i:s");
        $sql = "INSERT INTO error_cars (description,time) VALUES ('$error','$time')";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();

        return $result;
    }
} 