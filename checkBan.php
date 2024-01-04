<?php
session_start();
require 'connection.php';

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM `user` WHERE `id` = '$user_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $ban = $row['banned'];
    if ($ban == 1) {
        session_destroy();
        http_response_code(201);
    }
}
