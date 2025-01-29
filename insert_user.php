<?php
 include("connection.php");

 if(isset($_POST['sign-up'])){
    $fname=$_POST['first-name'];
    $lname=$_POST['last-name'];
    $pass=$_POST['password'];
    $email=$_POST['email'];
    $country=$_POST['country'];
    $gender=$_POST['gender'];
    $bday=$_POST['dob'];
    $status="verified";
    $posts="no";
    $newgid=sprintf('%05d',rand(0,999999));

    $username=strtolower($fname."_".$lname."_".$newgid);
    $check_username_query="select user_name from users where user_email='$email'";
    $run_username=mysqli_query($connection,$check_username_query);

    if(strlen($pass)<8){
        echo "<script>alert('Password must be at least 8 characters long')</script>";
        exit();
    }
    $check_email="select * from users where user_email='$email'";
    $run_email=mysqli_query($connection,$check_email);
    if(mysqli_num_rows($run_email)==1)
    {
        echo "<script>alert('Email already exists , please try using another email')</script>";
        echo "<script>window.open('signup.html','_self')</script>";
        exit();
    }
    $rand=rand(1,3);
    if($rand==1)
    $profile_pic="bfly.png";
    elseif($rand==2)
    $profile_pic="puppy.png";
    else
    $profile_pic="teddy.png";

    $insert="INSERT into users (f_name,l_name,user_name,describe_user,Relationship,user_pass,user_email,
    user_country,user_gender,user_birthday,user_image,user_cover,user_reg_data,status,posts,recovery_account)
    values ('$fname','$lname','$username','Hello FriendFeed.This is my default status!','....','$pass','$email','$country','$gender','$bday','$profile_pic','default_cover.jpg',Now(),'$status','$posts','I want to put a ding in universe.')";

    $query=mysqli_query($connection,$insert);

    if($query){
        echo "<script>alert('Yay! Welcome $first_name,you are good to go.')</script>";
        echo "<script>window.open('signup.html','_self')</script>";
    }
    else{
        echo "<script>alert('Registration Falied,please try again')</script>";
        echo "<script>window.open('signup.html','_self')</script>";
        
    }
}
 
?>