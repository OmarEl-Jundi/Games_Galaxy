<?php
session_start();
require_once("connection.php");

if (isset($_SESSION['user_id'], $_POST['gameID'])) {
    $userID = $_SESSION['user_id'];
    $gameID = $_POST['gameID'];

    // Check if the game is already in the library or cart
    $checkLibraryQuery = "SELECT * FROM userlibrary WHERE user_id = '$userID' AND game_id = '$gameID'";
    $result = mysqli_query($con, $checkLibraryQuery);

    if (mysqli_num_rows($result) > 0) {
        http_response_code(409); //user already owns the game
        exit();
    } else {
        $checkCartQuery = "SELECT * FROM cart WHERE u_id = '$userID' AND g_id = '$gameID'";
        $result = mysqli_query($con, $checkCartQuery);

        if (mysqli_num_rows($result) > 0) {
            http_response_code(410); //game already in cart
            exit();
        }
    }


    // Add the game to the cart
    $insertQuery = "INSERT INTO cart (u_id, g_id) VALUES ('$userID', '$gameID')";
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        http_response_code(200); // Success
        // Success message if needed
    } else {
        http_response_code(500); // Internal Server Error
        // Error message if needed
    }
} else {
    http_response_code(403); // Forbidden if user is not logged in or gameID is missing
}
