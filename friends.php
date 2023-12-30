<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games Galaxy - Friends</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="spinner"></div>
    <div class="content" style="display: none">
        <div class="container">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a style="margin-right: 100px;" href="logout.php" id="logoutButton" class="auth-button">Logout</a>
                <?php
                $query = "SELECT * FROM `user` WHERE id = '$_SESSION[user_id]'";
                $result = mysqli_query($con, $query);
                $user = mysqli_fetch_array($result);
                $pfp = $user['pfp'];
                ?>
                <a title="Go To Profile Page" href="profile.php"><img src="images/userPFP/<?= $pfp ?>" alt="pfp" class="profileIcon <?php echo 'defaultIcon'; ?>"></a>
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
                            <div id="cart-<?= $games['id'] ?>" class="item">
                                <img src="images/games/<?= $games['image'] ?>" alt="" />
                                <div class="cartContent">
                                    <div class="name"><?= $games['name'] ?></div>
                                    <div class="price">
                                        <?php echo ($games['price'] == 0) ? 'Free!' : ('$' . $games['price']); ?>
                                    </div>
                                </div>
                                <button class="RemoveFromCartBtn" data-game-id="<?= $games['game_id'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="RemoveFromCartSvg feather feather-trash-2">
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
                        <div class="totalCartPrice"><b style="color: #4bacb6;">
                                <?php
                                $userID = $_SESSION['user_id'];
                                $query = "SELECT SUM(games.price) AS total_price FROM cart INNER JOIN games ON cart.g_id = games.id WHERE cart.u_id = '$userID'";
                                $result = mysqli_query($con, $query);

                                if ($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    $totalPrice = $row['total_price'];
                                    echo 'Total: $' . $totalPrice;
                                }
                                ?>
                            </b>
                        </div>
                        <div class="buttons">
                            <div class="close">CLOSE</div>
                            <div class="checkout">
                                <a onclick="checkoutProcess()">CHECKOUT</a>
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
            </div>
            <?php
            $sql = "SELECT
    CASE
        WHEN friends.u1_id = $_SESSION[user_id] THEN friends.u2_id
        ELSE friends.u1_id
    END AS friend_id,
    CASE
        WHEN friends.u1_id = $_SESSION[user_id] THEN u2.pfp
        ELSE u1.pfp
    END AS friend_pfp,
    u1.*, u2.*
FROM friends
JOIN user u1 ON friends.u1_id = u1.id
JOIN user u2 ON friends.u2_id = u2.id
WHERE (friends.u1_id = $_SESSION[user_id] OR friends.u2_id = $_SESSION[user_id]);


