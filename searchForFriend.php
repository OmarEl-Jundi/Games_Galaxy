<?php
session_start();
require 'connection.php';

$username = $_POST['username'];
$sql = "SELECT *
FROM user
WHERE LOWER(username) LIKE LOWER('%$username%')
AND id NOT IN (
    SELECT CASE
            WHEN friends.u1_id = $_SESSION[user_id] THEN friends.u2_id
            ELSE friends.u1_id
        END AS friend_id
    FROM friends
    WHERE friends.u1_id = $_SESSION[user_id] OR friends.u2_id = $_SESSION[user_id]
)

";
$result = mysqli_query($con, $sql);
$rows = array();

while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

echo json_encode($rows);
