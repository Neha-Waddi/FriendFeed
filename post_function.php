<?php

$con = mysqli_connect("localhost","root","","social_network",3307) or die("Connection was not established");

function insertPost(){
	if(isset($_POST['sub'])){
		global $con;
		global $user_id;
		// $user_id=$_SESSION['user_id'];

		$content = htmlentities($_POST['content']);
		$upload_image = $_FILES['upload_image']['name'];
		$image_tmp = $_FILES['upload_image']['tmp_name'];
		$random_number = rand(1, 100);

		if(strlen($content) > 250){
			echo "<script>alert('Please Use 250 or less than 250 words!')</script>";
			echo "<script>window.open('home.php', '_self')</script>";
		}else{
			if(strlen($upload_image) >= 1 && strlen($content) >= 1){
				move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
				$insert = "insert into posts (user_id, post_content, upload_image, pos_date) values('$user_id', '$content', '$upload_image.$random_number', NOW())";

				$run = mysqli_query($con, $insert);

				if($run){
					echo "<script>alert('Your Post updated a moment ago!')</script>";
					echo "<script>window.open('home.php', '_self')</script>";

					$update = "update users set posts='yes' where user_id='$user_id'";
					$run_update = mysqli_query($con, $update);
				}

				exit();
			}else{
				if($upload_image=='' && $content == ''){
					echo "<script>alert('Error Occured while uploading!')</script>";
					echo "<script>window.open('home.php', '_self')</script>";
				}else{
					if($content==''){
						move_uploaded_file($image_tmp, "imagepost/$upload_image.$random_number");
						$insert = "insert into posts (user_id,post_content,upload_image,post_date) values ('$user_id','No','$upload_image.$random_number',NOW())";
						$run = mysqli_query($con, $insert);

						if($run){
							echo "<script>alert('Your Post updated a moment ago!')</script>";
							echo "<script>window.open('home.php', '_self')</script>";

							$update = "update users set posts='yes' where user_id='$user_id'";
							$run_update = mysqli_query($con, $update);
						}

						exit();
					}else{
						$insert = "insert into posts (user_id, post_content, post_date) values('$user_id', '$content', NOW())";
						$run = mysqli_query($con, $insert);

						if($run){
							echo "<script>alert('Your Post updated a moment ago!')</script>";
							echo "<script>window.open('home.php', '_self')</script>";

							$update = "update users set posts='yes' where user_id='$user_id'";
							$run_update = mysqli_query($con, $update);
						}
					}
				}
			}
		}
	}
}
function get_posts(){
    global $con;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page=1;
    }


    $get_posts = "select * from posts ORDER by 1 DESC ";
    $run_posts = mysqli_query($con, $get_posts);

    while($row_posts = mysqli_fetch_array($run_posts)){
        $post_id = $row_posts['post_id'];
        $user_id = $row_posts['user_id'];
        $content = substr($row_posts['post_content'], 0,40);
        $upload_image = $row_posts['upload_image'];
        $post_date = $row_posts['pos_date'];

        $user = "select * from users where user_id='$user_id' AND posts='yes'";
        $run_user = mysqli_query($con,$user);
        $row_user = mysqli_fetch_array($run_user);

        $user_name = $row_user['user_name'];
        $user_image = $row_user['user_image'];

        // Display posts
        echo "
        <div class='row'>
            <div class='col-sm-3'></div>
            <div id='posts' class='col-sm-6'>
                <div class='row'>
                    <div class='col-sm-2'>
                        <p><img src='images/$user_image' class='img-circle' width='100px' height='100px'></p>
                    </div>
                    <div class='col-sm-6'>
                        <h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                        <h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
                    </div>
                    <div class='col-sm-4'></div>
                </div>
                <div class='row'>
                    <div class='col-sm-12'>
                        <p>$content</p>
                        <img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
                    </div>
                </div><br>
                <a href='comments.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>View Comments</button></a><br>
                
                <!-- Comment Form -->
                <form method='post' action='add_comment.php?post_id=$post_id'>
                    <textarea name='comment_content' placeholder='Write a comment...' rows='2' style='width:100%;'></textarea>
                    <button type='submit' name='submit_comment' class='btn btn-primary'>Post Comment</button>
                </form>";
                
         

        echo "
                </div>
            </div>
            <div class='col-sm-3'></div>
        </div><br><br>";
    }
}
?>