<?php
include 'regdb.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $result = $conn->query("SELECT * FROM users WHERE reset_token='$token' AND reset_token_expiry > NOW()");
    if ($result->num_rows == 1) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST['password'];
            $confirm = $_POST['confirm'];

            if ($password != $confirm) {
                echo "<p style='color:red;'>❌ Passwords do not match.</p>";
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $conn->query("UPDATE users SET password='$hashed', reset_token=NULL, reset_token_expiry=NULL WHERE reset_token='$token'");
                echo "<p style='color:green;'>✅ Password has been reset. <a href='login.php'>Login</a></p>";
                exit();
            }
        }

        ?>
        <form method="POST">
            <h2>Reset Your Password</h2>
            <input type="password" name="password" placeholder="New Password" required><br><br>
            <input type="password" name="confirm" placeholder="Confirm Password" required><br><br>
            <button type="submit">Reset Password</button>
        </form>
        <?php
    } else {
        echo "<p style='color:red;'>❌ Invalid or expired token</p>";
    }
} else {
    echo "<p>Invalid access</p>";
}
?>
