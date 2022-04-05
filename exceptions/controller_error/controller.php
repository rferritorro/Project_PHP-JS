<?php
switch($_GET['option']) {
    case '503':
        include("exceptions/view/503.php");
        break;
    case '404':
        include("exceptions/view/404.php");
        break;
    default;
}

?>