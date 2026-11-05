<?php
declare(strict_types=1);
session_start();

$conn = require_once 'data/db.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/main.css"> <!--renamed to main bc xxamp wasn't loading it when it was called styles???-->
</head>

<body>
    <header>
        <?php
        include 'includes/header.php';
        ?>
    </header>   

  <main class="login-page">
        <div class="login">
        <h2>Log In</h2>
        <form id="login-style" action='login.php' method="post">
            <input class="login-input" placeholder="Username*" type="text" name="user" required />
            <input class="login-input" placeholder="Email*" type="text" name="email" required/>
            <input class="login-input" placeholder="Password*" type="text" name="password" required/>
            <button type="submit" aria-label="submit">Submit</button>
        </form>
    </div>
    </main>
    
  
</body>
