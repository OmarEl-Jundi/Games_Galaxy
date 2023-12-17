<?php include("connection.php");
session_start()
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
    <div class="content" style="display: none">
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

      <!-- Search Bar -->
      <div class="search-center-div">
        <div class="input__container">
          <div class="shadow__input"></div>
          <button onclick="search()" class="input__button__shadow">
            <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="20px" width="20px">
              <path d="M4 9a5 5 0 1110 0A5 5 0 014 9zm5-7a7 7 0 104.2 12.6.999.999 0 00.093.107l3 3a1 1 0 001.414-1.414l-3-3a.999.999 0 00-.107-.093A7 7 0 009 2z" fill-rule="evenodd" fill="#17202A"></path>
            </svg>
          </button>
          <input type="search" name="text" class="input__search" id="searchInput" placeholder="Search for games..." />
          <button id="x-searchIcon" onclick="clearSearch()" class="input__button__shadow">
            <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="20px" width="20px">
              <path fill="#17202A" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
            </svg>
          </button>
        </div>
      </div>
      <script>
        function clearSearch() {
          document.getElementById('searchInput').value = '';
          search();
          hideSearchbar();
        }
      </script>

      <!-- Products Section -->
      <div class="products-grid">
        <!-- Sample product, repeat as needed -->
        <?php
        $query = "SELECT * FROM `games` order by name asc";
        $result = mysqli_query($con, $query);
        while ($games = mysqli_fetch_array($result)) : ?>
          <div class="product-card">
            <img src="images/games/<?= $games['image'] ?>" alt="Product Name" />
            <div class="product-info">
              <h3><?= $games['name'] ?></h3>
              <span class="info-price">
                <?php echo ($games['price'] == 0) ? 'Free!' : ('$' . $games['price']); ?>
              </span>
              <div class="product-actions">
                <button class="CartBtn" data-game-id="<?= $games['id'] ?>">
                  <span class="IconContainer">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart">
                      <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                    </svg>
                  </span>
                  <p class="text">Add to Cart</p>
                </button>
                <div class="view-counter">
                  <span class="view-icon">&#128065;</span>
                  <span class="counter">123</span>
                </div>
                <button class="SaveToWishlistBtn" data-game-id="<?= $games['id'] ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                    <path d="M18 2H6a2 2 0 0 0-2 2v16l7-3 7 3V4a2 2 0 0 0-2-2z"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
  <script>
    window.addEventListener("load", function() {
      document.querySelector(".content").style.display = "block";
    });
  </script>
  <script>

  </script>
</body>

</html>