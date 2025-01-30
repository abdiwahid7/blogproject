<?php
session_start();
include 'includes/db.php'; // Include database connection
include 'includes/session.php'; // Include session management
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<main>
    <h2>Recent Posts</h2>
    <ul>
        <?php
        // Fetch recent posts
        $stmt = $conn->query("SELECT id, title, created_at FROM posts ORDER BY created_at DESC LIMIT 5");
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($posts as $post) {
            echo '<li><a href="pages/post.php?id=' . $post['id'] . '">' . htmlspecialchars($post['title']) . '</a> - ' . date("F j, Y", strtotime($post['created_at'])) . '</li>';
        }
        ?>
    </ul>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>