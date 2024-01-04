<?php
session_start();
require_once("connection.php");

if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];

    $cartQuery = "SELECT g_id FROM cart WHERE u_id = '$userID'";
    $cartResult = mysqli_query($con, $cartQuery);

    if (mysqli_num_rows($cartResult) == 0) {
        http_response_code(404);
        exit();
    } else {
        while ($row = mysqli_fetch_array($cartResult)) {
            $gameID = $row['g_id'];

            $libraryQuery = "SELECT * FROM userlibrary WHERE user_id = '$userID' AND game_id = '$gameID'";
            $libraryResult = mysqli_query($con, $libraryQuery);

            if (mysqli_num_rows($libraryResult) == 0) {

                $checkFundsQuery = "SELECT * FROM wallet WHERE u_id = '$userID'";
                $checkFundsResult = mysqli_query($con, $checkFundsQuery);
                $row = mysqli_fetch_array($checkFundsResult);

                $funds = $row['amount'];
                $priceQuery = "SELECT price FROM games WHERE id = '$gameID'";
                $priceResult = mysqli_query($con, $priceQuery);
                $row = mysqli_fetch_array($priceResult);
                $price = $row['price'];

                if ($funds < $price) {
                    http_response_code(403);
                    exit();
                } else {
                    $funds = floatval($funds) - $price;
                    echo floatval($funds);
                    $updateFundsQuery = "UPDATE wallet SET amount = '$funds' WHERE u_id = '$userID'";
                    $updateFundsResult = mysqli_query($con, $updateFundsQuery);
                    $insertQuery = "INSERT INTO userlibrary (user_id, game_id, purchase_date_time) VALUES ('$userID', '$gameID', NOW())";
                    $insertResult = mysqli_query($con, $insertQuery);
                    http_response_code(200);
                }
            }
        }
    }

    $clearCartQuery = "DELETE FROM cart WHERE u_id = '$userID'";
    $clearCartResult = mysqli_query($con, $clearCartQuery);
}
