<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_V.3-RafaFerri';
 include($path . "/login/module/DAOlogin.php");
 
@session_start();

 switch($_GET['option']) {
     case 'login':
        try {
            $new_register = new LoginPage();
            $occur=$new_register->login_user($_POST);
        }catch(Exception $e) {
            die("error");
        }

        $_SESSION['user'] = $_POST["user"];
		$_SESSION['tiempo'] = time();

        session_regenerate_id(true);
        echo json_encode($occur);
    break;
    case 'register':
        try {
            $new_register = new LoginPage();
            $occur=$new_register->create_validate($_POST);
        }catch(Exception $e) {
            die("error");
        }

        session_regenerate_id(true);
        echo json_encode($occur);
    break;
    case 'data_user':
        try {
            $new_register = new LoginPage();
            $occur=$new_register->data_user($_POST);
        }catch(Exception $e) {
            die("error");
        }
        echo json_encode($occur);
    break;
    case 'activity':
       
        if (!isset($_SESSION["tiempo"])) {  //Si el usuario no se ha logeado no se comprueba la session
              echo "notime";
        } else {  
            if((time() - $_SESSION["tiempo"]) >= 900) {  
                  echo "inactivo"; 

            }else{
                echo "activo";

            }
        }
        break;
       
    case 'controluser':
        $token = $_POST["token"];
        try{
            $aut = new Middle();
            $user = $aut->decode_jwt($token);
        }catch(Exception $e) {
            die('error');
        }
        if (!isset($_SESSION['user']) && $user == $_SESSION['user']){
            echo 'error';
        } 
        else {
            echo 'need_log';
        }
        break;
    case 'refresh_token':
        $token = $_POST["token"];
        $option = 1;
        try{
            $aut = new Middle();
            $exp = $aut->decode_jwt($token,$option);
        }catch(Exception $e) {
            die('error');
        }
        if ($exp) {
            $aut = new Middle();
            $token = $aut->encode_jwt($_SESSION['user']);
            echo $token;
        } else {
            echo "logout";
        }
        break;
    case 'refresh_cookie':
        $token = $_POST["token"];
        $option = 1;
        try{
            $aut = new Middle();
            $exp = $aut->decode_jwt($token);
        }catch(Exception $e) {
            die('error');
        }
    
        if ($_SESSION['user'] && $_SESSION['tiempo']) {
            session_regenerate_id(true);
            echo "refresh";
            exit;
        }
        echo "morefresh";
        break;
    case 'logout':

        setcookie("PHPSESSID","",time()-3600,"/");
        session_destroy();
        echo "Out";
        break;
    default:
        include("exceptions/view/404.php");
        break;
}
?>