<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}
$sql = "SELECT * FROM `user` WHERE id = '$_SESSION[user_id]'";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="spinner"></div>
    <div class="content" style="display: none">
        <div class="container">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a style="margin-right: 100px;" href="logout.php" id="logoutButton" class="auth-button">Logout</a>
            <?php else : ?>
                <a href="login.php" id="loginButton" class="auth-button">Log In</a>
                <a href="signup.php" id="signupButton" class="auth-button">Sign Up</a>
            <?php endif ?>
            <div class="darkThemeBtn">
                <input id="darkmode-toggle" type="checkbox" />
                <label for="darkmode-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="sun">
                        <g transform="translate(0 512) scale(.1 -.1)">
                            <path d="m2513 5105c-59-25-63-46-63-320 0-266 4-288 54-315 33-17 79-17 112 0 50 27 54 49 54 315 0 275-4 295-65 321-42 17-51 17-92-1z"></path>
                            <path d="m754 4366c-28-28-34-41-34-77 0-42 3-45 188-231l187-188h47c39 0 52 5 77 31 26 25 31 38 31 77v47l-188 187c-186 185-189 188-231 188-36 0-49-6-77-34z"></path>
                            <path d="m4058 4212-188-187v-47c0-39 5-52 31-77 25-26 38-31 77-31h46l188 188c186 186 188 188 188 231 0 36-6 49-34 77s-41 34-77 34c-42 0-45-3-231-188z"></path>
                            <path d="m2440 4224c-453-50-760-192-1056-488-264-264-419-570-475-936-17-109-17-371 0-480 56-366 211-672 475-936s570-419 936-475c109-17 371-17 480 0 366 56 672 211 936 475 225 225 358 455 438 758 38 143 50 249 50 418 0 219-30 388-104 590-137 372-450 719-813 901-143 72-315 128-474 154-89 15-329 26-393 19zm335-235c305-46 582-186 805-409 567-567 567-1473 0-2040s-1473-567-2040 0-567 1473 0 2040c328 328 777 476 1235 409z"></path>
                            <path d="m54 2651c-20-12-37-34-44-55-16-49 2-101 44-127 28-17 52-19 279-19 268 0 289 4 317 54 17 33 17 79 0 112-28 50-49 54-317 54-227 0-251-2-279-19z"></path>
                            <path d="m4512 2657c-73-41-73-155 0-193 21-11 81-14 275-14 227 0 251 2 279 19 42 26 60 78 44 127-7 21-24 43-44 55-28 17-52 19-281 19-181-1-256-4-273-13z"></path>
                            <path d="m908 1062c-185-186-188-189-188-231 0-36 6-49 34-77s41-34 77-34c43 0 45 2 231 188l188 188v46c0 39-5 52-31 77-25 26-38 31-77 31h-47l-187-188z"></path>
                            <path d="m3901 1219c-26-25-31-38-31-77v-47l188-187c186-185 189-188 231-188 36 0 49 6 77 34s34 41 34 77c0 43-2 45-188 231l-188 188h-46c-39 0-52-5-77-31z"></path>
                            <path d="m2540 663c-87-28-90-37-90-330 0-227 2-251 19-279 40-66 142-66 182 0 17 28 19 52 19 279 0 266-4 291-52 314-32 16-60 22-78 16z"></path>
                        </g>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="moon">
                        <g transform="translate(0 512) scale(.1 -.1)">
                            <path d="m2090 5105c-248-51-443-118-659-226-514-256-909-652-1161-1163-94-191-139-311-185-490-127-500-110-999 51-1468 133-389 331-706 624-998 403-404 875-642 1460-736 147-24 529-24 693 0 539 78 981 283 1390 644 362 319 647 793 766 1270 46 186 56 256 42 299-22 71-80 116-151 117-73 1-104-19-181-116-307-390-733-627-1233-689-119-14-385-7-501 15-582 106-1066 469-1321 991-120 246-171 452-181 731-21 586 230 1126 695 1493 96 75 117 107 117 177 0 85-67 155-153 160-26 1-76-3-112-11zm110-149c0-2-26-23-57-47-81-60-254-230-325-318-213-264-353-573-415-916-22-126-25-508-5-625 62-346 195-651 395-910 72-93 228-250 327-329 266-213 571-349 930-413 117-20 499-17 625 5 343 62 652 202 916 415 88 71 258 244 318 325 24 32 46 56 48 54s-8-60-23-128c-127-606-501-1155-1027-1505-780-521-1798-535-2602-36-295 183-594 482-777 777-335 539-445 1180-308 1795 138 621 515 1158 1060 1511 136 88 374 201 530 253 148 49 390 106 390 92z"></path>
                        </g>
                    </svg>
                </label>
                <span class="fake-body"></span>
            </div>
            <?php
            if (isset($_SESSION['user_id'])) {
                $query = "SELECT * FROM `wallet` WHERE u_id = '$_SESSION[user_id]'";
                $result = mysqli_query($con, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $wallet = mysqli_fetch_array($result);
            ?>
                    <div class="tooltip-container">
                        <span class="tooltip">$ <?= $wallet['amount'] ?></span>
                        <span class="text">Wallet</span>
                    </div>
                <?php
                } else {
                ?>
                    <div class="tooltip-container">
                        <span class="tooltip"><?php echo 'you don\'t have a wallet'; ?></span>
                        <span class="text">Wallet</span>
                    </div>
            <?php
                }
            }
            ?>
            <div class="navIcons" title="friends">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi friendsIcon bi-people-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                </svg>
                <?php
                $notificationsQuery = "SELECT * FROM `notifications` WHERE u_id = '$_SESSION[user_id]' AND seen = 0";
                $notificationsResult = mysqli_query($con, $notificationsQuery);
                if ($notificationsResult && mysqli_num_rows($notificationsResult) > 0) {
                ?>
                    <div class="notificationsCount"><?= mysqli_num_rows($notificationsResult) ?></div>
                <?php
                }
                ?>
            </div>
            <?php
            if ($_SESSION['user_role'] == 1) {
                echo "<img onclick='admin()' style='width:100px;height:100px;margin-left: 220px;margin-bottom: -52px;margin-top: -34px;cursor:pointer;' src='images/logo/Admin_Logo.png' id='adminIcon' />";
                echo "<script>function admin(){window.location.href='admin/admin-home.php';}</script>";
            }
            ?>
            <div class="logo">
                <img src="images/logo/Games-galaxy-Logo-transformed.png" />
            </div>
            <nav>
                <a class="button" href="index.php">Home</a>
                <a class="button" href="shop.php">Shop</a>
                <a class="button" href="library.php">Library</a>
                <a class="button" href="whishList.php">Whish List</a>
                <a class="button" href="aboutUs.html">About us</a>
                <a class="button" href="contactUs.html">Contact us</a>
            </nav>
            <div class="profileContainer">
                <div class="profile">
                    <div class="profile-img">
                        <h3 class="pofileTitles">Profile Picture:</h3>
                        <img class="userPFP" src="images/userPFP/<?php echo $user['pfp'] ?>" alt="profile picture">
                        <!-- <label for="uploadInput"> -->
                        <svg id="editPFP" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi editProfileTitles bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                        </svg>
                        <!-- </label> -->
                        <input type="file" id="uploadInput" style="display: none;" accept="image/*">
                        <button id="savePFP">Save</button>
                    </div>
                    <div class="profile-info">
                        <h1 class="pofileTitles">Username:
                            <input disabled id="editUsernameBar" value="<?php echo $user['username'] ?>" type="text">
                            <svg id="editUsernameBtn" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi editProfileTitles bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg><span style="font-size: 10px;color: gray;margin-left: 5px;">(click again to submit)</span>
                        </h1>
                        <h2 class="pofileTitles">Email:
                            <input disabled id="editEmailBar" value="<?php echo $user['email'] ?>" type="text">
                            <svg id="editEmailBtn" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi editProfileTitles bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg><span style="font-size: 10px;color: gray;margin-left: 5px;">(click again to submit)</span>
                        </h2>
                        <div class="changePassword">
                            <h2>Change Password:</h2>
                            <div class="passwordInputDiv">
                                <h4 class="pofileTitles">Current Password:</h4>
                                <div class="passwordInput2"><input class="passwordInput" id="currentPassword" type="password"></div>
                            </div>
                            <div class="passwordInputDiv">
                                <h4 class="pofileTitles">New Password: </h4>
                                <div class="passwordInput2"><input class="passwordInput" id="newPassword" type="password"></div>
                            </div>
                            <div class="passwordInputDiv">
                                <h4 class="pofileTitles">Confirm Password: </h4>
                                <div class="passwordInput2"><input class="passwordInput" id="confirmPassword" type="password"></div>
                            </div>
                            <button onclick="changePassword()" id="changePasswordBtn">Change Password</button>
                        </div>
                    </div>
                </div>
                <div class="funds">
                    <h1 class="pofileTitles">Funds:<span id="amount">
                            <?php
                            $sql = "SELECT * FROM `wallet` WHERE u_id = '$_SESSION[user_id]'";
                            $result = mysqli_query($con, $sql);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $wallet = mysqli_fetch_array($result);
                                echo $wallet['amount'];

                            ?>
                                $</span>
                    </h1>
                    <div action="addFunds.php">
                        <input id="addFundsBar" type="number" name="funds" id="funds" placeholder="Enter funds">
                        <input id="addFundsBtn" type="submit" value="Add Funds">
                    </div>
                <?php
                            } else {
                                echo '<div id="noWallet" style="display:flex;flex-direction:column;">You Don\'t have a wallet yet<div>';
                ?>

                    <button id="createWallet">Create a Wallet</button>
                </div>
            </div>
        <?php
                            }
        ?>
        </div>
    </div>
    </div>
