<?php
require_once 'google-config.php';

$login_url = $client->createAuthUrl();
?>

<a href="<?php echo $login_url; ?>">
  <button>Sign in with Google</button>
</a>
