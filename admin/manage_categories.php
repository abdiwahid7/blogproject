<?php
// manage_categories.php - Manage Blog Categories

include '../includes/db.php'; // Include database connection
include '../includes/session.php'; // Check if user is logged in and has admin privileges

isAdmin(); // Ensure the user is an admin

// Handle form submission for adding a new category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $categoryName = htmlspecialchars(trim($_POST['category_name']));

    if (!empty($categoryName)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->bindParam(':name', $categoryName);
        $stmt->execute();
        header("Location: manage_categories.php"); // Redirect to the same page
        exit();
    }
}

// Handle category deletion
if (isset($_GET['delete'])) {
    $categoryId = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = :id");
    $stmt->bindParam(':id', $categoryId);
    $stmt->execute();
    header("Location: manage_categories.php"); // Redirect to the same page
    exit();
}

// Fetch existing categories
$categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Manage Categories</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="manage_posts.php">Manage Posts</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_categories.php">Manage Categories</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Add New Category</h2>
        <form method="POST">
            <input type="text" name="category_name" placeholder="Category Name" required>
            <button type="submit" name="add_category">Add Category</button>
        </form>

        <h2>Existing Categories</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li>
                    <?php echo htmlspecialchars($category['name']); ?>
                    <a href="?delete=<?php echo $category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

    <footer>
        <p>&copy; 2025 My Blog. All Rights Reserved.</p>
    </footer>
</body>
</html>