<?php
session_start();
require_once("connection.php");

if (isset($_SESSION['user_id'], $_POST['gameID'])) {
    $userID = $_SESSION['user_id'];
    $gameID = $_POST['gameID'];

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


    $insertQuery = "INSERT INTO cart (u_id, g_id) VALUES ('$userID', '$gameID')";
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        http_response_code(200);
        $itemSelectQuery = "SELECT * FROM games WHERE id = '$gameID'";
        $itemResult = mysqli_query($con, $itemSelectQuery);
        $games = mysqli_fetch_assoc($itemResult);
        echo '<div id="cart-' . $games['id'] . '" class="item">
                <img src="images/games/' . $games['image'] . '" alt="" />
                <div class="cartContent">
                  <div class="name">' . $games['name'] . '</div>
                  <div class="price">
                  ';
        if ($games['price'] == 0) {
            echo 'Free!';
        } else {
            echo '$' . $games['price'];
        }
        echo '
                    </div>
                </div>
                <button onclick="removeFromCart(' . $games['id'] . ')" class="RemoveFromCartBtn" data-game-id="' . $games['id'] . '">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M16 6v-4a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v4"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                    <path d="M5 6L5 18a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2L19 6"></path>
                    <path d="M9 3v1M15 3v1"></path>
                  </svg>
                </button>
              </div>
              ';
    } else {
        http_response_code(500);
    }
} else {
    http_response_code(403);
}
