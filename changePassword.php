<?php
session_start();
require 'connection.php';

if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $userId = $_SESSION['user_id'];
    $query = "SELECT * FROM user WHERE id='$userId' AND password='$oldPassword'";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        if ($newPassword == $confirmPassword) {
            $query = "UPDATE users SET password='$newPassword' WHERE id='$userId'";
            $result = mysqli_query($con, $query);
            if ($result) {
                http_response_code(200);
            } else {
                http_response_code(402);
            }
        } else {
            http_response_code(401);
        }
    } else {
        http_response_code(400);
    }
}
