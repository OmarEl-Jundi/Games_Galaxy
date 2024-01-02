<?php
session_start();
require 'connection.php';

$userID = $_SESSION['user_id'];

$sql = "SELECT * FROM notifications WHERE u_id = '$userID' ";
$result = mysqli_query($con, $sql);
$row_count = mysqli_num_rows($result);

if ($row_count > 0) {
    echo $row_count;
    http_response_code(200);
}
