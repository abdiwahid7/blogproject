<!-- <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/db.php';
include '../includes/session.php';

// Debugging: Check session contents
echo "Session Debugging:<br>";
var_dump($_SESSION);

if (!isset($_SESSION['user_id'])) {
    die("Session not set. Redirecting to login.");
    header('Location: ../auth/login.php');
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim and sanitize user input
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = intval($_POST['category_id']);
    $user_id = $_SESSION['user_id'];

    // Validate input
    if (empty($title) || empty($content) || empty($category_id)) {
        $error = "All fields are required.";
    } else {
        // Secure query execution
        $stmt = $conn->prepare("INSERT INTO posts (title, content, user_id, category_id, created_at) VALUES (?, ?, ?, ?, NOW())");
        if ($stmt->execute([$title, $content, $user_id, $category_id])) {
            header('Location: ../index.php');
            exit();
        } else {
            $error = "Failed to create post. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main>
    <h2>Create New Post</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="create_post.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit">Create Post</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html> -->
