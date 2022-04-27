<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT,GET,POST,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Origin,Content-Type,Authorization,Accept,X-Requested-With,x-xsrf-token');
header('Content-Type: application/json;charset=utf-8');

include './include/fonction.php';
$obj = json_decode(file_get_contents('php://input'), true);
     
        $tel_user=$obj['tel_user'];
        $password_user=$obj['password_user'];
        $confirmpassword_user=$obj['confirmpassword_user'];
        $fname_user= $obj['fname_user'];
        $lname_user=$obj['lname_user'];
        $date_birth_user=$obj['date_birth_user'];
        $sex_user=$obj['sex_user'];
        $location_user=$obj['location_user'];
        $email_user=$obj['email_user'];
        $conn=connect_db();
        $data=array();
        
 
if(empty($tel_user) || empty($password_user)){
    if(empty($confirmpassword_user)){
        echo json_encode(array(
            'result' => false,
            'error_code'=> error_code(0)
        ));

    } 
   
}
else{
    $conn = connect_db();
    $tel_user = stripslashes($tel_user);
    $password_user = stripslashes($password_user);
    $confirmpassword_user = stripslashes($confirmpassword_user);
    $tel_user = mysqli_real_escape_string($conn,$tel_user);
    $password_user = mysqli_real_escape_string($conn,$password_user);
    $password_user = hash('SHA512', $password_user) ; 
    $confirmpassword_user = mysqli_real_escape_string($conn,$confirmpassword_user);
    $confirmpassword_user = hash('SHA512', $confirmpassword_user) ; 
    $fname_user= stripslashes($fname_user);
    $lname_user = stripslashes($lname_user);
    $sex_user = stripslashes($sex_user);
    $date_birth_user = stripslashes($date_birth_user);
    $email_user = stripslashes($email_user);
    $location_user = stripslashes($location_user);
    $sql = "SELECT * FROM member WHERE tel_member='$tel_user'";
    $result1 = mysqli_query($conn,$sql);
    $data = array();

    if(mysqli_num_rows($result1)>0){
        echo json_encode(array(
            'result'=>false,
            'error code' => "bl"

        ));}
    
    else{
            
    if($password_user==$confirmpassword_user){
     
       $query1 ="INSERT INTO user (fname_user,lname_user,sex_user,date_birth_user,location_user,email_user,tel_user,verify_user) VALUES(
        '$fname_user',
       '$lname_user',
       '$sex_user',
       '$date_birth_user',
       '$location_user',
       '$email_user',
       '$tel_user',
       '1'
       )"; 
        // 
        if($conn->query($query1)){
            $id_user_new= $conn->insert_id;
            $query2 ="INSERT INTO member (tel_member , password_member , id_user) VALUES('$tel_user','$password_user','$id_user_new')"; 
            if($conn->query($query2)){
                echo json_encode(array(
                    'result'=>true        
                ));
            }
            else{
                echo json_encode(array(
                    'result'=>false,
                    'error code' => "drd"
                ));
            }
            }
            else{
                echo json_encode(array(
                    'result'=>false,
                    'error code' => "lpl"
        
                ));
            }
        
       
        }
        else{
            echo json_encode(array(
                'result'=>false,
                'error code' => error_code(1)
    
            ));
        }
  
   } 
        }
    


?>