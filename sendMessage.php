<?php
require 'connection.php';
session_start();

$friendID = $_POST['friendID'];
$userID = $_SESSION['user_id'];
$message = $_POST['message'];

$sql = "INSERT INTO messages (sender_id, receiver_id, message,date_time) VALUES ('$userID', '$friendID', '$message',NOW())";
$result = mysqli_query($con, $sql);

if ($result) {
    http_response_code(200);
} else {
    http_response_code(500);
    echo "Error: " . mysqli_error($con);
}
