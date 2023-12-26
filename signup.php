<?php
session_start();
require 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Games Galaxy - Sign Up</title>
</head>

<body>
    <div class="spinner"></div>
    <div class="content" style="display: none">
        <div class="container">
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
            <div class="container-login" method="post">
                <div class="input-container">
                    <div class="input-content">
                        <div class="input-dist">
                            <div class="input-type">
                                <input class="input-is" id="username" type="text" placeholder="Username" />
                                <input class="input-is" id="password" type="password" placeholder="Password" />
                                <input class="input-is" id="re_password" type="password" placeholder="Confirm Password" />
                                <input class="input-is" id="email" type="email" placeholder="E-Mail" />
                                <div class="first_last_name">
                                    <input class="input-is" id="fname" type="text" placeholder="First Name" />
                                    <input class="input-is" id="lname" type="text" placeholder="Last Name" />
                                </div>
                                <input class="input-is" id="dob" type="date" placeholder="Birthdate" />
                            </div>
                        </div>
                    </div>
                    <div class="error-container">
                        <span id="error" class="error"></span>
                    </div>
                    <div class="error-container" style="color: white; margin: 50px 0 10px 0;">
                        <span>already have an account?<a style="color: #9e30a9; " href="login.php"> Log In</a></span>
                    </div>
                    <button onclick="signupProcess()" name="submit" class="submit-button">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    function signupProcess() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var re_password = document.getElementById("re_password").value;
        var email = document.getElementById("email").value;
        var fname = document.getElementById("fname").value;
        var lname = document.getElementById("lname").value;
        var dob = document.getElementById("dob").value;
        var error = document.getElementById("error");
        var ready = 0;
        if (username == "") {
            error.innerHTML = "Username can't be empty";
        } else if (password == "") {
            error.innerHTML = "Password can't be empty";
        } else if (re_password == "") {
            error.innerHTML = "Confirm Password can't be empty";
        } else if (password.length < 8 || !/\d/.test(password)) {
            error.innerHTML = "Password should be at least 8 characters long and should contain at least 1 number";
        } else if (re_password != password) {
            error.innerHTML = "Password and Confirm Password should be the same";
        } else if (email == "") {
            error.innerHTML = "Email can't be empty";
        } else if (!email.includes("@") || !email.includes(".")) {
            error.innerHTML = "Invalid email format";
        } else if (fname == "") {
            error.innerHTML = "First Name can't be empty";
        } else if (lname == "") {
            error.innerHTML = "Last Name can't be empty";
        } else if (dob == "") {
            error.innerHTML = "Date of Birth can't be empty";
        } else {
            ready = 1;
        }
        if (ready === 1) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == "Username Already Taken") {
                        error.innerHTML = "Username Already Taken";
                    } else if (this.responseText == "Email Already Taken") {
                        error.innerHTML = "Email Already Taken";
                    } else {
                        window.location.href = "index.php";
                    }
                }
            };
            xhttp.open("POST", "signupProcess.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("username=" + username + "&password=" + password + "&email=" + email + "&fname=" + fname + "&lname=" + lname + "&dob=" + dob);
        }
    }
</script>
<script src="script.js"></script>

</html>