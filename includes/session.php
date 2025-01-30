<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// Ensure user remains logged in
function isLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        die("User is not logged in. Redirecting...");
        header("Location: ../auth/login.php");
        exit();
    }
}

// Ensure user is an admin
function isAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        die("User is not an admin. Redirecting...");
        header("Location: ../auth/login.php");
        exit();
    }
}
?>
