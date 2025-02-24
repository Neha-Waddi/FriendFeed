<!DOCTYPE html>
<?php
session_start();
include("header.php");
include("connection.php");
include("search_user.php");

if (!isset($_SESSION['user_email'])) {
    header("location: way.php");
    exit();
}

$user = $_SESSION['user_email'];
$get_user = "SELECT * FROM users WHERE user_email='$user'";
$run_user = mysqli_query($connection, $get_user);
$row = mysqli_fetch_array($run_user);
$user_name = $row['user_name'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find People</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="style/home_style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row text-center">
            <h2>Find New People</h2>
        </div>

        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <form class="search_form" action="" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search Friend" name="search_user">
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="submit" name="search_user_btn">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>

        <br><br>
        <div class="row">
            <div class="col-sm-12">
                <?php search_user(); ?>
            </div>
        </div>
    </div>
</body>
</html>
