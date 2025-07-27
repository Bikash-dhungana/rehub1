<?php
session_start(); // Start session at the top
include 'regdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'] ?? '';
    $agreed_terms = isset($_POST['agree']) ? 1 : 0;

    if ($password !== $confirm_password) {
        die("❌ Error: Passwords do not match.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role, agreed_terms) 
            VALUES ('$name', '$email', '$hashed_password', '$role', $agreed_terms)";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['flash_message'] = "✅ Registration successful. Please log in.";
        header("Location: login.php");
        exit();
    } else {
        echo "❌ Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ReHub Registration</title>
</head>
<body>
  <h1>REGISTER</h1>
  <p>It's completely free</p>

  <form action="" method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <label>Choose Role:</label><br>
    <input type="radio" name="role" value="buyer" required> Buyer
    <input type="radio" name="role" value="seller"> Seller<br><br>

    <input type="checkbox" name="agree" id="agree" required>
    <label for="agree">Are you sure about joining ReHub?</label><br><br>

    <input type="submit" name="submit" value="Create Account">
  </form>

  <p>This is our register form for ReHub</p>
</body>
</html>
