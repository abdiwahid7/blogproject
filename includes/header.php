<?php
include 'session.php';
?>
<header>
    <div class="logo">
        <h1>My Blog</h1>
    </div>
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <?php if (isLoggedIn()): ?>
                <li><a href="../pages/create_post.php">Create Post</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
                <?php if (isAdmin()): ?>
                    <li><a href="../admin/index.php">Admin Panel</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="../auth/register.php">Sign Up</a></li>
                <li><a href="../auth/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>