<?php
include '../includes/session.php';
include '../includes/db.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit();
}

$category_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM posts WHERE category_id = ?");
$stmt->execute([$category_id]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Category</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main>
    <h2>Category: <?php echo htmlspecialchars($category['name']); ?></h2>
    <h3>Posts in this category:</h3>
    <ul class="post-list">
        <?php foreach ($posts as $post): ?>
            <li>
                <a href="post.php?id=<?php echo $post['id']; ?>">
                    <?php echo htmlspecialchars($post['title']); ?>
                </a> - <?php echo date("F j, Y", strtotime($post['created_at'])); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>