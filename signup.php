<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT,GET,POST,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Origin,Content-Type,Authorization,Accept,X-Requested-With,x-xsrf-token');
header('Content-Type: application/json;charset=utf-8');

include './include/fonction.php';
$obj = 
        $conn=connect_db();
        $data=array();
        
 
if(empty($fname_user) || empty($lname_user)){
    if(empty($date_birth_user)|| empty($sex_user)){
        if(empty($email_user)||empty($location_user)){
            echo json_encode(array(
                'result' => false,
                'error_code'=> error_code(0)
            ));
    
        }
    }
   
   
}
else{
    $conn = connect_db();
  
    $sql = "SELECT * FROM user WHERE fname_user='$fname_user' AND lname_user='$lname_user'";
    $result1 = mysqli_query($conn,$sql);
    $data = array();
    if(mysqli_num_rows($result1)>0){
        echo json_encode(array(
            'result'=>false,
            'error code' => error_code(1)

        ));}
        else{
            
        $query ="INSERT INTO user (fname_user,lname_user,sex_user,location_user,date_birth_user,email_user) VALUES(
       '$fname_user',
       '$lname_user',
       ' $date_birth_user',
       ' $sex_user',
       ' $location_user',
       ' $email_user',
        )";
       
        $result2 = $conn->query($query) or die($conn->error.__LINE__);
        $result2 = $conn->affected_rows;
        echo  json_encode($result2);
       
    }
}    
     
   
        ?>