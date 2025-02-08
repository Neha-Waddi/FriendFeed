<?php
session_start();
include("header.php");

if (!isset($_SESSION['user_email'])) {
    header("location: way.php");
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $get_post = "SELECT * FROM posts WHERE post_id='$post_id'";
    $run_post = mysqli_query($connection, $get_post);
    $row_post = mysqli_fetch_array($run_post);

    $post_content = $row_post['post_content'];
    $upload_image = $row_post['upload_image'];
}

if (isset($_POST['update_post'])) {
    $updated_content = $_POST['content'];

    $update_post = "UPDATE posts SET post_content='$updated_content' WHERE post_id='$post_id'";
    $run_update = mysqli_query($connection, $update_post);

    if ($run_update) {
        echo "<script>alert('Post updated successfully!')</script>";
        echo "<script>window.open('profile.php', '_self')</script>";
    } else {
        echo "<script>alert('Error updating post!')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Edit Post</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <textarea class="form-control" name="content" rows="5"><?php echo $post_content; ?></textarea>
        </div>
        <button type="submit" name="update_post" class="btn btn-primary">Update Post</button>
    </form>
</div>
</body>
</html>