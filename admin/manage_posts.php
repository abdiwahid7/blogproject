<?php
// admin/manage_posts.php - Manage Blog Posts

include '../includes/db.php'; // Include database connection
include '../includes/session.php'; // Include session management
isAdmin(); // Ensure the user is an admin

// Fetch all posts
$query = $conn->query("SELECT posts.id, posts.title, posts.created_at, users.username, categories.name AS category_name 
                        FROM posts 
                        JOIN users ON posts.user_id = users.id 
                        JOIN categories ON posts.category_id = categories.id 
                        ORDER BY posts.created_at DESC");
$posts = $query->fetchAll(PDO::FETCH_ASSOC);

// Handle delete request
if (isset($_GET['delete'])) {
    $postId = intval($_GET['delete']);
    $deleteQuery = $conn->prepare("DELETE FROM posts WHERE id = :id");
    $deleteQuery->bindParam(':id', $postId);
    $deleteQuery->execute();
    header("Location: manage_posts.php"); // Redirect to the same page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Manage Posts</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_categories.php">Manage Categories</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>All Blog Posts</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['id']); ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><?php echo htmlspecialchars($post['username']); ?></td>
                        <td><?php echo htmlspecialchars($post['category_name']); ?></td>
                        <td><?php echo htmlspecialchars(date("F j, Y", strtotime($post['created_at']))); ?></td>
                        <td>
                            <a href="edit_post.php?id=<?php echo $post['id']; ?>">Edit</a>
                            <a href="?delete=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="create_post.php">Create New Post</a>
    </main>

    <footer>
        <p>&copy; 2025 My Blog. All Rights Reserved.</p>
    </footer>
</body>
</html>