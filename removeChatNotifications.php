<?php
session_start();
require 'connection.php';

if (isset($_POST['friendID'])) {
    $friendID = $_POST['friendID'];
    $userID = $_SESSION["user_id"];

    $removeNotification = "DELETE FROM notifications WHERE u_id = '$userID' AND type = 'message' AND related_id = '$friendID'";
    $result = mysqli_query($con, $removeNotification);

    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(401);
}
