<?php
session_start();
require('../admin/inc/db_config.php');
require('../admin/inc/essen.php');

if (isset($_POST['register'])) {
    $data = filteration($_POST);

    if ($data['pass'] != $data['cpass']) {
        echo 'pass_mismatch';
        exit;
    }

    $u_exist = select("SELECT * FROM `user_cred` WHERE `email` = ? OR `phonenum` = ? LIMIT 1", [$data['email'], $data['phonenum']], "ss");

    if (mysqli_num_rows($u_exist) != 0) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(16));  // Generating a random token
    $query = "INSERT INTO `user_cred`(`name`, `surname`, `email`, `phonenum`, `address`, `dob`, `country`, `password`, `token`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $values = [$data['name'], $data['surname'], $data['email'], $data['phonenum'], $data['address'], $data['dob'], $data['country'], $enc_pass, $token];

    if (insert($query, $values, 'sssssssss')) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['login'])) {
    $data = filteration($_POST);
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`= ? OR `phonenum`= ? LIMIT 1",
     [$data['email_mob'], $data['email_mob']], "ss");

    if (mysqli_num_rows($u_exist) == 0) {
        echo 'inv_email_mob';
        exit;
    }
    else{
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if($u_fetch['is_verified']==0){
            echo 'not_verified';
        }
        else if($u_fetch['status']==0){
            echo 'inactive';
        } 
        else{
                if(!password_verify($data['pass'],$u_fetch['password'])){

                    echo 'invalid_pass';

                }else{
                    session_start();
                    $_SESSION['login']=true;
                    $_SESSION['uId']=$u_fetch['id'];
                    $_SESSION['uName']=$u_fetch['name'];
                    $_SESSION['uPhone']=$u_fetch['phonenum'];
                    echo 1;
                    
                    
                    
                    

                }

            }
        }
    }
    

?>
