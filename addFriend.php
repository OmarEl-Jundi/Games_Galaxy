<?php
session_start();
require 'connection.php';

if (isset($_POST['username'])) {
    $friendUsername = $_POST['username'];
    $user_ID = $_SESSION['user_id'];
    $getUserID = "SELECT * FROM user WHERE username='$friendUsername'";
    $result = mysqli_query($con, $getUserID);
    $row = mysqli_fetch_assoc($result);
    $friend_ID = $row['id'];

    $checkExistingRequest = "SELECT * FROM friend_request 
                             WHERE sender_id = '$friend_ID' 
                             AND receiver_id = '$user_ID'";
    $checkResult = mysqli_query($con, $checkExistingRequest);

    if (mysqli_num_rows($checkResult) > 0) {
        $row = mysqli_fetch_assoc($checkResult);
        $friend_ID = $row['sender_id'];
        $insertFriendship = "INSERT INTO friends (u1_id, u2_id) VALUES ('$user_ID', '$friend_ID')";
        mysqli_query($con, $insertFriendship);

        $deleteRequest = "DELETE FROM friend_request WHERE sender_id='$friend_ID' AND receiver_id='$user_ID'";
        mysqli_query($con, $deleteRequest);

        $getUserDetails = "SELECT * FROM user WHERE id='$friend_ID'";
        $result = mysqli_query($con, $getUserDetails);
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
        http_response_code(201);
        exit();
    } else {
        $getUserID = "SELECT * FROM user WHERE username='$friendUsername'";
        $result = mysqli_query($con, $getUserID);
        $row = mysqli_fetch_assoc($result);
        $friend_ID = $row['id'];
        $insertRequest = "INSERT INTO friend_request (sender_id, receiver_id) VALUES ('$user_ID', '$friend_ID')";
        mysqli_query($con, $insertRequest);

        $getUserDetails = "SELECT * FROM user WHERE id='$friend_ID'";
        $result = mysqli_query($con, $getUserDetails);
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
        http_response_code(200);
        exit();
    }
} else {
    exit();
}
