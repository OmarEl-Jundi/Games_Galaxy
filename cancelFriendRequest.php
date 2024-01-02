<?php
session_start();
require 'connection.php';

$friendID = $_POST['sentFriendRequestID'];
$userID = $_SESSION['user_id'];

$sql = "DELETE FROM friend_request WHERE sender_id = '$userID' AND receiver_id = '$friendID'";
$result = mysqli_query($con, $sql);

$removeNotification = "DELETE FROM notifications WHERE u_id = '$friendID' AND type = 'friend_request' AND related_id = '$userID'";
mysqli_query($con, $removeNotification);

if ($result) {
    http_response_code(200);
} else {
    http_response_code(400);
}
