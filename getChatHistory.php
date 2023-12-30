<?php
session_start();
require 'connection.php';

$friendID = $_POST['friendID'];
$userID = $_SESSION['user_id'];

$sql = "SELECT messages.*, 
               sender.username AS sender_username, 
               receiver.username AS receiver_username
        FROM messages
        JOIN user AS sender ON messages.sender_id = sender.id
        JOIN user AS receiver ON messages.receiver_id = receiver.id
        WHERE (messages.sender_id = '$userID' AND messages.receiver_id = '$friendID') 
           OR (messages.sender_id = '$friendID' AND messages.receiver_id = '$userID') 
        ORDER BY messages.date_time ASC";

$result = mysqli_query($con, $sql);

$previousSender = null;
$previousTime = null;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $senderID = $row['sender_id'];
        $receiverID = $row['receiver_id'];
        $senderUsername = $row['sender_username'];
        $receiverUsername = $row['receiver_username'];
        $message = $row['message'];
        $date_time = $row['date_time'];
        $time = date('h:i A', strtotime($date_time));
        $date = date('d-m-Y', strtotime($date_time));

        $currentTime = strtotime($date_time);
        $showHeader = false;

        if ($previousSender !== $senderID || $previousSender === null) {
            // Different sender or first message
            $showHeader = true;
        } else {
            $timeDiff = $currentTime - $previousTime;
            if ($timeDiff > 300) { // More than 5 mins (300 seconds)
                $showHeader = true;
            }
        }

        if ($senderID == $userID) {
            echo "<div class='message-sent'>";
            if ($showHeader) {
                echo "
                <hr>
                    <h3 class='chat_username'>You</h3>
                    <h5 class='chat_date_time'>at $time on $date</h5>";
            }
            echo "
                    <div class='chat_message'>
                        <p>$message</p>
                    </div>
                </div>";
        } else {
            echo "<div class='message-sent'>";
            if ($showHeader) {
                echo "
                <hr>
                    <h3 class='chat_username'> $senderUsername </h3>
                    <h5 class='chat_date_time'>at $time on $date</h5>";
            }
            echo "
                    <div class='chat_message'>
                        <p>$message</p>
                    </div>
                </div>";
        }

        $previousSender = $senderID;
        $previousTime = $currentTime;
    }
} else {
    http_response_code(404);
}
