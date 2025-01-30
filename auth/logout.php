<!-- user logout functionality -->
<?php
session_start();
session_unset(); 
session_destroy(); 
header("Location: login.php?success=logged_out");
exit();

