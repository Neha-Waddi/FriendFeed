<!DOCTYPE html>
<?php
session_start();
include("header.php");

if(!isset($_SESSION['user_email'])){
    header("location: way.php");
}
?>
<html>
<head>
    <?php
        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email='$user'";
        $run_user = mysqli_query($connection,$get_user);
        $row = mysqli_fetch_array($run_user);

        $user_name = $row['user_name'];
    ?>
    <title><?php echo "$user_name"; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/home_style.css">
    <style>
        #cover-img {
            height: 350px;
            width: 100%;
            object-fit: cover;
        }
        #profile-img {
            position: absolute;
            top: 100px;
            left: 40px;
        }
        #profile-img img {
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        #update_profile {
            position: relative;
            top: -33px;
            cursor: pointer;
            left: 93px;
            border-radius: 4px;
            background-color: rgba(0,0,0,0.1);
            transform: translate(-50%, -50%);
        }
        #button_profile {
            position: absolute;
            top: 82%;
            left: 50%;
            cursor: pointer;
            transform: translate(-50%, -50%);
        }
        .profile-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-info h2 {
            margin-bottom: 20px;
        }
        .profile-info p {
            margin-bottom: 10px;
        }
        .post-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .post-container img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .post-container h3 {
            margin-top: 0;
        }
        .post-container h4 {
            color: #666;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div>
                <img id="cover-img" class="img-rounded" src="cover/<?php echo $user_cover; ?>" alt="cover">
                <form action="profile.php?u_id=<?php echo $user_id; ?>" method="post" enctype="multipart/form-data">
                    <ul class="nav pull-left" style="position:absolute;top:10px;left:40px;">
                        <li class="dropdown">
                            <button class="dropdown-toggle btn btn-default" data-toggle="dropdown">Change Cover</button>
                            <div class="dropdown-menu">
                                <center>
                                    <p>Click <strong>Select Cover</strong> and then click the <br> <strong>Update Cover</strong></p>
                                    <label class="btn btn-info"> Select Cover
                                        <input type="file" name="u_cover" size="60" />
                                    </label><br><br>
                                    <button name="submit" class="btn btn-info">Update Cover</button>
                                </center>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
            <div id="profile-img">
                <img src="images/<?php echo $user_image; ?>" alt="Profile" class="img-circle" width="180px" height="185px">
                <form action="profile.php?u_id=<?php echo $user_id; ?>" method="post" enctype="multipart/form-data">
                    <label id="update_profile"> Select Profile
                        <input type="file" name="u_image" size="60" />
                    </label><br><br>
                    <button id="button_profile" name="update" class="btn btn-info">Update Profile</button>
                </form>
            </div><br>
        </div>
        <div class="col-sm-2"></div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-2 profile-info">
            <?php
            echo "
                <center><h2><strong>About</strong></h2></center>
                <center><h4><strong>$first_name $last_name</strong></h4></center>
                <p><strong><i style='color:grey;'>$describe_user</i></strong></p><br>
                <p><strong>Relationship Status: </strong> $Relationship_status</p><br>
                <p><strong>Lives In: </strong> $user_country</p><br>
                <p><strong>Member Since: </strong> $register_date</p><br>
                <p><strong>Gender: </strong> $user_gender</p><br>
                <p><strong>Date of Birth: </strong> $user_birthday</p><br>
            ";
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            global $con;

            if (isset($_GET['u_id'])) {
                $u_id = $_GET['u_id']; 
            } else {
                $u_id = $_SESSION['user_id']; 
            }

            $get_posts = "SELECT * FROM posts WHERE user_id='$u_id' ORDER BY post_id DESC LIMIT 5";
            $run_posts = mysqli_query($con, $get_posts);

            while ($row_posts = mysqli_fetch_array($run_posts)) {
                $post_id = $row_posts['post_id'];
                $user_id = $row_posts['user_id'];
                $content = $row_posts['post_content'];
                $upload_image = $row_posts['upload_image'];
                $upload_date = $row_posts['pos_date'];

                $user = "SELECT * FROM users WHERE user_id='$user_id'";
                $run_user = mysqli_query($con, $user);
                $row_user = mysqli_fetch_array($run_user);

                $user_name = $row_user['user_name'];
                $user_image = $row_user['user_image'];

                echo "
<div class='post-container'>
    <div class='row'>
        <div class='col-sm-2'>
            <p><img src='images/$user_image' class='img-circle' width='100px' height='100px'></p>
        </div>
        <div class='col-sm-6'>
            <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
            <h4><small style='color:black;'>Updated a post on <strong>$upload_date</strong></small></h4>
        </div>
        <div class='col-sm-4'>
            <!-- Delete and Edit Buttons -->
            <a href='delete_post.php?post_id=$post_id' class='btn btn-danger'>Delete</a>
            <a href='edit_post.php?post_id=$post_id' class='btn btn-primary'>Edit</a>
        </div>
    </div>";

if ($content == "NO" && !empty($upload_image)) {
    echo "<img src='imagepost/$upload_image' class='img-responsive' style='width:50%;'>";
} else {
    echo "<p>$content</p>";
    echo "<img src='imagepost/$upload_image' class='img-responsive' style='width:50%;'>";
}

echo "</div><hr>";
            }
            ?>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
</body>
</html>