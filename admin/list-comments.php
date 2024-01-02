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
                echo "<td><a href='ban-user.php?userID={$row['u_id']}' onclick='return confirm(\"Are you sure you want to ban this user?\");'>Ban User</a></td>";
                echo "</tr>";
            }
            ?>
    </div>
</body>

</html>