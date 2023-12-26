<?php
require 'connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);

    $query = "SELECT * FROM `User` WHERE `username` = '$username'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "Username Already Taken";
        exit();
    }

    $query = "SELECT * FROM `User` WHERE `email` = '$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "Email Already Taken";
        exit();
    }

    $query = "INSERT INTO `User`(`username`, `email`, `password`, `date_of_birth`, `fname`, `lname`, `role`) VALUES ( '$username', '$email', '$password', '$dob', '$fname', '$lname' , '2')";
    if (mysqli_query($con, $query)) {
        echo "Account successfully created you can now login";

        session_start();
        $query = "SELECT * FROM `User` WHERE `username` = '$username'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);

        $_SESSION['username'] = $username;
        $_SESSION['role'] = 2;
        $_SESSION["user_id"] = $row['id'];
        exit();
    } else {
        echo "Error executing query: " . mysqli_error($con);
        exit();
    }
}
