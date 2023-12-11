<?php
session_start();
require_once("connection.php");

if (isset($_SESSION['user_id']) && isset($_POST['gameID'])) {
    $userID = $_SESSION['user_id'];
    $gameID = $_POST['gameID'];
    //check if the game is already in library
    $query = "SELECT * FROM userlibrary WHERE user_id = '$userID' AND game_id = '$gameID'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        http_response_code(410); // Conflict if user already own the game
        exit();
    } else {
        $query1 = "SELECT * FROM wishlist WHERE u_id = '$userID' AND g_id = '$gameID'"; // Check if the game is already in the wishlist
        $result1 = mysqli_query($con, $query1);

        if (mysqli_num_rows($result1) > 0) {
            http_response_code(409); // Conflict if the game is already in the wishlist
            exit();
        }

        // Add the game to the wishlist
        $query2 = "INSERT INTO wishlist (u_id, g_id) VALUES ('$userID', '$gameID')";
        $result2 = mysqli_query($con, $query2);

        if ($result2) {
            http_response_code(200);
            // Success message if needed
        } else {
            http_response_code(500);
            // Error message if needed
        }
    }
} else {
    http_response_code(403); // Forbidden if user is not logged in
}
