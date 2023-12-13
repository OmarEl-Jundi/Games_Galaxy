<?php
session_start();
require_once("connection.php");

if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];

    $cartQuery = "SELECT g_id FROM cart WHERE u_id = '$userID'";
    $cartResult = mysqli_query($con, $cartQuery);

    while ($row = mysqli_fetch_array($cartResult)) {
        $gameID = $row['g_id'];

        $libraryQuery = "SELECT * FROM userlibrary WHERE user_id = '$userID' AND game_id = '$gameID'";
        $libraryResult = mysqli_query($con, $libraryQuery);

        if (mysqli_num_rows($libraryResult) == 0) {
            $insertQuery = "INSERT INTO userlibrary (user_id, game_id) VALUES ('$userID', '$gameID')";
            $insertResult = mysqli_query($con, $insertQuery);
            header("location: library.php");
        }
    }

    $clearCartQuery = "DELETE FROM cart WHERE u_id = '$userID'";
    $clearCartResult = mysqli_query($con, $clearCartQuery);
}
