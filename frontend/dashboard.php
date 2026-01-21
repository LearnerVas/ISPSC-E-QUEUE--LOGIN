<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>ISPSC Queue</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Welcome to ISPSC Queue</h2>
<p>You are successfully logged in.</p>

</body>
</html>
