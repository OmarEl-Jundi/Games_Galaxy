 <?php
    session_start();
    require 'connection.php';
    $gameID = $_GET['gameID'];
    $sql = "SELECT g.*,r.*, COUNT(r.rating) AS rate_count
                                                FROM games g
                                                LEFT JOIN rating r ON g.id = r.g_id
                                                WHERE g.id = '$gameID'
                                                GROUP BY g.id;";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $rate_count = $row['rate_count'];
    echo $rate_count;
    ?>