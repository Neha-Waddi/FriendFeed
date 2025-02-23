<?php
session_start();
include("connection.php");

if(isset($_POST['signin'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $select_user = "SELECT * FROM users WHERE user_email='$email' AND user_pass='$pass' AND status='verified'";
    $query = mysqli_query($connection, $select_user);
    $check_user = mysqli_num_rows($query);

    if($check_user == 1){
        $row = mysqli_fetch_assoc($query); 
        $_SESSION['user_email'] = $email;
        $_SESSION['user_id'] = $row['user_id']; 

        echo "<script>window.open('home.php','_self')</script>";
    } else {
        echo "<script>alert('Invalid Email or Password')</script>";
    }
}
?>
