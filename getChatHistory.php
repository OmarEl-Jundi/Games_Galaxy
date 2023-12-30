<?php
session_start();
require 'connection.php';

$friendID = $_POST['friendID'];
$userID = $_SESSION['user_id'];

$sql = "SELECT messages.*, 
               sender.username AS sender_username, 
               receiver.username AS receiver_username,
               messages.id AS messageID
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
        $messageID = $row['messageID'];
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
                    <div data-message-id='$messageID' class='chat_delete_edit'>
                        <svg data-message-id='$messageID' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi editMessage bi-pencil-square' viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                        <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
                                    </svg>
                                    <svg data-message-id='$messageID' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi deleteMessage bi-trash3' viewBox='0 0 16 16'>
                            <path data-comment-id='" .
                $messageID .
                "' d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5'/>
                                    </svg>
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
