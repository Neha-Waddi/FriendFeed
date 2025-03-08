<?php
session_start();
include("connection.php");
include("header.php");


if (!isset($_SESSION['user_email'])) {
    header("location: way.php");
    exit();
}

$user_email = $_SESSION['user_email'];
$get_user = mysqli_query($connection, "SELECT * FROM users WHERE user_email='$user_email'");
$row = mysqli_fetch_array($get_user);
$logged_in_user_id = $row['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Messages</h2>
    
    <div class="row">
        <div class="col-md-4">
            <h4>Chats</h4>
            <ul class="list-group">
                <?php
                $get_users = mysqli_query($connection, "
                    SELECT DISTINCT users.user_id, users.user_name, users.user_image 
                    FROM users 
                    INNER JOIN messages 
                    ON users.user_id = messages.sender_id OR users.user_id = messages.receiver_id
                    WHERE (messages.sender_id = '$logged_in_user_id' OR messages.receiver_id = '$logged_in_user_id')
                    AND users.user_id != '$logged_in_user_id'
                ");

                while ($user = mysqli_fetch_array($get_users)) {
                    $user_id = $user['user_id'];
                    $user_name = $user['user_name'];
                    $user_image = $user['user_image'];

                    echo "
                    <li class='list-group-item'>
                        <a href='messages.php?u_id=$user_id'>
                            <img src='images/$user_image' width='40' class='img-circle'> 
                            $user_name
                        </a>
                    </li>";
                }
                ?>
            </ul>
        </div>
        <div class="col-md-8">
            <?php
            if (isset($_GET['u_id'])) {
                $receiver_id = mysqli_real_escape_string($connection, $_GET['u_id']);
                $get_receiver = mysqli_query($connection, "SELECT * FROM users WHERE user_id='$receiver_id'");
                if ($receiver = mysqli_fetch_array($get_receiver)) {
                    echo "<h4>Chat with " . $receiver['user_name'] . "</h4>";
                }
                $get_messages = mysqli_query($connection, "
                   SELECT * FROM messages 
                   WHERE (sender_id='$logged_in_user_id' AND receiver_id='$receiver_id') 
                   OR (sender_id='$receiver_id' AND receiver_id='$logged_in_user_id') 
                   ORDER BY timestamp ASC
                ");


                echo "<div class='chat-box'>";
                    if (mysqli_num_rows($get_messages) > 0) {
                       while ($msg = mysqli_fetch_array($get_messages)) {
                            $sender = ($msg['sender_id'] == $logged_in_user_id) ? "You" : $receiver['user_name'];
                            $align_class = ($msg['sender_id'] == $logged_in_user_id) ? "text-right" : "text-left";
        
                            echo "<p class='$align_class'><b>$sender:</b> " . $msg['message_content'] . " <i>(" . $msg['timestamp'] . ")</i></p>";
                        }
                    } else {
                echo "<p>No messages yet.</p>";
                    }
                echo "</div>";
                echo "
                <form method='POST'>
                    <textarea name='message' class='form-control' placeholder='Type a message'></textarea>
                    <button type='submit' name='send' class='btn btn-primary'>Send</button>
                </form>";
                if (isset($_POST['send'])) {
                    $message = mysqli_real_escape_string($connection, $_POST['message']);
                    if (!empty($message)) {
                        $insert_msg = mysqli_query($connection, "
                            INSERT INTO messages (sender_id, receiver_id, message_content) 
                            VALUES ('$logged_in_user_id', '$receiver_id', '$message')
                        ");
                        if ($insert_msg) {
                            echo "<script>window.location.href='messages.php?u_id=$receiver_id';</script>";
                        }
                    }
                }
            } else {
                echo "<h4>Select a chat to start messaging.</h4>";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
