<?php
session_start();

if (isset($_SESSION['user_id'])) {
    echo 'true'; // User is logged in
} else {
    echo 'false'; // User is not logged in
}
