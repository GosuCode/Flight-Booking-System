<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Assuming you have style.css in the folder -->
</head>
<body>
<?php include '../utils/header.php'; ?><!--header content. file found in utils folder-->

    <?php
    session_start();
    include('../config.php');

    // Fetch the current user's details if logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($username, $email);
            $stmt->fetch();
        } else {
            $_SESSION['error_message'] = "User not found!";
            header("Location: ../index.php");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "You need to be logged in to update your profile.";
        header("Location: ../pages/login.php");
        exit();
    }
    ?>
<div class="form-wrapper">

    <div class="profile-update-container">
        <h2 class="page-title">Update Profile</h2>

        <?php 
        if (isset($_SESSION['error_message'])) { 
            echo '<p class="error-message">' . $_SESSION['error_message'] . '</p>';
            unset($_SESSION['error_message']); 
        }

        if (isset($_SESSION['success_message'])) { 
            echo '<p class="success-message">' . $_SESSION['success_message'] . '</p>';
            unset($_SESSION['success_message']); 
        }
        ?>

        <form action="../actions/update_user_action.php" method="POST" class="update-profile-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-input" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="primary-button">Update Information</button>
            </div>
        </form>
    </div>
    </div>


    <?php include '../utils/footer.php'; ?><!--footer content. file found in utils folder-->
</body>
</html>
