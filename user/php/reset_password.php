<!-- <?php 
// require_once('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <main>
        <h2>Reset Password</h2>
        <form method="post" action="">
            <label for="code">Enter reset code:</label>
            <input type="text" name="code" id="code" required>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required>
            <button type="submit">Reset Password</button>
        </form>
        <?php 
        // if (isset($msg)) { echo '<div class="success-note">'.$msg.'</div>'; } ?>
        <?php 
        // if (isset($error)) { echo '<div class="error-msg">'.$error.'</div>'; } ?>
        <a href="login.php">Back to Login</a>
    </main>
</body>
</html> -->
