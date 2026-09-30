

<?php
session_start();
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!$email) {
        $error = 'Please enter your email.';
    } else {
        // Here you would check if the email exists in your database
        // and send a reset link. For demo, just show success.
        $success = 'If your email is registered, a password reset link has been sent.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/login.css">
    <style>
        body {
            background: #f8fbff;
            font-family: 'Montserrat', sans-serif;
        }
        .forgot-container {
            max-width: 400px;
            margin: 60px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(60,140,231,0.10), 0 1.5px 8px rgba(0,0,0,0.08);
            padding: 36px 32px 28px 32px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .forgot-container h2 {
            color: #3c8ce7;
            font-size: 2rem;
            margin-bottom: 18px;
            font-weight: 700;
        }
        .forgot-container label {
            font-size: 1rem;
            color: #484848;
            margin-bottom: 8px;
            font-weight: 500;
            display: block;
        }
        .forgot-container input[type="email"] {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #dbeafe;
            margin-bottom: 18px;
            font-size: 1rem;
            background: #f8fbff;
        }
        .forgot-container button[type="submit"] {
            width: 100%;
            padding: 10px 0;
            background: linear-gradient(90deg, #3c8ce7 60%, #6fa1e7 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(60,140,231,0.08);
            transition: background 0.2s;
        }
        .forgot-container button[type="submit"]:hover {
            background: linear-gradient(90deg, #2a6bbf 60%, #3c8ce7 100%);
        }
        .forgot-container .error-message {
            color: #d90429;
            background: #ffeaea;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 10px;
            width: 100%;
            text-align: center;
        }
        .forgot-container .success-message {
            color: #116A24;
            background: #e9f7ee;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 10px;
            width: 100%;
            text-align: center;
        }
        .forgot-container .login-link {
            margin-top: 10px;
        }
        .forgot-container .login-link a {
            color: #3c8ce7;
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-container .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <h2>Forgot Password</h2>
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <div class="login-link">
            <a href="login.php">Back to Login</a>
        </div>
    </div>
</body>
</html>
