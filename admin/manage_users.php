<?php
// manage_users.php - Manage User Accounts

include '../includes/db.php'; // Include database connection
include '../includes/session.php'; // Include session management
isAdmin(); // Ensure the user is an admin

// Fetch all users
$query = $conn->query("SELECT * FROM users");
$users = $query->fetchAll(PDO::FETCH_ASSOC);

// Handle user deletion
if (isset($_GET['delete'])) {
    $userId = intval($_GET['delete']);
    $deleteQuery = $conn->prepare("DELETE FROM users WHERE id = :id");
    $deleteQuery->bindParam(':id', $userId);
    $deleteQuery->execute();
    header("Location: manage_users.php"); // Redirect to the same page
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Manage Users</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="manage_posts.php">Manage Posts</a></li>
                <li><a href="manage_categories.php">Manage Categories</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>User Accounts</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                            <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2025 My Blog. All Rights Reserved.</p>
    </footer>
</body>
</html>