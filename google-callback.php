<?php
require_once 'google-config.php';

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token["error"])) {
        $client->setAccessToken($token['access_token']);

        $google_oauth = new Google_Service_Oauth2($client);
        $user_info = $google_oauth->userinfo->get();

        // You can now access $user_info->email, $user_info->name, etc.
        $email = $user_info->email;
        $name = $user_info->name;

        // Store user in your DB if not already stored
        include 'regdb.php';
        $result = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($result->num_rows == 0) {
            $conn->query("INSERT INTO users (name, email, role) VALUES ('$name', '$email', 'buyer')");
        }

        session_start();
        $_SESSION['user'] = $email;

        echo "✅ Welcome, $name. You are now logged in via Google!";
        // redirect to home/dashboard
    } else {
        echo "❌ Failed to get access token.";
    }
}
?>
