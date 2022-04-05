<?php
switch($_GET['module']) {
    case 'home':
        include("home/controller/controller_home.php");
        break;
    case 'shop':
        include("shop/controller/controller_shop.php");
        break;
    case 'controller':
        include("cars/controller/controller.php");
        break;
    case 'exception':
        include("exceptions/controller_error/controller.php");
    default;
}

?>