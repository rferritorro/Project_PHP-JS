<?php
 $path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3';
 include($path . "/Conf/conf.php");
// if (isset($_SESSION['brand'])) {
//     include("../../Conf/conf.php");
// } else {

//     include("Conf/conf.php");
// }

class Cars {
    
    function create_car($newcar) {
        $car_plate=$newcar['car_plate'];
        $frame_number=$newcar['frame_number'];

        $car = new Cars();
        $ocurrs = $car->search_brand($newcar['brand']);
        $ocurr=get_object_vars($ocurrs);

        $brand_car= $ocurr["brand"];
        $model_car=$newcar['model'];
        $CV=$newcar['CV'];
        $price=$newcar['price'];
        $kilometres=$newcar['kilometres'];
        $date=$newcar['fecha'];
        $color=$newcar['color'];

        $categorie=$newcar['categorie'];
        
        $description=$newcar['description'];
        
        $sql = "INSERT INTO cars (car_plate,frame_number,brand_car,model_car,CV,price,kilometres,date,color,categories,description) 
        VALUES ('$car_plate','$frame_number','$brand_car','$model_car',$CV,$price,$kilometres,'$date','$color',$categorie,'$description')";
        
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $result;
    }

    function search_brand($id) {
        $sql = "SELECT brand FROM brand_car WHERE id=".$id;
        $result = mysqli_query($GLOBALS["conn"],$sql)->fetch_object();
        return $result;
    }

    function search_id($brand) {
        $sql = "SELECT id FROM brand_car WHERE brand='$brand'";
        $result = mysqli_query($GLOBALS["conn"],$sql)->fetch_object();
        return $result;
    }

    function update_car($update_car) {

        $id=$_GET['id'];

        $car = new Cars();
        $ocurrs = $car->search_brand($update_car['brand']);
        $ocurr=get_object_vars($ocurrs);

        $brand_car= $ocurr["brand"];

        $model_car=$update_car['model'];
        $CV=$update_car['CV'];
        $price=$update_car['price'];
        $kilometres=$update_car['kilometres'];
        $date=$update_car['fecha'];
        $color=$update_car['color'];
        $description=$update_car['description'];

        $sql = "UPDATE cars SET brand_car='$brand_car',model_car='$model_car',CV='$CV',price='$price',kilometres='$kilometres',date='$date',color='$color',description='$description'
                WHERE id=$id";
        
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $result;

    }
    function select_only_one_car($id) {
        if (!$GLOBALS["conn"]) {
            die("Connection failed:" .mysqli_connect_error());
        }        
     
        $sql= "SELECT * FROM cars WHERE id=$id";
        
        $result = mysqli_query($GLOBALS["conn"],$sql)->fetch_object();
        $row_select = mysqli_affected_rows($GLOBALS["conn"]);
        
        if ($row_select != 1) {
            die("Error garrafal");
        }
        mysqli_close();
        return $result;
    }
    function select_all_cars() {

        if (!$GLOBALS["conn"]) {
            die("Connection failed:" .mysqli_connect_error());
        }

        $sql= "SELECT * FROM cars";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        global $total_rows;
        $total_rows = mysqli_affected_rows($GLOBALS["conn"]);
        if ($total_rows == -1) {
            $result = "Error";
        }
        mysqli_close();
        return $result; 
    }

    function select_brand() {
        if (!$GLOBALS["conn"]) {
            die("Connection failed:" .mysqli_connect_error());
        }
        $sql= "SELECT id,brand FROM brand_car";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        return $result;
    }

