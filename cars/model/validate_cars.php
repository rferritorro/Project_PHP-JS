<?php
    function validate_car_plate($data) {
        if (!$GLOBALS["conn"]) {
            die("Connection failed:" .mysqli_connect_error());
        }
        $sql="SELECT * FROM cars WHERE car_plate='$data'";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        $row_select = mysqli_affected_rows($GLOBALS["conn"]);
       
        if ($row_select == 0) {
            $result = true;
        } else {
            $result=false;
        }
        mysqli_close();
        return $result;
    }
    function validate_frame_number($data) {
        if (!$GLOBALS["conn"]) {
            die("Connection failed:" .mysqli_connect_error());
        }
        $sql="SELECT * FROM cars WHERE frame_number='$data'";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        $row_select = mysqli_affected_rows($GLOBALS["conn"]);
        if ($row_select == 0) {
            $result = true;
        } else {
            $result=false;
        }
        mysqli_close();
        return $result; 
    }
    function validate() {
        $check=true;
        $v_car_plate=validate_car_plate($_POST['car_plate']);
        $v_frame_number=validate_frame_number($_POST['frame_number']);

        if(!$v_car_plate){
            print_r("<script>toastr.error('Esta matricula ya esta registrada')</script>");
            $check=false;
        }
        if(!$v_frame_number){
            print_r("<script>toastr.error('Este número de bastidor ya esta registrado')</script>");
            $check=false;
        }
        return $check;
    }
?>