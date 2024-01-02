<?php
$con = new mysqli("localhost", "root", "", "gamesgalaxy");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
