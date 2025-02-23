<?php
session_start();

$con = mysqli_connect("localhost","root","","social_network",3307) or die("Connection was not established");



if (!isset($_SESSION['user_email'])) {
    header("location: way.php");
    exit(); 
}

if (isset($_POST['submit_comment'])) {
    $user_id = $_SESSION['user_id'];
    global $user_id;
    $post_id = $_GET['post_id'];
    $comment_content = htmlentities($_POST['comment_content']);

    if (!empty($comment_content)) {

        
        $insert_comment = "INSERT INTO comments (post_id, user_id, comment_content, comment_date) 
                           VALUES ('$post_id', '$user_id', '$comment_content', NOW())";
        $run_comment = mysqli_query($con, $insert_comment);

        if (!$run_comment) {
            die("SQL Error: " . mysqli_error($con));
        }

        if ($run_comment) {
            echo "<script>alert('Comment posted successfully!');</script>";
            echo "<script>window.open('home.php', '_self');</script>";
        } else {
            echo "<script>alert('Error posting comment!');</script>";
        }
    } else {
        echo "<script>alert('Comment cannot be empty!');</script>";
    }
}
?>
