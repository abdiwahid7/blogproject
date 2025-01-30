<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<header>
    <div class="logo">
        <h1>My Blog</h1>
    </div>
    <nav>
        <ul>
            <li><a href="auth/register.php">Sign Up</a></li>
            <li><a href="auth/login.php">Login</a></li>
            <li><a href="pages/dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
</header>

<main>
    <h2>Recent Posts</h2>
    <ul>
        <?php
        include 'includes/db.php'; // Include database connection

        // Fetch recent posts
        $stmt = $conn->query("SELECT id, title, created_at FROM posts ORDER BY created_at DESC LIMIT 5");
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($posts as $post) {
            echo '<li><a href="pages/post.php?id=' . $post['id'] . '">' . htmlspecialchars($post['title']) . '</a> - ' . date("F j, Y", strtotime($post['created_at'])) . '</li>';
        }
        ?>
    </ul>
</main>

<footer>
    <p>&copy; 2025 My Blog. All Rights Reserved.</p>
</footer>
</body>
</html>