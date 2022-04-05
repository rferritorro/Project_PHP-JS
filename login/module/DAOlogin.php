<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3-RafaFerri';
include($path . "/Conf/conf.php");
include($path . "/middleware_auth.php");

class LoginPage {
    function create_validate($data) {
        $user=$data["username"];
        $password=$data["Password"];
        $password=password_hash($password,PASSWORD_DEFAULT);
        $email=$data["email"];
        $option=$data["option"];
        $avatar = "https://robohash.org/".$user;
        
        $sql = "SELECT * FROM User WHERE username='$user' OR email='$email'";
        $result = mysqli_query($GLOBALS["conn"],$sql);
        
        
        $result=mysqli_num_rows($result);
        if ($result == 1 ) {
            return false;
        } else {
            $sql = "INSERT INTO User (username,password,email,type,avatar) VALUES ('$user','$password','$email',0,'$avatar')";
            $result = mysqli_query($GLOBALS["conn"],$sql);
            
            mysqli_close();
            $aut = new Middle();
            $token = $aut->encode_jwt($user);
            return $token;
        }
    }
    function data_user($data) {
        $token = $data["token"];

        $aut = new Middle();
        $user=$aut->decode_jwt($token);

        $sql = "SELECT id,username,avatar FROM User WHERE username='$user'";
        $result = mysqli_query($GLOBALS["conn"],$sql)->fetch_object();
        mysqli_close();
        $result = get_object_vars($result);
        return $result;
    }
    function login_user($data) {
        $user=$data["user"];
        $password=$data["password"];

        $sql = "SELECT username,password,avatar FROM User WHERE username='$user'";
        $counterline = mysqli_query($GLOBALS["conn"],$sql);
        
        $result = mysqli_query($GLOBALS["conn"],$sql)->fetch_object();
        $counterline=mysqli_num_rows($counterline);
        mysqli_close();
        
        $result = get_object_vars($result);
        
        if ($counterline != 1 ) {
            return 0;
        } else {
            if(password_verify($password,$result["password"])) {
                $aut = new Middle();
                $token = $aut->encode_jwt($user);
                return $token;
            } else {
                return 1;
            }
        }

    }
   
};
?>