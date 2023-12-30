<?php
session_start();
require 'connection.php';

$friendID = $_POST['sentFriendRequestID'];
$userID = $_SESSION['user_id'];

$sql = "DELETE FROM friend_request WHERE sender_id = '$userID' AND receiver_id = '$friendID'";
$result = mysqli_query($con, $sql);

if ($result) {
    http_response_code(200);
} else {
    http_response_code(400);
}
