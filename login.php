<?php
session_start();


// Show flash message if it exists
if (isset($_SESSION['flash_message'])) {
    echo "<p style='color: green; font-weight: bold;'>" . $_SESSION['flash_message'] . "</p>";
    unset($_SESSION['flash_message']); // Remove message after displaying once
}

include 'regdb.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Get user by email
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['name'];
            echo "<script>alert('✅ Login successful!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('❌ Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('❌ User not found');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - ReHub</title>
 
</head>
<body>
  <div class="login-container">
    <h2>Sign In to ReHub</h2><br><br>
    <form method="POST" action="">
      <input type="email" name="email" placeholder="Email" required /><br><br>
      <input type="password" name="password" placeholder="Password" required /><br><br>

      <div class="remember-forgot"><br><br>
        <label><input type="checkbox" name="remember"> Remember Me</label>
        <a href="forgetpassword.php">Forgot Password?</a><br><br>
      </div>

      <input type="submit" name="login" value="Sign In" class="btn"><br><br>
      <button type="button" class="btn google-btn">Sign In with Google</button><br><br>

      <div class="signup-link">
        Don't have an account? <a href="regestration.php">Sign Up</a>
      </div>
    </form>
  </div>
</body>
</html>

