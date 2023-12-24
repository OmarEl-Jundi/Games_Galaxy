<?php
require 'connection.php';
$commentID = $_POST['commentID'];
$deleteLikes = "DELETE FROM like_comment WHERE c_id = $commentID";
$result = mysqli_query($con, $deleteLikes);
$deleteDislikes = "DELETE FROM dislike_comment WHERE c_id = $commentID";
$result = mysqli_query($con, $deleteDislikes);
$query = "DELETE FROM comments WHERE id = $commentID";
$result = mysqli_query($con, $query);

if ($result) {
    echo "Comment deleted successfully";
} else {
    echo "Error deleting comment";
}
