<?php
session_start();
require("connection.php");

if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];

    $query = "SELECT SUM(games.price) AS total_price FROM cart INNER JOIN games ON cart.g_id = games.id WHERE cart.u_id = '$userID'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $totalPrice = $row['total_price'];

        http_response_code($totalPrice);
        exit();
    } else {
        echo json_encode(['error' => 'Query error']);
        exit();
    }
} else {
    echo json_encode(['error' => 'User ID not set']);
    exit();
}
