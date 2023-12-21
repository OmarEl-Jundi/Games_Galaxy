<?php include("connection.php");
session_start();
if (!isset($_GET['gameID'])) {
    header("Location: shop.php");
} else {
    $gameID = $_GET['gameID'];
    //add view to the game
    $sql = "UPDATE games SET views = views + 1 WHERE id = '$gameID'";
    mysqli_query($con, $sql);

    $sql = "SELECT * FROM games WHERE id = '$gameID'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $description = $row['description'];
    $irailer = $row['trailer'];
    $image = $row['image'];
    $rating = $row['rating'];
    $rate_count = $row['rate_count'];
    $categoryID = $row['category'];
    $developerID = $row['developer'];

    $sql = "SELECT * FROM category WHERE id = '$categoryID' ";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $category = $row['name'];
    $categoryDescription = $row['description'];

    $sql = "SELECT * FROM developer WHERE id = '$developerID' ";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $developer = $row['name'];
    $developerDescription = $row['description'];
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
            <?php if (isset($_SESSION['user_id'])) : ?>
                <div class="iconCart">
                    <img src="images/logo/cart.png" id="cartIcon" />
                    <div class="totalQuantity">0</div>
                </div>
            <?php else : ?>
                <a href="login.php" id="loginButton" class="auth-button">Log In</a>
                <a href="signup.php" id="signupButton" class="auth-button">Sign Up</a>
            <?php endif ?>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <div class="cartTab">
                    <h2>CART</h2>
                    <div class="listCart">
                        <?php
                        $query = "SELECT user.*, games.*,games.id AS game_id FROM cart JOIN user ON cart.u_id = user.id JOIN games ON cart.g_id = games.id where user.id = '$_SESSION[user_id]' order by games.name asc";
                        $result = mysqli_query($con, $query);
                        while ($games = mysqli_fetch_array($result)) : ?>
                            <div class="item">
                                <img src="images/games/<?= $games['image'] ?>" alt="" />
                                <div class="cartContent">
                                    <div class="name"><?= $games['name'] ?></div>
                                    <div class="price">
                                        <?php echo ($games['price'] == 0) ? 'Free!' : ('$' . $games['price']); ?>
                                    </div>
                                </div>
                                <button class="RemoveFromCartBtn" data-game-id="<?= $games['game_id'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M16 6v-4a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v4"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                        <path d="M5 6L5 18a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2L19 6"></path>
                                        <path d="M9 3v1M15 3v1"></path>
                                    </svg>
                                </button>
                            </div>
                        <?php endwhile; ?>
                        <div class="totalCartPrice">Total:$
                            <?php
                            $userID = $_SESSION['user_id'];
                            $query = "SELECT SUM(games.price) AS total_price FROM cart INNER JOIN games ON cart.g_id = games.id WHERE cart.u_id = '$userID'";
                            $result = mysqli_query($con, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $totalPrice = $row['total_price'];
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
            <?php endif ?>
            <div class="my-body">
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
            </div>
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

            <div class="gameDescription">
                <div class="gameImage">
                    <div style="position: fixed; right: 1%" class="addToWhishListBtn" data-game-id="<?= $gameID ?>">
                        <button style="position: static;" class="SaveToWishlistBtn" data-game-id="<?= $games['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                                <path d="M18 2H6a2 2 0 0 0-2 2v16l7-3 7 3V4a2 2 0 0 0-2-2z"></path>
                            </svg>
                        </button>
                    </div>
                    <img src="images/games/<?= $image ?>" alt="" />
                    <div class="gameTrailer">
                        <iframe style="border-radius: 10px;" width="560" height="365" src="<?= $irailer ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <?php
                $roundedRating = floor($rating);
                echo '<h2>Game Rating:
    <div  class="rating">';
                for ($i = 5; $i >= 1; $i--) {
                    if ($roundedRating == $i) {
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }
                    echo '<input type="radio" id="star' . $i . '" name="rate" value="' . $i . '" ' . $checked . ' disabled' . '/>';
                    echo '<label for="star' . $i . '" title="text"><svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
        </svg></label>';
                }
                echo '</div>
                ' . $rating . '/5 (' . $rate_count . ' raters)
</h2>';
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
                            <button class="CartBtn" data-game-id="<?= $games['id'] ?>">
                                <span class="IconContainer">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart">
                                        <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                                    </svg>
                                </span>
                                <p class="text">Add to Cart</p>
                            </button>
                        </div>
                    </div>
                </div>
                <h2>Want to rate the game yourself?</h2>
                <div class="user_rating">
                    <input type="radio" id="star55" name="user_rate" value="5" />
                    <label for="star55" title="text"><svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg></label>
                    <input type="radio" id="star44" name="user_rate" value="4" />
                    <label for="star44" title="text"><svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg></label>
                    <input type="radio" id="star33" name="user_rate" value="3" />
                    <label for="star33" title="text"><svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg></label>
                    <input type="radio" id="star22" name="user_rate" value="2" />
                    <label for="star22" title="text"><svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg></label>
                    <input type="radio" id="star11" name="user_rate" value="1" />
                    <label for="star11" title="text"><svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg></label>
                </div>
                <button class="submitBtn">
                    Submit
                    <svg fill="white" viewBox="0 0 448 512" height="1em" class="arrow">
                        <path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"></path>
                    </svg>
                </button>

                <h1>Comments</h1>

            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const submitBtn = document.querySelector('.submitBtn');

                submitBtn.addEventListener('click', function() {
                    const selectedRating = document.querySelector('.user_rating input[type="radio"]:checked');
                    if (selectedRating) {
                        const gameId = <?= $gameID ?>;
                        const rating = selectedRating.value;

                        const userId = <?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null' ?>;

                        if (userId) {
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', 'update_rating.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        console.log('Rating updated successfully');
                                        location.reload();
                                    } else {
                                        console.error('Error updating rating');
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
        </script>

    </div>
</body>

<script src="script.js"></script>

</html>