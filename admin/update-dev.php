<?php
require 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Developer Info</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Update Developer Info</h1>
        <form action="update-dev.php" method="post">
            <select name="developer" id="">
                <option value="none">SELECT</option>
                <?php
                $query = "SELECT * FROM `Developer`";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
            <input type="submit" name="selectDeveloper" value="SELECT">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['selectDeveloper'])) {
        ?>
                <form id="form2" method="post" action="" enctype="multipart/form-data">
                    <p> id: <input type="text" name="id" value="<?php echo isset($_POST['developer']) ? $_POST['developer'] : ''; ?>" readonly> ReadOnly </p>
                    <p> Name: <input type="text" name="name"></p>
                    <p>Description: <input type="text" name="desc"></p>
                    <input type="submit" name="updateDeveloper" value="Update">
                </form>
        <?php
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['updateDeveloper'])) {
                if (isset($_POST['name']) && isset($_POST['desc'])) {
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $desc = $_POST['desc'];
                    $array = array();
                    if ($name != "") {
                        array_push($array, "`name` = '$name'");
                    }
                    if ($desc != "") {
                        array_push($array, "`description` = '$desc'");
                    }
                    if (empty($array)) {
                        echo "<b>Please Enter a value</b>";
                    } else {
                        $query = "UPDATE `Developer` SET " . implode(", ", $array) . " WHERE `id` = $id";
                        $result = mysqli_query($con, $query);
                        if ($result) {
                            echo "<p>Developer Updated Successfully</p>";
                        } else {
                            echo "<p>Developer Not Updated</p>";
                        }
                    }
                }
            }
        }
        ?>
        <a id="goBack" href="admin-home.php">Go Back</a>
    </div>
</body>
<style>
    select {
        text-align: center;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    #form2 {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0px;
        margin-top: 20px;
        justify-content: space-between;
    }

    #goBack {
        display: block;
        text-align: center;
        margin-top: 20px;
    }
</style>

</html>