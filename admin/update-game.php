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
        <h1>Update Game info</h1>
        <form method="post" action="">
            <p>
                <?php
                require 'connection.php';
                $result = mysqli_query($con, "SELECT * FROM Games");
                echo "<select name='game'>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                }
                echo '</select>';
                mysqli_close($con);
                ?>
            </p>
            <input type="submit" value="Select Game">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        ?>
            <form method="post" action="" enctype="multipart/form-data">
                <p> id: <input type="text" name="id" value="<?php echo isset($_POST['game']) ? $_POST['game'] : ''; ?>" readonly> ReadOnly </p>
                <p> Name: <input type="text" name="name"></p>
                <p>Price: <input type="number" step=".01" name="price"></p>
                <p>Image: <input type="file" name="img"></p>
                <p>Trailer: <input type="text" name="trailer"></p>
                <p>Description: <input type="text" name="desc"></p>
                <p>
                    Category:
                    <select name="cat">
                        <option value="nocat">SELECT</option>
                        <?php
                        require 'connection.php';
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
                <p><input type="submit" value="Update Info" name="updateInfo"></p>
            </form>
        <?php
        }

        if (isset($_POST['updateInfo'])) {
            $id = $_POST['id'];
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $price = $_POST['price'];
            $trailer = $_POST['trailer'];
            $desc = mysqli_real_escape_string($con, $_POST['desc']);
            $dev = $_POST['dev'];
            $cat = $_POST['cat'];
            $array = array();
            if (!empty($name)) {
                $array[] = "`name`= '$name'";
            }
            if (!empty($price)) {
                $array[] = "`price`='$price'";
            }
            if (!empty($trailer)) {
                $array[] = "`trailer` = '$trailer'";
            }
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $targetDir = '../images/games/';
                $img = $_FILES['img']['name'];
                $imgTmp = $_FILES['img']['tmp_name'];
                $newFileName = $name . basename($img);
                $targetFile = $targetDir . $newFileName;
                move_uploaded_file($imgTmp, $targetFile);
                $array[] = "`image` = '$newFileName'";
            }

            if (!empty($desc)) {
                $array[] = "`description`='$desc'";
            }
            if ($dev != "nodev") {
                $array[] = "`developer` = '$dev'";
            }
            if ($cat != "nocat") {
                $array[] = "`category` = '$cat'";
            }
            if (empty($array)) {
                echo "<b>Please Enter a value</b>";
            } else {
                $query = "UPDATE `Games` SET " . implode(", ", $array) . " WHERE id = " . $id;
                $res = mysqli_query($con, $query);
                echo "<b>Update Successful</b>";
            }
        }
        ?>
        <p><a href="list-games.php">Show all Games</a></p>
        <p><a href="admin-home.php">Go Back to Main Menu</a></p>
    </div>
</body>
<style>
    b {
        color: royalblue;
    }
</style>