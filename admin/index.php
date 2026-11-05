<?php
declare(strict_types=1);
session_start();

//guard
if (!isset($_SESSION['user_id'])) {
  header('Location: ../index.php');
  exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logged In</title>
    
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/main.css"> <!--renamed to main bc xxamp wasn't loading it when it was called styles???-->
</head>

<body>
    <header>
        <?php
        include '../includes/header.php';
        ?>
    </header>   

    <main class="login-page">
          <h2 class="welcome-h2">You are Logged In! Welcome!</h2>
    </main>
    
  
</body>
</html>