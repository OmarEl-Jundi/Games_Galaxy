<?php
session_start();
require 'connection.php';

$friendID = $_POST['friendID'];
$userID = $_SESSION['user_id'];

$sql = "DELETE FROM friends WHERE (u1_id = '$userID' AND u2_id = '$friendID') OR (u1_id = '$friendID' AND u2_id = '$userID')";
$result = mysqli_query($con, $sql);

if ($result) {
    http_response_code(200);
} else {
    http_response_code(400);
}
