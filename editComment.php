<?php
require 'connection.php';
if (isset($_SESSION['user_id']) && isset($_POST['commentID'])) {
    $commentID = $_POST['commentID'];
    $comment = $_POST['editedComment'];
    $query = "UPDATE comments SET comment = '$comment' WHERE id = '$commentID'";
    $result = mysqli_query($con, $query);
    if ($result) {
        http_response_code(200); //success
        exit();
    } else {
        http_response_code(403);
    }
}
