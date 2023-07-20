<?php
include('connection.php');

$email = $_POST['email'];
$password = $_POST['password'];

$query = $mysqli->prepare('select id,first_name,last_name,email,password from users 
where email=?');
$query->bind_param('s', $email);
$query->execute();

$query->store_result();
$query->bind_result($id, $first_namae,$last_name,$email,$hashed_password);
$query->fetch();

$num_rows = $query->num_rows();
if ($num_rows == 0) {
    $response['status'] = "user not found";
} else {
    if (password_verify($password, $hashed_password)) {
        $response['status'] = 'logged in';
        $response['user_id'] = $id;
        $response['first_name'] = $first_name;
        $response['last_name'] = $last_name;
    } else {
        $response['status'] = "wrong password";
    }
}
echo json_encode($response);
