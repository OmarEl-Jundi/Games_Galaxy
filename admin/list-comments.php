<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Comments</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Table of Comments</h1>
        <table border="1" width="80%" align="center">
            <tr>
                <th>Comment ID</th>
                <th>Game ID</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Comment</th>
                <th>Comment Date</th>
                <th>Comment Time</th>
            </tr>
            <?php
            require 'connection.php';
            $query = "SELECT Comments.*, user.username FROM `Comments` JOIN `user` ON Comments.u_id = user.id";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                $date_time = $row['date_time'];
                $date = date("d/m/Y", strtotime($date_time));
                $time = date("h:i A", strtotime($date_time));
                echo '<tr align=center bgcolor="#2a475e">';
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['g_id']}</td>";
                echo "<td>{$row['u_id']}</td>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['comment']}</td>";
                echo "<td>{$date}</td>";
                echo "<td>{$time}</td>";
                echo "<td><a href='../deleteComment.php?commentID={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this comment?\");'>Delete</a></td>";
                if ($row['banned'] == 0)
                    echo "<td><a href='ban-user.php?userID={$row['u_id']}' onclick='return confirm(\"Are you sure you want to ban this user?\");'>Ban User</a></td>";
                else
                    echo "<td><a href='unban-user.php?userID={$row['u_id']}' onclick='return confirm(\"Are you sure you want to unban this user?\");'>Unban User</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <a href="admin-home.php">Go Back</a>
    </div>
</body>
<style>
    #scrollToTopBtn {
        background-color: #66c0f4;
        color: black;
    }
</style>

<script>
    // Function to check the scroll position and show/hide the button
    window.onscroll = function() {
        scrollFunction();
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("scrollToTopBtn").style.display = "block";
        } else {
            document.getElementById("scrollToTopBtn").style.display = "none";
        }
    }

    // Function to scroll back to the top when the button is clicked
    function scrollToTop() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    }
</script>

</html>