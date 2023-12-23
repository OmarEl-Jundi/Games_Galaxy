<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];
    $gameID = $_POST['gameID'];

    // Validate comment - check if it contains at least one letter or number
    if (preg_match('/[A-Za-z0-9]/', $comment)) {
        $sql = "INSERT INTO `comments` (`g_id`, `u_id`, `comment`, `date_time`) VALUES ('$gameID', '$user_id', '$comment', current_timestamp())";
        $result = mysqli_query($con, $sql);
        if ($result) {
            header("Location: gameDescription.php?gameID=$gameID");
        }
    } else {
        echo '<script>alert("Please type at least one letter or number in your comment."); window.location = "gameDescription.php?gameID=' . $gameID . '";</script>';
    }
} else {
    echo '<script>alert("Please type a comment."); window.location = "gameDescription.php?gameID=' . $gameID . '";</script>';
}