    function delete_car($id) {
        if (!$GLOBALS["conn"]) {
            die("Connection failed:" .mysqli_connect_error());
        }
        $sql = "DELETE FROM cars WHERE id=$id";
        $mysql = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $mysql;
    }
    function delete_all_cars() {
        if (!$GLOBALS["conn"]) {
            die("Connection failed:" .mysqli_connect_error());
        }
        $sql = "DELETE FROM cars";
        $mysql = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $mysql;
    }
    function select_model($model) {

        if (!$GLOBALS["conn"]) {
            die($model."-Connection failed:" .mysqli_connect_error());
        }   
        
        $sql = "SELECT model_car FROM model_cars WHERE brand_car=".$model;
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();
        return $result;
    }
    function search_car($array) {
        $result=array();
        foreach ($array as $value) {
            $sql= "SELECT id FROM brand_car WHERE brand='$value'";
            $result[] = mysqli_query($GLOBALS["conn"],$sql);
        }
        mysqli_close();

        return $result;
    }
    function search_brand_2($id) {
        $sql="SELECT brand FROM brand_car WHERE id='$id'";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();

        return $result;

    }
    function search_car_plate($id) {
        $sql="SELECT car_plate FROM cars WHERE id='$id'";
        $result = mysqli_query($GLOBALS["conn"],$sql)->fetch_object();
        mysqli_close();

        return $result;
    }
    function charge_dummies() {
        $sql="SELECT brand,img FROM brand_car";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        mysqli_close();

        return $result;
    }
    function create_dummies($array) {
        $car_plate = array();
        $frame_number = array();
        $CV = array();
        $price = array();
        $kilometres = array();
        $color = array();
        $categorie = array();
        $type = array();
        $description = array();
        $date = array();
        $result = array();

        for ($i=0; $i < sizeof($array) ; $i++) {
            $sql= "SELECT brand_car,model_car FROM model_cars WHERE brand_car='$array[$i]'";
            $result[] = mysqli_query($GLOBALS["conn"],$sql);
        }
        $data= array();
        for ($i=0; $i < sizeof($result) ; $i++) {
            foreach ($result[$i] as $key ) {
                $data[] = [$key["brand_car"],$key["model_car"]];
            }
        }

        $car_plate=["V8931HD","9999XX","3423BBD","7774DFD","8787DSD","0000AAA","34654BBN","4445GG","X7676VB","9891CF"];
        $frame_number=["FDFDFDFDFD","HUHDSIFGJSGF","DKLHKSJDHSKHD","DKHGSJDSJ","DMBVASJDGH","DKJASHFKSAGD","AOFHASPFUHASF","RRRRRRRRRRRR","KBFSKJHASDFSDF","FEFDSKHFSGHFGS"];
        $CV=["100","120","140","160","180","200","220","240","260","280"];
        $price=["500","1000","1500","2000","2500","3000","3500","4000","4500","5000"];
        $date=["10/1/2020","10/2/2021","30/12/2000","12/3/2004","15/1/2010","17/4/2020","20/3/2010","30/1/2020","13/11/2000","1/1/2001"];
        $kilometres=["10000","20000","30000","40000","50000","60000","70000","80000","90000","100000"];
        $color=["#034f84","#f7786b","#ffef96","#80ced6","#50394c","#f4e1d2","#bc5a45","#80ced6","#618685","#b1cbbb"];
        $categorie=["2","1","2","1","2","1","1","2","1","1"];
        $type=["1","2","3","4","1","2","3","4","1","2"];
        $img="view/img/img_cars/dummies_not_available.jpeg";
        $description=["Amazing Car","I love this car","Its a beuatiful car","Its very old","Its horrible","Wow","Its color disgust me","I sell it because I want to buy a new car","It has all new pieces","My wife tell me or the car or me"];
    
        $check=1;
        for ($i=0; $i < 10 ; $i++) {
            $random_number = rand(0,sizeof($data)-1);
            $brand = $data[$random_number][0];
            $sql="SELECT brand FROM brand_car WHERE id='$brand'";
            $brand = mysqli_query($GLOBALS["conn"],$sql)->fetch_assoc();
            $brand = $brand["brand"];

            $model = $data[$random_number][1];

            $sql = "INSERT INTO cars (car_plate,frame_number,brand_car,model_car,CV,price,kilometres,date,color,categories,type,img,description) 
            VALUES ('$car_plate[$i]','$frame_number[$i]','$brand','$model','$CV[$i]','$price[$i]','$kilometres[$i]','$date[$i]','$color[$i]','$categorie[$i]','$type[$i]','$img','$description[$i]')";
            $result=mysqli_query($GLOBALS["conn"],$sql);
            if ($result != 1) {
                $check = -1;
                return $check;
            }
        }
        mysqli_close();
        return $check;
    }
}
?>