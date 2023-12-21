<?php
include("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gameID']) && isset($_POST['userRating'])) {
    $gameID = $_POST['gameID'];
    $userRating = $_POST['userRating'];

    $sql = "SELECT rating, rate_count FROM games WHERE id = '$gameID'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentRating = $row['rating'];
        $currentRateCount = $row['rate_count'];

        $newTotalRating = $currentRating + $userRating;
        $newRateCount = $currentRateCount + 1;

        $newAverageRating = $newTotalRating / $newRateCount;

        $updateSQL = "UPDATE games SET rating = '$newAverageRating', rate_count = '$newRateCount' WHERE id = '$gameID'";
        mysqli_query($con, $updateSQL);

        $response = array(
            "success" => true,
            "newRating" => $newAverageRating
        );
        echo json_encode($response);
    } else {
        $response = array(
            "success" => false,
            "message" => "Invalid Game ID"
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        "success" => false,
        "message" => "Invalid Request"
    );
    echo json_encode($response);
}
