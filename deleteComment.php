<?php
require 'connection.php';
$commentID = $_POST['commentID'];
$query = "DELETE FROM comments WHERE id = '$commentID'";
$result = mysqli_query($con, $query);
if ($result) {
    echo "Comment deleted successfully";
} else {
    echo "Error deleting comment";
}
