<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/Blogproject/css/style.css">
    </head>
<body>

<div class="register-container">
    <h2>Register</h2>

    <!-- Display error message if any -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <br>
        <label>Username:</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <br><br>
        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter email" required>

        <br><br>
        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <br><br>
        <button type="submit">Register</button>
    </form> <p>Already have an account? <a href="login.php">Login here</a></p>
    
</div>

</body>
</html>


<?php
// Include database connection
include '../includes/db.php';

// Initialize error message
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Check if email already exists
            $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $query->execute([$email]);

            if ($query->rowCount() > 0) {
                $error = "Email is already registered!";
            } else {
                // Insert new user
                $query = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
                if ($query->execute([$username, $email, $hashedPassword])) {
                    header("Location: login.php"); // Redirect to login
                    exit();
                } else {
                    $error = "Registration failed!";
                }
            }
        } catch (Exception $e) {
            $error = "Something went wrong. Try again!";
        }
    }
}
?>


