<?php
include('connection.php');
$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$email=$_POST['email'];
$password=$_POST['password'];

$check_email=$mysqli->prepare('select email from users where email=?');
$check_email->bind_Params('s',$email);
$check_email->execute();
$check_email->store_result();
$email_exists=$check_email->num_rows();
if($email_exists==0){
    $hashed_password=password_hash($password,PASSWORD_BCRYPT);
    $query=$mysqli->prepare('insert into users(first_name,last_name,email,password) values(?,?,?,?)');
    $query->bind_param('ssss',$first_name,$last_name,$email,$hashed_password);
    $query->execute();

    $response['status']="success";
    $response['message']="sign up successful";
}
else{
    $response['status']="failure";
    $response['message']="sign up falied";
}
echo json_encode($response);