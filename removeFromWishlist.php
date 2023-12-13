<?php
session_start();
require_once("connection.php");

if (isset($_SESSION['user_id']) && isset($_POST['gameID'])) {
    $userID = $_SESSION['user_id'];
    $gameID = $_POST['gameID'];

    $query = "DELETE FROM `wishlist` WHERE u_id = '$userID' AND g_id = '$gameID'";
    $result = mysqli_query($con, $query);

    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}
