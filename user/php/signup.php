<?php
session_start();

$message = '';//Initializes a variable to store error or success messages.
include 'db.php';

// Checks if the form was submitted.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Gets user input from the form.
  $firstname = trim($_POST['firstname']);
  $lastname = trim($_POST['lastname']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $terms = isset($_POST['terms']);

  // Basic validation
  if (!$terms) {
    $message = 'You must agree to the Terms & Conditions and Privacy Policy.';
  } elseif ($password !== $confirm_password) {
    $message = 'Passwords do not match.';
  } else {
    // Check if email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");//This prepares a SQL query to look for any user with the submitted email address.
    $stmt->bind_param("s", $email);//The s means the parameter is a string. It binds the user’s submitted email to the query.
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      $message = 'Email already registered.';
    } else {
      // Hash password
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      // Insert user
      $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password_hash) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss", $firstname, $lastname, $email, $phone, $hashed_password);
      if ($stmt->execute()) {
        // Get the new user's ID
        $new_user_id = $conn->insert_id;
        // Set session so user is logged in
        $_SESSION['user_id'] = $new_user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $firstname;
        header('Location: home.php');
        exit();
      } else {
        $message = 'Error: Could not register user.';
      }
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Anvaya Design Studio</title>
  <link rel="stylesheet" href="../css/signup.css">
  <link rel="stylesheet" href="../css/media/signup.css">
</head>

<body>
  <main>
    <section class="signup-hero">
      <div class="signup-heading heading">
        <div class="black-head head">
          Create an <span>Account</span>
        </div>
        <div class="underline">
          <div class="black-underline1 underline1"></div>
          <div class="black-underline2 underline2"></div>
          <div class="black-underline1 underline1"></div>
        </div>
        <p class="signup-intro black-p p">Join us to track your orders and get personalized design recommendations.</p>
      </div>
    </section>

    <section class="signup-section">
      <div class="signup-container">

        <!-- Display message -->
        <?php if ($message != ""): ?>
          <p style="color: red; text-align: center;"><?php echo $message; ?></p>
        <?php endif; ?>

        <form class="signup-form" action="" method="post">
          <div class="line-1">
            <div class="input-group">
              <input type="text" pattern="[A-Za-z]+" name="firstname" id="firstname" required>
              <label for="firstname">First Name</label>
            </div>

            <div class="input-group">
              <input type="text" name="lastname" pattern="[A-Za-z]+" id="lastname" required>
              <label for="lastname">Last Name</label>
            </div>
          </div>

          <div class="input-group">
            <input type="email" name="email" id="email" required>
            <label for="email">Email</label>
          </div>

          <div class="input-group">
            <input type="tel" name="phone" id="phone" required>
            <label for="phone">Phone Number</label>
          </div>

          <div class="line-1">
            <div class="input-group">
              <input type="password" name="password" id="password" required>
              <label for="password">Password</label>
            </div>

            <div class="input-group">
              <input type="password" name="confirm_password" id="confirm_password" required>
              <label for="confirm_password">Confirm Password</label>
            </div>
          </div>

          <div class="terms-privacy">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">I agree to the <a href="terms-condition.php">Terms & Conditions</a> and <a
                href="privacy-policy.php">Privacy Policy</a></label>
          </div>

          <div class="btn">
            <input type="submit" value="Sign Up">
          </div>
        </form>

        <div class="login-link">
          <p>Already have an account? <a href="login.php">Login</a></p>
        </div>

        <div class="home-btn">
          <a href="home.php" class="btn-link">Back to Home</a>
        </div>
      </div>
    </section>
  </main>
</body>

</html>