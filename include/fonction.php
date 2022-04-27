<?php
function connect_db(){
$server_name= "localhost";
$user_name="root";
$db_password = "";
$db_name = "ionic-php-crud";
$conn = mysqli_connect($server_name,$user_name, $db_password, $db_name);
if (!$conn) {
	return null;
}
else {
    return $conn;}
}

function error_code($code){
    switch($code){
        case 0 : return "fill all fields"; break;
        case 1 : return "User not found"; break;
        case 2 : return "User already signed in";break;
        case 3 : return "password not confirmed";break;
        default : return "unknown error";
    }
}
 ?>