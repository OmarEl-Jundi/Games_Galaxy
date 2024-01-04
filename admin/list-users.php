<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <table>
            <tr>
                <th>Profile Picture</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Birth Date</th>
                <th>Role</th>
                <th>Ban User</th>
            </tr>
            <?php
            require 'connection.php';
            $query = "SELECT * FROM `user`";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr align=center bgcolor="#2a475e">';
                echo "<td><img src='../images/userPFP/{$row['pfp']}' width='100px' height='100px'></td>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['fname']}</td>";
                echo "<td>{$row['lname']}</td>";
                echo "<td>{$row['date_of_birth']}</td>";
                echo "<td>{$row['role']}</td>";
                if ($row['banned'] == 0)
                    echo "<td><a href='ban-user.php?userID={$row['id']}' onclick='return confirm(\"Are you sure you want to ban this user?\");'>Ban User</a></td>";
                else
                    echo "<td><a href='unban-user.php?userID={$row['id']}' onclick='return confirm(\"Are you sure you want to unban this user?\");'>Unban User</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <a href="admin-home.php">Go Back</a>
    </div>
</body>
<style>
    td {
        padding: 10px;
    }

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