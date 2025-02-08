<?php
session_start();
include("header.php");

if (!isset($_SESSION['user_email'])) {
    header("location: way.php");
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $delete_post = "DELETE FROM posts WHERE post_id='$post_id'";
    $run_delete = mysqli_query($connection, $delete_post);

    if ($run_delete) {
        echo "<script>alert('Post deleted successfully!')</script>";
        echo "<script>window.open('profile.php', '_self')</script>";
    } else {
        echo "<script>alert('Error deleting post!')</script>";
    }
}
?>