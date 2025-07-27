<?php
include 'regdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if user exists
    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50)); // secure token
        $expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));

        // Store token in database
        $conn->query("UPDATE users SET reset_token='$token', reset_token_expiry='$expiry' WHERE email='$email'");

        // Send email (you can use PHPMailer instead for real email)
        $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
        echo "<p>🔗 Reset Link (demo only): <a href='$resetLink'>$resetLink</a></p>";
        echo "<p style='color:green;'>Reset link has been sent to your email (simulated).</p>";
    } else {
        echo "<p style='color:red;'>❌ Email not found</p>";
    }
}
?>

<form method="POST">
    <h2>Forgot Password</h2>
    <input type="email" name="email" placeholder="Enter your email" required /><br>
    <button type="submit">Send code</button>
</form>
