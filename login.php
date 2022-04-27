<?php

use LDAP\Result;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT,GET,POST,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Origin,Content-Type,Authorization,Accept,X-Requested-With,x-xsrf-token');
header('Content-Type: application/json;charset=utf-8');

include './include/fonction.php';
$obj = json_decode(file_get_contents('php://input'), true);
$tel_user= $obj['tel_user'];
$password_user= $obj['password_user'];



if(empty($tel_user) || empty($password_user)){
    
    echo json_encode(array(
      'result' => false,
      'error_code'=> error_code(0)
  ));
}
else{
    $conn = connect_db();
    $tel_user = stripslashes($tel_user);
    $password_user = stripslashes($password_user);
    $tel_user = mysqli_real_escape_string($conn,$tel_user);
    $password_user = mysqli_real_escape_string($conn,$password_user);
    $password_user = hash('SHA512', $password_user) ;
    $sql = "SELECT * FROM member WHERE tel_member='$tel_user' AND password_member='$password_user'";
    $data = array();
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        if($row = mysqli_fetch_object($result)){
            $id_user = $row->id_user;
            $sql = "SELECT * FROM `user` WHERE id_user= '$id_user'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                if($row = mysqli_fetch_object($result)){
                    $data = $row;
                    echo json_encode(array(
                        'result' => true,
                        'data' => $data
                    ));
                }
            }
            else{
                echo json_encode(array(
                    'result' => false,
                    'error_code'=> error_code(1)
                ));
            }
           
        }
    }
    else{
        echo json_encode(array(
            'result' => false,
            'error_code'=> error_code(1)
        ));
    }
}