";
            $result = mysqli_query($con, $sql);
            $friends = array();
            while ($row = mysqli_fetch_array($result)) {
                $friends[] = $row;
            }
            ?>

            <div class="friends-container">
                <div class="friends-list">
                    <h1>Friends</h1>
                    <?php if (count($friends) == 0) : ?>
                        <p>You don't have any friends yet.</p>
                    <?php endif; ?>
                    <ul class="no-bullets">
                        <?php foreach ($friends as $friend) : ?>
                            <li id="list-friend-<?= $friend['friend_id'] ?>" data-friend-id="<?= $friend['friend_id'] ?>">
                                <img src="images/userPFP/<?= $friend['friend_pfp'] ?>" alt="pfp" class="FriendProfileIcon">
                                <span class="friend_username"><?= $friend['username'] ?></span>
                                <button class="remove-friend-btn">Remove</button>
                                <button class="chat-with-friend">Chat</button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <hr>
                <div class="friendRequestsDiv">
                    <h1>Friend Requests</h1>
                    <?php
                    $sql = "SELECT * FROM friend_request WHERE receiver_id = $_SESSION[user_id]";
                    $result = mysqli_query($con, $sql);
                    $friendRequests = array();
                    while ($row = mysqli_fetch_array($result)) {
                        $friendRequests[] = $row;
                    }

                    if (count($friendRequests) == 0) {
                        echo "<p>You don't have any friend requests.</p>";
                    } else {
                        echo "<ul class='no-bullets'>";
                        foreach ($friendRequests as $friendRequest) {
                            $sql = "SELECT * FROM user WHERE id = $friendRequest[sender_id]";
                            $result = mysqli_query($con, $sql);
                            $sender = mysqli_fetch_assoc($result);
                            echo "<li id='list-friend-request-$sender[id]' data-friend-request-id='$sender[id]'>";
                            echo "<img src='images/userPFP/$sender[pfp]' alt='pfp' class='FriendProfileIcon'>";
                            echo "$sender[username]";
                            echo "<button class='accept-friend-request-btn'>Accept</button>";
                            echo "<button class='decline-friend-request-btn'>Decline</button>";
                            echo "</li>";
                        }
                        echo "</ul>";
                    }
                    ?>
                </div>
                <hr>
                <div class="sentFriendRequest">
                    <h1>Sent Friend Requests</h1>
                    <?php
                    $sql = "SELECT * FROM friend_request WHERE sender_id = $_SESSION[user_id]";
                    $result = mysqli_query($con, $sql);
                    $sentFriendRequests = array();
                    while ($row = mysqli_fetch_array($result)) {
                        $sentFriendRequests[] = $row;
                    }
                    echo "<ul class='no-bullets-sentRequest'>";
                    if (count($sentFriendRequests) == 0) {
                        echo "<p>You haven't sent any friend requests.</p>";
                    } else {

                        foreach ($sentFriendRequests as $sentFriendRequest) {
                            $sql = "SELECT * FROM user WHERE id = $sentFriendRequest[receiver_id]";
                            $result = mysqli_query($con, $sql);
                            $receiver = mysqli_fetch_assoc($result);
                            echo "<li id='list-sent-friend-request-$receiver[id]' data-sent-friend-request-id='$receiver[id]'>";
                            echo "<img src='images/userPFP/$receiver[pfp]' alt='pfp' class='FriendProfileIcon'>";
                            echo "$receiver[username]";
                            echo "<button class='cancel-friend-request-btn'>Cancel</button>";
                            echo "</li>";
                        }
                    }
                    echo "</ul>";
                    ?>
                </div>
                <hr>
                <div class="addFriendDiv">
                    <h1>Add Friend</h1>
                    <div>
                        <input class="searchForFriendBar" type="text" name="username" placeholder="Search by Username" />
                        <ul class="no-bullets-search">
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Chat Modal -->
            <div id="chatModal" class="chat_modal">
                <div class="chat_modal-content">
                    <span class="chat_close">&times;</span>
                    <h2>Chat</h2>
                    <div class="chat-messages">
                        <!-- Chat messages will be displayed here -->
                    </div>
                    <input type="text" id="messageInput" placeholder="Type a message...">
                    <button id="sendMessageBtn">Send</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="script.js"></script>
