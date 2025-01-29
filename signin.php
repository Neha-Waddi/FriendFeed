<?php
  session_start();
  include("connection.php");

  
  if(isset($_POST['signin'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    echo $email;
    $select_user = "SELECT * FROM users WHERE user_email='$email' AND user_pass='$pass' AND status='verified'";
    $query=mysqli_query($connection,$select_user);
    $check_user=mysqli_num_rows($query);
    if($check_user==1){
        $_SESSION['user_email']=$email;
        echo "<script>window.open('home.html','_self')</script>";

  }
  else{
    echo "<script>alert('Invalid Email or Password')</script>";
  }
  }
?>