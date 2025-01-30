<?php
include 'includes/session.php';

if (!isLoggedIn()) {
    header('Location: auth/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<main>
    <h2>Welcome to My Blog</h2>
    <p>Here is some important information for you to read before accessing the categories or posts.</p>
    <p>[Insert your information here]</p>
    <a href="index.php" class="btn">Proceed to Categories and Posts</a>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>