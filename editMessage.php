<?php
session_start();
require 'connection.php';
if (isset($_SESSION['user_id']) && isset($_POST['messageID'])) {
    $MessageID = $_POST['messageID'];
    $message = $_POST['editedMessage'];

    $query = "UPDATE messages SET message = '$message' WHERE id = '$MessageID'";
    $result = mysqli_query($con, $query);
    if ($result) {
        http_response_code(200);
        $sql = "SELECT receiver_id FROM messages WHERE id = '$MessageID'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $receiverID = $row['receiver_id'];
        echo $receiverID;
        exit();
    } else {
        http_response_code(403);
    }
}
