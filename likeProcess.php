<?php
session_start();
require_once("connection.php");

if (isset($_SESSION['user_id']) && isset($_POST['commentID'])) {
    $userID = $_SESSION['user_id'];
    $commentID = $_POST['commentID'];
    $query = "SELECT * FROM like_comment WHERE u_id = '$userID' AND c_id = '$commentID'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $query = "DELETE FROM like_comment WHERE u_id = '$userID' AND c_id = '$commentID'";
        $result = mysqli_query($con, $query);
        http_response_code(410); //user already liked the comment
        exit();
    } else {
        $query = "DELETE FROM dislike_comment WHERE u_id = '$userID' AND c_id = '$commentID'";
        $result = mysqli_query($con, $query);
        $query = "INSERT INTO like_comment (u_id, c_id) VALUES ('$userID', '$commentID')";
        $result = mysqli_query($con, $query);

        if ($result) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }
    }
} else {
    http_response_code(403); //if user is not logged in
}
