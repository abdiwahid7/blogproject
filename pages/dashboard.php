<?php
session_start();
include '../includes/db.php';
include '../includes/session.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit();
}

// Fetch categories
$stmt = $conn->query("SELECT id, name FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch posts
$stmt = $conn->query("SELECT posts.id, posts.title, posts.created_at, categories.name AS category_name FROM posts JOIN categories ON posts.category_id = categories.id ORDER BY posts.created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Here’s a summary of your account:</p>

    <div class="info-section">
        <h3>Your Info:</h3>
        <ul>
            <li><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']); ?></li>
            <li><strong>Role:</strong> <?= htmlspecialchars($_SESSION['role']); ?></li>
        </ul>
    </div>

    <div class="categories-section">
        <h3>Categories:</h3>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li><?= htmlspecialchars($category['name']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="posts-section">
        <h3>Recent Posts:</h3>
        <?php if (!empty($posts)): ?>
            <ul>
                <?php foreach ($posts as $post): ?>
                    <li>
                        <a href="post.php?id=<?= $post['id']; ?>">
                            <?= htmlspecialchars($post['title']); ?>
                        </a>
                        (<?= htmlspecialchars($post['category_name']); ?> - <?= date("F j, Y", strtotime($post['created_at'])); ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No posts available.</p>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>