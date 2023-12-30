<?php
session_start();
require 'connection.php';

if (isset($_SESSION['user_id']) && isset($_POST['messageID'])) {
    $MessageID = $_POST['messageID'];
    $sql = "SELECT receiver_id FROM messages WHERE id = '$MessageID'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $receiverID = $row['receiver_id'];

    $sql = "DELETE FROM messages WHERE id = '$MessageID'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        http_response_code(200);
        echo $receiverID;
        exit();
    } else {
        http_response_code(403);
    }
}
