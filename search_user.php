<?php
function search_user() {
    include("connection.php"); 

    if (isset($_GET['search_user_btn'])) {
        $search_query = htmlspecialchars($_GET['search_user']); 
        $search_query = mysqli_real_escape_string($connection, $search_query); 

        $sql = "SELECT * FROM users WHERE user_name LIKE '%$search_query%' OR user_email LIKE '%$search_query%'";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<br><h3 class='text-center'>Search Results:</h3><br>";
            echo "<div class='container'><div class='row'>";

            $count = 0; 
            while ($row = mysqli_fetch_assoc($result)) {
                $user_name = htmlspecialchars($row['user_name']);
                $user_email = htmlspecialchars($row['user_email']);
                $user_profile = htmlspecialchars($row['user_image']); 
                $user_id = $row['user_id'];

                echo "
                <div class='col-md-6'> <!-- Two results per row -->
                    <div class='panel panel-default text-center'>
                        <div class='panel-body'>
                            <img src='images/$user_profile' alt='Profile Image' class='img-circle' width='80px' height='80px'>
                            <h4><strong>$user_name</strong></h4>
                            <p>$user_email</p>
                            <a href='user_profile.php?u_id=$user_id' class='btn btn-primary btn-sm'>View Profile</a>
                        </div>
                    </div>
                </div>";

                $count++;

                if ($count % 2 == 0) {
                    echo "</div><div class='row'>";
                }
            }

            echo "</div></div>"; 
        } else {
            echo "<br><h4 class='text-center text-danger'>No users found.</h4>";
        }

        mysqli_free_result($result);
        mysqli_close($connection);
    }
}
?>
