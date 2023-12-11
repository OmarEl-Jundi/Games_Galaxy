<?php
// Create connection
$con = new mysqli("localhost", "root", "", "gamesgalaxy");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
