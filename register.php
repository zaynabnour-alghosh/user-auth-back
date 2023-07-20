<?php
include('connection.php');


$email = $_POST['email'];

$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

$check_email = $mysqli->prepare('select email from users where email=?');
$check_email->bind_param('s', $email);
$check_email->execute();
$check_eamil->store_result();
$email_exists = $check_email->num_rows();

if ($email_exists == 0) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = $mysqli->prepare('insert into users(first_name,last_name,email,password) values(?,?,?,?)');
    $query->bind_param('ssss', $first_name, $last_name,$email,$hashed_password);
    $query->execute();

    $response['status'] = "success";
    $response['message'] = "another message in success";
} else {
    $response['status'] = "failed";
    $response['message'] = "another message in fail";
}

// types of http request : POST,GET,PUT,DELETE 
echo json_encode($response);
