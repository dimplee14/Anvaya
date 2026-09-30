

<?php
session_start();
include 'db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $password_hash);
        $stmt->fetch();
        if (password_verify($password, $password_hash)) {
            // Login success, set session and redirect
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            header('Location: home.php');
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Invalid email or password.';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Anvaya Design Studio</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/media/login.css">
</head>

<body>
    <main>
        <section class="login-hero">
            <div class="login-heading heading">
                <div class="black-head head">
                    Welcome <span>Back</span>
                </div>
                <div class="underline">
                    <div class="black-underline1 underline1"></div>
                    <div class="black-underline2 underline2"></div>
                    <div class="black-underline1 underline1"></div>
                </div>
                <p class="login-intro black-p p">Sign in to access your account and manage your orders.</p>
            </div>
        </section>
        
        <section class="login-section">
            <div class="login-container">
                <form class="login-form" action="" method="post">
                    
                    <?php if (!empty($error)) : ?>
                        <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <div class="input-group">
                        <input type="email" name="email" id="email" required>
                        <label for="email">Email</label>
                    </div>
                    
                    <div class="input-group">
                        <input type="password" name="password" id="password" required>
                        <label for="password">Password</label>
                    </div>
                    
                    <div class="form-options">
                        <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
                    </div>
                    
                    <div class="btn">
                        <input type="submit" value="Login">
                    </div>
                </form>
                
                <div class="signup-link">
                    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                </div>
                
                <div class="home-btn">
                    <a href="home.php" class="btn-link">Back to Home</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
