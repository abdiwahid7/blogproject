<!-- database connection -->

<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'php_blog_app';

try {
    // create a new PDO connection 
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // handle connection errors
    echo "Database connection failed: " . $e->getMessage();
}
?>
