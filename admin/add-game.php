<html>

<head>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
</head>
<?php
require 'connection.php';
session_start();
if ($_SESSION["user_role"] != 1) {
    header("location: index.php");
}
?>

<body>
    <div class="container">
        <h1>Insert a new Game to the Database</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <p>Name: <input type="text" name="name" required></p>
            <p>Image: <input type="file" name="img" required></p>
            <p>Trailer: <input type="text" name="trailer" required></p>
            <p>Description: <input type="text" name="desc" required></p>
            <p>Price: <input type="number" step=".01" name="price" required></p>
            <p>
                Category:
                <select name="cat">
                    <option value="nocat">SELECT</option>
                    <?php
                    $query = 'SELECT * FROM `Category`';
                    $res = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                Developer:
                <select name="dev">
                    <option value="nodev">SELECT</option>
                    <?php
                    $query = 'SELECT * FROM `Developer`';
                    $res = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </p>
            <p><input type="submit" name="sb" value="insert"></p>
            <p><input type="reset" value="clear all"></p>
        </form>
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $desc = mysqli_real_escape_string($con, $_POST['desc']);
            $price = $_POST['price'];
            $trailer = $_POST['trailer'];
            $cat = $_POST['cat'];
            $dev = $_POST['dev'];
            if ($cat == 'nocat') {
                echo "Please select a Category";
            } else if ($dev == 'nodev') {
                echo "Please select a Developer";
            } else {
                $targetFile = "";
                if (isset($_FILES['img'])) {
                    $img = $_FILES['img']['name'];
                    $imgTmp = $_FILES['img']['tmp_name'];
                    $targetDir = '../images/games/';
                    $newFileName = $name . basename($img);
                    $targetFile = $targetDir . $newFileName;
                    move_uploaded_file($imgTmp, $targetFile);
                }

                $query = "INSERT INTO `Games` (`name`, `image`,`trailer`, `description`, `price`, `category`, `developer`) VALUES ('$name', '$newFileName','$trailer', '$desc', '$price', '$cat', '$dev')";

                if (mysqli_query($con, $query)) {
                    echo "The Game $name is successfully added";
                } else {
                    echo "Error executing query: " . mysqli_error($con);
                }
            }
        }

        ?>
        <p><a href="list-games.php">Show all Games</a></p>
        <p><a href="admin-home.php">Go Back to Main Menu</a></p>
    </div>
</body>
<style>
    .container {
        text-align: center;
    }
</style>