<?php
header("Access-Control-Allow-Origin: *");
header("ACcess-Control-Allow-Methods: GET,POST");
header("Access-Control-Allow-Headers:Content-Type");
include "connection.php";
session_start();
if (!isset($_GET["gameID"])) {
    header("Location: shop.php");
} else {
    $gameID = $_GET["gameID"];
    //add view to the game
    $sql = "UPDATE games SET views = views + 1 WHERE id = '$gameID'";
    mysqli_query($con, $sql);

    $sql = "SELECT g.*,r.*, COUNT(r.rating) AS rate_count,AVG(rating) AS average_rating
            FROM games g
            LEFT JOIN rating r ON g.id = r.g_id
            WHERE g.id = '$gameID'
            GROUP BY g.id;

";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row["name"];
    $description = $row["description"];
    $irailer = $row["trailer"];
    $image = $row["image"];
    $rating = $row["average_rating"];
    $rate_count = $row["rate_count"];
    $categoryID = $row["category"];
    $developerID = $row["developer"];

    $sql = "SELECT * FROM category WHERE id = '$categoryID' ";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $category = $row["name"];
    $categoryDescription = $row["description"];

    $sql = "SELECT * FROM developer WHERE id = '$developerID' ";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $developer = $row["name"];
    $developerDescription = $row["description"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Games Galaxy - Shop</title>
</head>

<body>
    <div class="spinner"></div>
    <div class="content" style="display: none">

        <div class="container">
            <?php if (isset($_SESSION["user_id"])) : ?>
            <a style="margin-right: 100px;" href="logout.php" id="logoutButton" class="auth-button">Logout</a>
            <?php
                $query = "SELECT * FROM `user` WHERE id = '$_SESSION[user_id]'";
                $result = mysqli_query($con, $query);
                $user = mysqli_fetch_array($result);
                $pfp = $user['pfp'];
                ?>
            <a href="profile.php"><img src="images/userPFP/<?= $pfp ?>" alt="pfp"
                    class="profileIcon <?php echo 'defaultIcon'; ?>"></a>
            <div class="iconCart">
                <img src="images/logo/cart.png" id="cartIcon" />
                <div class="totalQuantity">0</div>
            </div>
            <?php else : ?>
            <a href="login.php" id="loginButton" class="auth-button">Log In</a>
            <a href="signup.php" id="signupButton" class="auth-button">Sign Up</a>
            <?php endif; ?>
            <?php if (isset($_SESSION["user_id"])) : ?>
            <div class="cartTab">
                <h2>CART</h2>
                <div class="listCart">
                    <?php
                        $query = "SELECT user.*, games.*,games.id AS game_id FROM cart JOIN user ON cart.u_id = user.id JOIN games ON cart.g_id = games.id where user.id = '$_SESSION[user_id]' order by games.name asc";
                        $result = mysqli_query($con, $query);
                        while ($games = mysqli_fetch_array($result)) : ?>
                    <div class="item">
                        <img src="images/games/<?= $games["image"] ?>" alt="" />
                        <div class="cartContent">
                            <div class="name"><?= $games["name"] ?></div>
                            <div class="price">
                                <?php echo $games["price"] == 0
                                            ? "Free!"
                                            : '$' . $games["price"]; ?>
                            </div>
                        </div>
                        <button class="RemoveFromCartBtn" data-game-id="<?= $gameID ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="red"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M16 6v-4a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v4"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                <path d="M5 6L5 18a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2L19 6"></path>
                                <path d="M9 3v1M15 3v1"></path>
                            </svg>
                        </button>
                    </div>
                    <?php endwhile;
                        ?>
                    <div class="totalCartPrice">Total:$
                        <?php
                            $userID = $_SESSION["user_id"];
                            $query = "SELECT SUM(games.price) AS total_price FROM cart INNER JOIN games ON cart.g_id = games.id WHERE cart.u_id = '$userID'";
                            $result = mysqli_query($con, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $totalPrice = $row["total_price"];
                                echo $totalPrice;
                            }
                            ?>
                    </div>
                    <div class="buttons">
                        <div class="close">CLOSE</div>
                        <div class="checkout">
                            <a href="checkout_process.php">CHECKOUT</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="my-body">
                <div class="darkThemeBtn">
                    <input id="darkmode-toggle" type="checkbox" />
                    <label for="darkmode-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="sun">
                            <g transform="translate(0 512) scale(.1 -.1)">
                                <path
                                    d="m2513 5105c-59-25-63-46-63-320 0-266 4-288 54-315 33-17 79-17 112 0 50 27 54 49 54 315 0 275-4 295-65 321-42 17-51 17-92-1z">
                                </path>
                                <path
                                    d="m754 4366c-28-28-34-41-34-77 0-42 3-45 188-231l187-188h47c39 0 52 5 77 31 26 25 31 38 31 77v47l-188 187c-186 185-189 188-231 188-36 0-49-6-77-34z">
                                </path>
                                <path
                                    d="m4058 4212-188-187v-47c0-39 5-52 31-77 25-26 38-31 77-31h46l188 188c186 186 188 188 188 231 0 36-6 49-34 77s-41 34-77 34c-42 0-45-3-231-188z">
                                </path>
                                <path
                                    d="m2440 4224c-453-50-760-192-1056-488-264-264-419-570-475-936-17-109-17-371 0-480 56-366 211-672 475-936s570-419 936-475c109-17 371-17 480 0 366 56 672 211 936 475 225 225 358 455 438 758 38 143 50 249 50 418 0 219-30 388-104 590-137 372-450 719-813 901-143 72-315 128-474 154-89 15-329 26-393 19zm335-235c305-46 582-186 805-409 567-567 567-1473 0-2040s-1473-567-2040 0-567 1473 0 2040c328 328 777 476 1235 409z">
                                </path>
                                <path
                                    d="m54 2651c-20-12-37-34-44-55-16-49 2-101 44-127 28-17 52-19 279-19 268 0 289 4 317 54 17 33 17 79 0 112-28 50-49 54-317 54-227 0-251-2-279-19z">
                                </path>
                                <path
                                    d="m4512 2657c-73-41-73-155 0-193 21-11 81-14 275-14 227 0 251 2 279 19 42 26 60 78 44 127-7 21-24 43-44 55-28 17-52 19-281 19-181-1-256-4-273-13z">
                                </path>
                                <path
                                    d="m908 1062c-185-186-188-189-188-231 0-36 6-49 34-77s41-34 77-34c43 0 45 2 231 188l188 188v46c0 39-5 52-31 77-25 26-38 31-77 31h-47l-187-188z">
                                </path>
                                <path
                                    d="m3901 1219c-26-25-31-38-31-77v-47l188-187c186-185 189-188 231-188 36 0 49 6 77 34s34 41 34 77c0 43-2 45-188 231l-188 188h-46c-39 0-52-5-77-31z">
                                </path>
                                <path
                                    d="m2540 663c-87-28-90-37-90-330 0-227 2-251 19-279 40-66 142-66 182 0 17 28 19 52 19 279 0 266-4 291-52 314-32 16-60 22-78 16z">
                                </path>
                            </g>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="moon">
                            <g transform="translate(0 512) scale(.1 -.1)">
                                <path
                                    d="m2090 5105c-248-51-443-118-659-226-514-256-909-652-1161-1163-94-191-139-311-185-490-127-500-110-999 51-1468 133-389 331-706 624-998 403-404 875-642 1460-736 147-24 529-24 693 0 539 78 981 283 1390 644 362 319 647 793 766 1270 46 186 56 256 42 299-22 71-80 116-151 117-73 1-104-19-181-116-307-390-733-627-1233-689-119-14-385-7-501 15-582 106-1066 469-1321 991-120 246-171 452-181 731-21 586 230 1126 695 1493 96 75 117 107 117 177 0 85-67 155-153 160-26 1-76-3-112-11zm110-149c0-2-26-23-57-47-81-60-254-230-325-318-213-264-353-573-415-916-22-126-25-508-5-625 62-346 195-651 395-910 72-93 228-250 327-329 266-213 571-349 930-413 117-20 499-17 625 5 343 62 652 202 916 415 88 71 258 244 318 325 24 32 46 56 48 54s-8-60-23-128c-127-606-501-1155-1027-1505-780-521-1798-535-2602-36-295 183-594 482-777 777-335 539-445 1180-308 1795 138 621 515 1158 1060 1511 136 88 374 201 530 253 148 49 390 106 390 92z">
                                </path>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi friendsIcon bi-people-fill" viewBox="0 0 16 16">
                        <path
                            d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
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
            </div>
            <div class="logo">
                <img src="images/logo/Games-galaxy-Logo-transformed.png" />
            </div>
            <a id="goback" style="color: #4bacb6;">Go Back</a>
            <script>
            document.getElementById("goback").addEventListener("click", () => {
                history.back();
            })
            </script>
            <nav>
                <a class="button" href="index.php">Home</a>
                <a class="button" href="shop.php">Shop</a>
                <a class="button" href="library.php">Library</a>
                <a class="button" href="whishList.php">Whish List</a>
                <a class="button" href="aboutUs.html">About us</a>
                <a class="button" href="contactUs.html">Contact us</a>
            </nav>

            <div class="gameDescription">
                <div class="gameImage">
                    <div style="position: fixed; right: 1%" class="addToWhishListBtn" data-game-id="<?= $gameID ?>">
                        <button style="position: static;" class="SaveToWishlistBtn" data-game-id="<?= $gameID ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-save">
                                <path d="M18 2H6a2 2 0 0 0-2 2v16l7-3 7 3V4a2 2 0 0 0-2-2z"></path>
                            </svg>
                        </button>
                    </div>
                    <img src="images/games/<?= $image ?>" alt="" />
                    <div class="gameTrailer">
                        <iframe style="border-radius: 10px;" width="560" height="365" src="<?= $irailer ?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>
                <?php
                $roundedRating = floor($rating);
                echo '<h2 id="game_rating_title">Game Rating:
    <div  class="rating">';
                for ($i = 5; $i >= 1; $i--) {
                    if ($roundedRating == $i) {
                        $checked = "checked";
                    } else {
                        $checked = "";
                    }
                    echo '<input class="averageRating" type="radio" id="star' .
                        $i .
                        '" name="rate" value="' .
                        $i .
                        '" ' .
                        $checked .
                        " disabled" .
                        "/>";
                    echo '<label for="star' .
                        $i .
                        '" title="text"><svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
        </svg></label>';
                }
                echo '</div><span id="averageRating">' .
                    $rating .
                    '</span>/5 (<span id="raters">' .
                    $rate_count .
                    "</span> raters)</h2>";
                ?>

                <div class="gameInfo">
                    <h1 class="gameName"><?= $name ?></h1>
                    <div class="gameDescription"><?= $description ?></div>
                    <h3>Category: <?= $category ?></h3>
                    <div class="categoryDescription"><?= $categoryDescription ?></div>
                    <h3>Developer: <?= $developer ?></h3>
                    <div class="developerDescription"><?= $developerDescription ?></div>
                    <div class="gameButtons">
                        <div style="margin: 40px;" class="addToCartBtn" data-game-id="<?= $gameID ?>">
                            <button class="CartBtn" data-game-id="<?= $gameID ?>">
                                <span class="IconContainer">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"
                                        fill="rgb(17, 17, 17)" class="cart">
                                        <path
                                            d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z">
                                        </path>
                                    </svg>
                                </span>
                                <p class="text">Add to Cart</p>
                            </button>
                        </div>
                    </div>
                </div>
                <h2>Want to rate the game yourself?</h2>
                <div class="user_rating">
                    <?php
                    if (isset($_SESSION["user_id"])) {
                        $sql = "SELECT * FROM rating WHERE u_id = '$_SESSION[user_id]' AND g_id = '$gameID'";
                        $result = mysqli_query($con, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $userRating = explode(".", $row["rating"])[0];
                        } else {
                            $userRating = 0;
                        }
                    } else {
                        $userRating = 0;
                    }
                    for ($i = 5; $i >= 1; $i--) {
                        if ($userRating == $i) {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }
                        echo " <input " .
                            $checked .
                            ' type="radio" id="star' .
                            $i .
                            $i .
                            '" name="user_rate" value="' .
                            $i .
                            '" />
                        <label for="star' .
                            $i .
                            $i .
                            '" title="text"><svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg></label>
                        ';
                    }
                    ?>
                </div>
                <button class="submitBtn">
                    Submit
                    <svg fill="white" viewBox="0 0 448 512" height="1em" class="arrow">
                        <path
                            d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z">
                        </path>
                    </svg>
                </button>
                <div class="comments">
                    <h1>Comments</h1>
                    <div class="comment_form">
                        <div action="commentProcess.php" method="POST">
                            <label for="comment">Comment:</label><br>
                            <textarea id="comment" cols="50" rows="4"></textarea><br>
                            <input id="gameID" type="hidden" value="<?= $gameID ?>">
                            <button onclick="commentProcess()" id="submitComment"
                                style="padding: 8px 15px; border-radius: 5px; background-color: #007bff; color: #fff; border: none;margin-top:5px;">Submit
                                The Comment</button>
                        </div>
                    </div>
                    <hr>
                    <div class="commentsContainer">
                        <?php
                        $sql = "SELECT c.*, u.username, u.pfp,
                                COUNT(lc.u_id) AS likes, 
                                COUNT(dc.u_id) AS dislikes 
                            FROM comments c 
                            INNER JOIN user u ON c.u_id = u.id 
                            LEFT JOIN like_comment lc ON c.id = lc.c_id 
                            LEFT JOIN dislike_comment dc ON c.id = dc.c_id 
                            WHERE c.g_id = '$gameID'
                            GROUP BY c.id
                            ORDER BY c.date_time DESC;";
                        $result = mysqli_query($con, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $commentID = $row["id"];
                            $username = $row["username"];
                            $pfp = $row["pfp"];
                            $comment = $row["comment"];
                            $date_time = $row["date_time"];
                            $date = date("d/m/Y", strtotime($date_time));
                            $time = date("h:i A", strtotime($date_time));
                            $likes = $row["likes"];
                            $dislikes = $row["dislikes"];
                            if (isset($_SESSION["user_id"])) {
                                $sql_likes = "SELECT * FROM like_comment WHERE u_id = '$_SESSION[user_id]' AND c_id = '$commentID'";
                                $result_likes = mysqli_query($con, $sql_likes);
                                if (mysqli_num_rows($result_likes) > 0) {
                                    $hasLiked = true;
                                } else {
                                    $hasLiked = false;
                                }

                                $sql_dislikes = "SELECT * FROM dislike_comment WHERE u_id = '$_SESSION[user_id]' AND c_id = '$commentID'";
                                $result_dislikes = mysqli_query(
                                    $con,
                                    $sql_dislikes
                                );
                                if (mysqli_num_rows($result_dislikes) > 0) {
                                    $hasDisliked = true;
                                } else {
                                    $hasDisliked = false;
                                }

                                echo '<div id="comment-' .
                                    $commentID .
                                    '" class="comment" >
                        <div class="comment-user-info"><img class="FriendProfileIcon" src="images/userPFP/' . $pfp . '"><div class="comment-user-inner-info"><h2 class="comment_username">' .
                                    $username .
                                    '<div></h2>
                        <h5 class="comment_date">' .
                                    $date .
                                    " at " .
                                    $time .
                                    '</h5>
                        <p class="comment_text">' .
                                    $comment .
                                    '</p></div></div>
                        <div class="comment_likes" >
                            <div  class="comment_like">';
                                echo '
                                <svg id="like-' .
                                    $commentID .
                                    '" data-comment-id="' .
                                    $commentID .
                                    '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up';
                                if ($hasLiked) {
                                    echo " liked";
                                }
                                echo '" viewBox="0 0 16 16">
                                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                </svg>';
                                echo '
                                <p id="like-count-' .
                                    $commentID .
                                    '" class="comment_like_text">' .
                                    $likes .
                                    '</p>
                            </div>
                            <div  class="comment_dislike" >';
                                echo '
                                <svg id="dislike-' .
                                    $commentID .
                                    '" data-comment-id="' .
                                    $commentID .
                                    '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down';
                                if ($hasDisliked) {
                                    echo " disliked";
                                }
                                echo '" viewBox="0 0 16 16">
                                    <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                                </svg>';
                                // }
                                echo '<p id="dislike-count-' .
                                    $commentID .
                                    '" class="comment_dislike_text">' .
                                    $dislikes .
                                    '</p>
                            </div>';
                                if ($username == $_SESSION["username"]) {
                                    echo '
                                <div class="comment_edit">
                                    <svg style="position:relative; top:-25px" data-comment-id="' .
                                        $commentID .
                                        '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi editComment bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </div>
                                ';
                                }
                                if ($username == $_SESSION["username"] || $_SESSION["user_role"] == "1") {
                                    echo '
                                <div class="comment_delete" >
                                    <svg style="position:relative; top:-25px" data-comment-id="' .
                                        $commentID .
                                        '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi deleteComment bi-trash3" viewBox="0 0 16 16">
                                        <path data-comment-id="' .
                                        $commentID .
                                        '" d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                    </svg>
                                </div>';
                                }

                                echo '
                        </div>
                        <hr>
                    </div>
                    ';
                            } else {
                                echo '
                            <div class="comment" >
                        <h2 class="comment_username">' .
                                    $username .
                                    '</h2>
                        <h5 class="comment_date">' .
                                    $date .
                                    " at " .
                                    $time .
                                    '</h5>
                        <p class="comment_text">' .
                                    $comment .
                                    '</p>
                        <div class="comment_likes" >
                            <div class="comment_like">
                            <svg data-comment-id="' .
                                    $commentID .
                                    '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                </svg>
                                <p class="comment_like_text">' .
                                    $likes .
                                    '</p>
                            </div>
                            <div class="comment_dislike" >
                            <svg data-comment-id="' .
                                    $commentID .
                                    '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down" viewBox="0 0 16 16">
                                    <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                                </svg>
                                <p class="comment_dislike_text">' .
                                    $dislikes .
                                    '</p>
                            </div>
                        </div>
                    </div>
                    <hr>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
        //!rating
        document.addEventListener("DOMContentLoaded", function() {
            const submitBtn = document.querySelector('.submitBtn');

            submitBtn.addEventListener('click', function() {
                const checkedInput = document.querySelector('.user_rating input[type="radio"]:checked');

                if (checkedInput) {
                    const selectedRating = parseInt(checkedInput.value, 10);
                    const gameId = <?= $gameID ?>;
                    const rating = selectedRating;
                    const userId = <?= isset($_SESSION["user_id"])
                                            ? $_SESSION["user_id"]
                                            : "null" ?>;

                    if (userId) {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'update_rating.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    const averageRating = document.querySelector('#averageRating');
                                    const newAverageRating = xhr.responseText;
                                    averageRating.textContent = newAverageRating;
                                    const star = parseInt(newAverageRating.split('.')[0], 10);
                                    const stars = document.querySelectorAll(".averageRating");
                                    stars.forEach(star => {
                                        star.checked = false;
                                    });
                                    document.getElementById("star" + star).checked = true;

                                    const xhr2 = new XMLHttpRequest();
                                    xhr2.open('GET', 'get_rate_count.php?gameID=' + gameId, true);
                                    xhr2.onreadystatechange = function() {
                                        if (xhr2.readyState === XMLHttpRequest.DONE) {
                                            if (xhr2.status === 200) {
                                                const rate_count = xhr2.responseText;
                                                document.getElementById("raters").innerHTML =
                                                    rate_count;
                                            } else {
                                                alert('Error getting rate count');
                                            }
                                        }
                                    }
                                    xhr2.send();
                                } else {
                                    alert('Error updating rating');
                                }
                            }
                        };
                        xhr.send(`gameID=${gameId}&userRating=${rating}&userID=${userId}`);
                    } else {
                        alert("You need to login first!");
                        window.location.href = "login.php";
                    }
                } else {
                    alert("Please select a rating!");
                }
            });
        });


        //!Comment
        function commentProcess() {
            const comment = document.getElementById("comment").value;
            const sanitizedComment = sanitizeComment(comment);
            const gameID = document.getElementById("gameID").value;

            if (sanitizedComment) {
                const xhr = new XMLHttpRequest();
                const url = "commentprocess.php";
                const params = `comment=${encodeURIComponent(sanitizedComment)}&gameID=${gameID}`;

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const comment = xhr.responseText;
                            const commentsContainer = document.querySelector(".commentsContainer");
                            commentsContainer.insertAdjacentHTML("afterbegin", comment);
                            document.getElementById("comment").value = "";
                        } else {
                            console.error("Failed to add comment. Status: " + xhr.status);
                            console.error("Response: " + xhr.responseText);
                            alert("Failed to add comment");
                        }
                    }
                };

                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(params);
            } else {
                alert("Please type at least one letter or number in your comment.");
            }
        }
        </script>
        <!-- Modal HTML -->
        <div id="editCommentModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Comment</h4>
                        <button type="button" class="close_editComment close-btn" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <textarea id="editedComment" rows="4" cols="50"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn close_editComment_Alt close-btn btn-default"
                            data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


</body>

<script src="script.js"></script>

</html>