</body>
<script src="script.js" defer></script>
<script>
    //! Change Profile Picture

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $fileName = $_SESSION['user_id'] . '_' . basename($file['name']);
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];

            if ($fileError === 0) {
                $uploadDir = 'images/userPFP/';
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    $sql = "UPDATE `user` SET `pfp` = '$fileName' WHERE `user`.`id` = '$_SESSION[user_id]'";
                    mysqli_query($con, $sql);
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }
            } else {
                http_response_code(500);
            }
        }
    }
    ?>

    const editPFP = document.getElementById("editPFP");
    const uploadInput = document.getElementById("uploadInput");
    const saveButton = document.getElementById("savePFP");

    editPFP.addEventListener("click", () => {
        uploadInput.click();
    });

    uploadInput.addEventListener("change", () => {
        const selectedFile = uploadInput.files[0];
        if (selectedFile) {
            if (!selectedFile.type.startsWith('image/')) {
                alert('Wrong file type. Please select an image file.');
            } else {
                const userPFP = document.querySelector(".userPFP");
                userPFP.src = URL.createObjectURL(selectedFile);
            }
        }
    });


    saveButton.addEventListener("click", () => {
        const selectedFile = uploadInput.files[0];
        if (!selectedFile) {
            alert('Please select a file.');
        } else {
            if (!selectedFile.type.startsWith('image/')) {
                alert('Wrong file type. Please select an image file.');
            } else {
                const formData = new FormData();
                formData.append('file', selectedFile);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'profile.php');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert("Profile Picture Changed Successfully");
                        } else {
                            alert('Error changing the Profile Picture please try again later');
                        }
                    }
                };
                xhr.send(formData);
            }
        }
    });
</script>


</html>