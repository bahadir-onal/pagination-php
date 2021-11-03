<?php 

switch (@$_GET['tercih']) {

    case "belirle":

        setcookie("gosterlimit", $_GET['limit']);

        break;
}
?>