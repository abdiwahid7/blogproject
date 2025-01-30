<?php
include '../includes/session.php';
include '../includes/db.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $categoryName = htmlspecialchars(trim($_POST['category_name']));
    if (!empty($categoryName)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->bindParam(':name', $categoryName);
        $stmt->execute();
        header("Location: manage_categories.php");
        exit();
    }
}

if (isset($_GET['delete'])) {
    $categoryId = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = :id");
    $stmt->bindParam(':id', $categoryId);
    $stmt->execute();
    header("Location: manage_categories.php");
    exit();
}

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
<?php include '../includes/header.php'; ?>

<main>
    <h2>Add New Category</h2>
    <form method="POST" class="form-container">
        <input type="text" name="category_name" placeholder="Category Name" required>
        <button type="submit" name="add_category">Add Category</button>
    </form>

    <h2>Existing Categories</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['id']); ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td>
                        <a href="edit_category.php?id=<?php echo $category['id']; ?>">Edit</a>
                        <a href="?delete=<?php echo $category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                        <a href="view_category.php?id=<?php echo $category['id']; ?>">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>