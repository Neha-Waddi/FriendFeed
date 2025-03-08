<?php
session_start();
include("connection.php"); 
include("header.php");


if (!isset($_SESSION['user_email'])) {
    header("location: way.php");
    exit();
}

$user_email = $_SESSION['user_email'];
$get_user = "SELECT * FROM users WHERE user_email='$user_email'";
$run_user = mysqli_query($connection, $get_user);
$row = mysqli_fetch_array($run_user);

$logged_in_user_id = $row['user_id'];
$user_name = $row['user_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo "$user_name's Posts"; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>My Posts</h2>
    
    <?php
    $get_posts = "SELECT * FROM posts WHERE user_id='$logged_in_user_id' ORDER BY post_id DESC";
    $run_posts = mysqli_query($connection, $get_posts);

    while ($row_posts = mysqli_fetch_array($run_posts)) {
        $post_id = $row_posts['post_id'];
        $content = $row_posts['post_content'];
        $upload_image = $row_posts['upload_image'];
        $upload_date = $row_posts['pos_date'];
    ?>
        <div class='post-container'>
            <h4><small>Posted on <strong><?php echo $upload_date; ?></strong></small></h4>
            
            <?php if (!empty($upload_image)) { ?>
                <img src='imagepost/<?php echo $upload_image; ?>' class='img-responsive' style='width:50%;'>
            <?php } ?>
            
            <?php if ($content != "NO") { ?>
                <p><?php echo $content; ?></p>
            <?php } ?>
            
            <a href='delete_post.php?post_id=<?php echo $post_id; ?>' class='btn btn-danger'>Delete</a>
            <a href='edit_post.php?post_id=<?php echo $post_id; ?>' class='btn btn-primary'>Edit</a>
        </div>
        <hr>
    <?php } ?>
    
</div>
</body>
</html>
