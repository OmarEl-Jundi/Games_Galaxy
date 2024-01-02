<?php
require 'connection.php';
session_start();
if ($_SESSION["user_role"] != 1) {
    header("location: index.php");
}
?>
<html>

<head>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <form action="list-condition.php" method="post">
            ID: <input type="number" name="id">
            <br><br>
            Name: <input type="text" name="name">
            <br><br>
            Price: <input type="number" step=".01" name="price">
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
                    $query = 'SELECT * FROM developer';
                    $res = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </p>
            <input id="search" type="submit" value="search">
        </form>
        <p><a href="list-games.php">Show all Games</a></p>
        <p><a href="admin-home.php">Go Back to Main Menu</a></p>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = strtolower($_POST['name']);
            $price = $_POST['price'];
            $dev = strtolower($_POST['dev']);
            $cat = strtolower($_POST['cat']);
            $array = array();
            if (!empty($id)) {
                $array[] = "id LIKE '%$id%'";
            }
            if (!empty($name)) {
                $array[] = "LOWER(name) LIKE '%$name%'";
            }
            if (!empty($price)) {
                $array[] = "price LIKE '%$price%'";
            }
            if ($dev != "nodev") {
                $array[] = "developer LIKE '$dev'";
            }
            if ($cat != "nocat") {
                $array[] = "category LIKE '$cat'";
            }
            if (empty($array)) {
                echo "Please Enter a value";
            } else {
                $query = "SELECT * FROM `Games` WHERE " . implode(" AND ", $array) . "ORDER BY price asc";
                $res = mysqli_query($con, $query);
                if (mysqli_num_rows($res) == 0) {
                    echo "No results found.";
                } else {
        ?>
                    <table border="1" width="50%" bgcolor="black" align="center">
                        <tr style="color: aliceblue">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Developer</th>
                            <th>Image</th>
                        </tr>
                        <?php
                        $x = 0;
                        while ($row = mysqli_fetch_array($res)) {
                            if ($x % 2 == 0) {
                                echo '<tr align=center bgcolor="#2a475e" >';
                            } else {
                                echo '<tr align=center bgcolor="#66c0f4" >';
                            }
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>" . $row['developer'] . "</td>";
                            echo "<td><img width='150' height='200' src='../images/games/{$row['image']}'></td>";
                            echo "</tr>";
                            $x++;
                        }
                        ?>
                    </table>
        <?php
                }
            }
        }
        ?>
    </div>
</body>
<style>
    #search {
        position: relative;
        left: 0;
        margin: 10px;
        background-color: black;
        color: aliceblue;
        border: none;
        border-radius: 5px;
        padding: 10px;
        background-color: #2a475e;
    }

    #search:hover {
        background-color: #66c0f4;
    }

    .container {
        text-align: center;
    }

    form {
        margin-top: 50px;
    }
</style>

</html>