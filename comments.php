<?php
$con = mysqli_connect("localhost", "root", "", "social_network", 3307) or die("Connection was not established");

if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
    $post_id = (int)$_GET['post_id']; 

    $post_query = "SELECT * FROM posts WHERE post_id = ?";
    $stmt_post = mysqli_prepare($con, $post_query);
    mysqli_stmt_bind_param($stmt_post, "i", $post_id);
    mysqli_stmt_execute($stmt_post);
    $post_result = mysqli_stmt_get_result($stmt_post);

    if (mysqli_num_rows($post_result) > 0) {
        $post_row = mysqli_fetch_assoc($post_result);
        $post_content = htmlspecialchars($post_row['post_content']);
        $post_date = $post_row['pos_date'];
        $post_user_id = $post_row['user_id'];

        $user_query = "SELECT * FROM users WHERE user_id = ?";
        $stmt_user = mysqli_prepare($con, $user_query);
        mysqli_stmt_bind_param($stmt_user, "i", $post_user_id);
        mysqli_stmt_execute($stmt_user);
        $user_result = mysqli_stmt_get_result($stmt_user);
        $user_row = mysqli_fetch_assoc($user_result);

        $post_author_name = htmlspecialchars($user_row['user_name']);
        $post_author_image = htmlspecialchars($user_row['user_image']);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Comments</title>
            <link rel="stylesheet" href="comments.css">
        </head>
        <body>
            <div class='post'>
                <h2>Post Details</h2>
                <div class='post-author'>
                    <img src='images/<?php echo $post_author_image; ?>' class='img-circle' width='50px' height='50px'>
                    <div>
                        <h3><?php echo $post_author_name; ?></h3>
                        <p><small>Posted on: <?php echo $post_date; ?></small></p>
                    </div>
                </div>
                <div class='post-content'>
                    <p><?php echo $post_content; ?></p>
                </div>
            </div>
        <?php

        $comments_query = "SELECT * FROM comments WHERE post_id = ? ORDER BY comment_date DESC";
        $stmt_comments = mysqli_prepare($con, $comments_query);
        mysqli_stmt_bind_param($stmt_comments, "i", $post_id);
        mysqli_stmt_execute($stmt_comments);
        $comments_result = mysqli_stmt_get_result($stmt_comments);

        if (mysqli_num_rows($comments_result) > 0) {
            echo "<h3>Comments:</h3>";
            while ($comment_row = mysqli_fetch_assoc($comments_result)) {
                $comment_user_id = $comment_row['user_id'];
                $comment_content = htmlspecialchars($comment_row['comment_content']);
                $comment_date = $comment_row['comment_date'];

                $commenter_query = "SELECT * FROM users WHERE user_id = ?";
                $stmt_commenter = mysqli_prepare($con, $commenter_query);
                mysqli_stmt_bind_param($stmt_commenter, "i", $comment_user_id);
                mysqli_stmt_execute($stmt_commenter);
                $commenter_result = mysqli_stmt_get_result($stmt_commenter);
                $commenter_row = mysqli_fetch_assoc($commenter_result);

                $commenter_name = htmlspecialchars($commenter_row['user_name']);
                $commenter_image = htmlspecialchars($commenter_row['user_image']);
                ?>
                <div class='comment'>
                    <div class='comment-author'>
                        <img src='images/<?php echo $commenter_image; ?>' class='img-circle' width='40px' height='40px'>
                        <div>
                            <h4><?php echo $commenter_name; ?></h4>
                            <p><small>Commented on: <?php echo $comment_date; ?></small></p>
                        </div>
                    </div>
                    <div class='comment-content'>
                        <p><?php echo $comment_content; ?></p>
                    </div>
                </div>
                <hr>
                <?php
            }
        } else {
            echo "<p>No comments found for this post.</p>";
        }
    } else {
        echo "<p>Post not found.</p>";
    }
} else {
    echo "<p>Invalid post ID.</p>";
}
mysqli_close($con);
?>
</body>
</html>
