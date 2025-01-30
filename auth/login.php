<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: ../index.php');
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="login-container">
    <form action="login.php" method="post">
        <table>
            <tr>
                <td colspan="2" style="text-align: center;"><h2>Login</h2></td>
            </tr>
            <!-- Display error message if any -->
            <?php if (isset($error)): ?>
                <tr>
                    <td colspan="2" style="text-align: center;"><p class="error"><?php echo $error; ?></p></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" id="email" name="email" placeholder="Enter email" required></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td><input type="password" id="password" name="password" placeholder="Enter password" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><button type="submit">Login</button></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><p>Don't have an account? <a href="register.php">Register here</a></p></td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>