<script>
    //!Remove Friend
    const removeFriendButtons = document.querySelectorAll(".remove-friend-btn");

    if (removeFriendButtons) {
        removeFriendButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const friendID = button.parentElement.dataset.friendId;
                removeFriend(friendID);
            });
        });
    }

    function removeFriend(friendID) {
        const confirmed = window.confirm(
            "Are you sure you want to remove this friend?"
        );
        if (!confirmed) {
            return;
        }

        const xhr = new XMLHttpRequest();
        const url = "removeFriend.php";
        const params = `friendID=${friendID}`;

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("list-friend-" + friendID).remove();
                } else {
                    alert("Failed to remove friend");
                }
            }
        };

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }

    //!Search For Friend
    const searchForFriendBtn = document.querySelector(".searchForFriendBar");

    if (searchForFriendBtn) {
        searchForFriendBtn.addEventListener("input", () => {
            const username = document.querySelector(".searchForFriendBar").value;
            if (username.length < 1) {
                return;
            } else {
                searchForFriend(username);
            }
        });
    }

    function searchForFriend(username) {
        const xhr = new XMLHttpRequest();
        const url = "searchForFriend.php";
        const params = `username=${username}`;

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const friends = JSON.parse(xhr.responseText);
                    if (friends && friends.length > 0) {
                        const friendList = document.querySelector(".no-bullets-search");
                        friendList.innerHTML = '';
                        friends.forEach(friend => {
                            const friendID = friend.id;
                            const friendUsername = friend.username;
                            const friendPFP = friend.pfp;
                            const friendElement = document.createElement("li");
                            friendElement.id = "list-friend-" + friendID;
                            friendElement.dataset.friendId = friendID;
                            friendElement.innerHTML = `
                            <img src="images/userPFP/${friendPFP}" alt="pfp" class="FriendProfileIcon">
                            <span class="username">${friendUsername}</span>
                            <button class="add-friend-btn">Add</button>
                        `;
                            friendList.appendChild(friendElement);

                            const addFriendBtn = friendElement.querySelector(".add-friend-btn");
                            addFriendBtn.addEventListener("click", () => {
                                addFriend(friendUsername);
                            });
                        });
                    } else {
                        const friendList = document.querySelector(".no-bullets-search");
                        friendList.innerHTML = '';
                        const friendElement = document.createElement("li");
                        friendElement.innerHTML = `
                            <span class="username">No results found</span>
                        `;
                        friendList.appendChild(friendElement);

                    }
                }
            }
        };

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }

    //! Add Friend
    function addFriend(username) {
        const xhr = new XMLHttpRequest();
        const url = "addFriend.php";
        const params = `username=${username}`;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const sentFriendRequest = JSON.parse(xhr.responseText);
                    if (sentFriendRequest) {
                        const sentFriendRequestList = document.querySelector(".no-bullets-sentRequest");
                        const sentFriendRequestElement = document.createElement("li");
                        sentFriendRequestElement.id = "list-sent-friend-request-" + sentFriendRequest.id;
                        sentFriendRequestElement.dataset.sentFriendRequestId = sentFriendRequest.id;
                        sentFriendRequestElement.innerHTML = `
                            <img src="images/userPFP/${sentFriendRequest.pfp}" alt="pfp" class="FriendProfileIcon">
                            <span class="username">${sentFriendRequest.username}</span>
                            <button class="cancel-friend-request-btn">Cancel</button>
                        `;
                        if (sentFriendRequestList.querySelector("p")) {
                            sentFriendRequestList.querySelector("p").remove();
                        }
                        sentFriendRequestList.appendChild(sentFriendRequestElement);

                        document.querySelector(".searchForFriendBar").value = '';
                        document.querySelector(".no-bullets-search").innerHTML = '';

                        const cancelFriendRequestBtn = sentFriendRequestElement.querySelector(".cancel-friend-request-btn");
                        cancelFriendRequestBtn.addEventListener("click", () => {
                            cancelFriendRequest(sentFriendRequest.id);
                        });
                    }
                } else if (xhr.status === 201) {
                    const friend = JSON.parse(xhr.responseText);
                    if (friend) {
                        const friendList = document.querySelector(".no-bullets");
                        const friendElement = document.createElement("li");
                        friendElement.id = "list-friend-" + friend.id;
                        friendElement.dataset.friendId = friend.id;
                        friendElement.innerHTML = `
                            <img src="images/userPFP/${friend.pfp}" alt="pfp" class="FriendProfileIcon">
                            <span class="username">${friend.username}</span>
                            <button class="remove-friend-btn">Remove</button>
                            <button class="chat-with-friend">Chat</button>
                        `;
                        if (friendList.querySelector("p")) {
                            friendList.querySelector("p").remove();
                        }
                        friendList.appendChild(friendElement);

                        document.querySelector(".searchForFriendBar").value = '';
                        document.querySelector(".no-bullets-search").innerHTML = '';

                        document.getElementById("list-friend-request-" + friend.id).remove();
                        if (document.querySelector(".friendRequestsDiv").querySelector("ul").querySelector("li") == null) {
                            document.querySelector(".friendRequestsDiv").querySelector("ul").innerHTML = "<p>You don't have any friend requests.</p>";
                        }

                        const removeFriendBtn = friendElement.querySelector(".remove-friend-btn");
                        removeFriendBtn.addEventListener("click", () => {
                            removeFriend(friend.id);
                        });
                    }
                }
            }
        };

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }

    //! Cancel Friend Request

    const cancelFriendRequestBtns = document.querySelectorAll(".cancel-friend-request-btn");

    if (cancelFriendRequestBtns) {
        cancelFriendRequestBtns.forEach((button) => {
            button.addEventListener("click", () => {
                const sentFriendRequestID = button.parentElement.dataset.sentFriendRequestId;
                cancelFriendRequest(sentFriendRequestID);
            });
        });
    }

    function cancelFriendRequest(sentFriendRequestID) {
        const xhr = new XMLHttpRequest();
        const url = "cancelFriendRequest.php";
        const params = `sentFriendRequestID=${sentFriendRequestID}`;
        console.log(sentFriendRequestID);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("list-sent-friend-request-" + sentFriendRequestID).remove();
                    if (document.querySelector(".sentFriendRequest").querySelector("ul").querySelector("li") == null) {
                        document.querySelector(".sentFriendRequest").querySelector("ul").innerHTML = "<p>You haven't sent any friend requests.</p>";
                    }
                }
            }
        };

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }

    //!Accept Friend Request
    const acceptFriendRequestBtns = document.querySelectorAll(".accept-friend-request-btn");

    if (acceptFriendRequestBtns) {
        acceptFriendRequestBtns.forEach((button) => {
            button.addEventListener("click", () => {
                const friendRequestID = button.parentElement.dataset.friendRequestId;
                acceptFriendRequest(friendRequestID);
            });
        });
    }

    function acceptFriendRequest(friendRequestID) {
        const xhr = new XMLHttpRequest();
        const url = "acceptFriendRequest.php";
        const params = `friendRequestID=${friendRequestID}`;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const friend = JSON.parse(xhr.responseText);
                    console.log(xhr.responseText);
                    if (friend) {
                        const friendList = document.querySelector(".no-bullets");
                        const friendElement = document.createElement("li");
                        friendElement.id = "list-friend-" + friend.id;
                        friendElement.dataset.friendId = friend.id;
                        friendElement.innerHTML = `
                            <img src="images/userPFP/${friend.pfp}" alt="pfp" class="FriendProfileIcon">
                            <span class="username">${friend.username}</span>
                            <button class="remove-friend-btn">Remove</button>
                            <button class="chat-with-friend">Chat</button>
                        `;
                        if (friendList.querySelector("p")) {
                            friendList.querySelector("p").remove();
                        }
                        friendList.appendChild(friendElement);

                        document.getElementById("list-friend-request-" + friend.id).remove();
                        if (document.querySelector(".friendRequestsDiv").querySelector("ul").querySelector("li") == null) {
                            document.querySelector(".friendRequestsDiv").querySelector("ul").innerHTML = "<p>You don't have any friend requests.</p>";
                        }

                        const removeFriendBtn = friendElement.querySelector(".remove-friend-btn");
                        removeFriendBtn.addEventListener("click", () => {
                            removeFriend(friend.id);
                        });
                    }
                } else {
                    alert(xhr.responseText);
                }
            }
        };

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }

    //!Decline Friend Request
    const declineFriendRequestBtns = document.querySelectorAll(".decline-friend-request-btn");

    if (declineFriendRequestBtns) {
        declineFriendRequestBtns.forEach((button) => {
            button.addEventListener("click", () => {
                const friendRequestID = button.parentElement.dataset.friendRequestId;
                declineFriendRequest(friendRequestID);
            });
        });
    }

    function declineFriendRequest(friendRequestID) {
        const xhr = new XMLHttpRequest();
        const url = "declineFriendRequest.php";
        const params = `friendRequestID=${friendRequestID}`;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("list-friend-request-" + friendRequestID).remove();
                    if (document.querySelector(".friendRequestsDiv").querySelector("ul").querySelector("li") == null) {
                        document.querySelector(".friendRequestsDiv").querySelector("ul").innerHTML = "<p>You don't have any friend requests.</p>";
                    }
                }
            }
        };

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }

    //!chat
    const chatModal = document.getElementById('chatModal');
    const chatBtns = document.querySelectorAll('.chat-with-friend');
    const closeChatBtn = document.querySelector('.chat_close');
    const sendMessageBtn = document.getElementById('sendMessageBtn');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.querySelector('.chat-messages');

    // Open the chat modal when clicking "Chat" buttons
    chatBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const FriendID = btn.parentElement.dataset.friendId;
            const FriendUsername = btn.parentElement.querySelector('.friend_username').innerHTML;
            chatModal.querySelector('h2').innerHTML = `${FriendUsername}`;
            chatModal.dataset.friendId = FriendID;
            chatMessages.innerHTML = '';
            getChatHistory(FriendID);
            chatModal.style.display = 'block';
        });
    });

    function getChatHistory(friendID) {
        const xhr = new XMLHttpRequest();
        const url = "getChatHistory.php";
        const params = `friendID=${friendID}`;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const chatHistory = xhr.responseText;
                    if (chatHistory) {
                        chatMessages.innerHTML = chatHistory;
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                } else if (xhr.status === 404) {
                    chatMessages.innerHTML = '<p>No chat history found</p>';
                }
            }
        };

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }

    closeChatBtn.addEventListener('click', () => {
        chatModal.style.display = 'none';
        chatMessages.innerHTML = '';
    });

    sendMessageBtn.addEventListener('click', () => {
        const message = messageInput.value.trim();
        if (message !== '') {
            // chatMessages.innerHTML += `<div>You: ${message}</div>`;
            // messageInput.value = '';
            // chatMessages.scrollTop = chatMessages.scrollHeight;
            const friendID = chatModal.dataset.friendId;
            sendMessage(friendID, message);
        } else {
            alert('Please enter a message');
        }
    });

    function sendMessage(friendID, message) {
        const xhr = new XMLHttpRequest();
        const url = "sendMessage.php";
        const params = `friendID=${friendID}&message=${message}`;
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    getChatHistory(friendID);
                } else {
                    alert(xhr.responseText);
                }
            }
        };

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }
</script>

</html>