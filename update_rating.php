<?php
include("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gameID']) && isset($_POST['userRating'])) {
    $gameID = $_POST['gameID'];
    $userRating = $_POST['userRating'];

    $sql = "SELECT * FROM rating WHERE u_id = '$_SESSION[user_id]' AND g_id = '$gameID'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $sql = "UPDATE rating SET rating = '$userRating' WHERE u_id = '$_SESSION[user_id]' AND g_id = '$gameID'";
        mysqli_query($con, $sql);
    } else {
        $sql = "INSERT INTO rating (u_id, g_id, rating) VALUES ('$_SESSION[user_id]', '$gameID', '$userRating')";
        mysqli_query($con, $sql);
    }

    $sql = "SELECT AVG(rating) AS average_rating FROM rating WHERE g_id = '$gameID'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $averageRating = $row['average_rating'];

    echo $averageRating;
    http_response_code(200);
} else {
    http_response_code(403);
}
