<?php
session_start();
require 'connection.php';

if (isset($_POST['username'])) {
    $friendUsername = $_POST['username'];
    $user_ID = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE username='$friendUsername'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $friend_ID = $row['id'];
    $sql = "INSERT INTO friend_request (sender_id, receiver_id) VALUES ('$user_ID', '$friend_ID')";
    $result = mysqli_query($con, $sql);

    $sql = "SELECT * FROM user WHERE id='$friend_ID'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
    exit();
} else {
    exit();
}
