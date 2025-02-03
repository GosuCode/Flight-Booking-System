<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page after logging out
header("Location: ../index.php");
exit();
?>
