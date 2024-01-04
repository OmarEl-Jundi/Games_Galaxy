<?php
require 'connection.php';
if (isset($_POST['commentID'])) {
    $commentID = $_POST['commentID'];
} else if (isset($_GET['commentID'])) {
    $commentID = $_GET['commentID'];
}
$deleteLikes = "DELETE FROM like_comment WHERE c_id = $commentID";
$result = mysqli_query($con, $deleteLikes);
$deleteDislikes = "DELETE FROM dislike_comment WHERE c_id = $commentID";
$result = mysqli_query($con, $deleteDislikes);
$query = "DELETE FROM comments WHERE id = $commentID";
$result = mysqli_query($con, $query);

if ($result) {
    echo "Comment deleted successfully";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    http_response_code(200);
    exit();
} else {
    echo "Error deleting comment";
}
