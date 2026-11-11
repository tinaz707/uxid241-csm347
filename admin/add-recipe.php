<?php
declare(strict_types=1);
session_start();

require_once '../data/db.php';
require_once '../functions.php';

//guard
// if (!isset($_SESSION['user_id'])) { //if user is not logged in kick them out!
//   header('Location: ../index.php');
//   exit;
// }

?>

<?php

// if($_SERVER['REQUEST METHOD'] === 'POST'){}

//define everything


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    
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
        <div class="login">
        <h2>Add a Recipe!</h2>
        <form id="login-style" action='login.php' method="post">
            <input class="login-input" placeholder="Email" type="text" name="email"/>
            <input class="login-input" placeholder="Password*" type="password" name="password" required/>
            <button type="submit" aria-label="submit">Submit</button>
        </form>

            <?php foreach($errors as $error): ?> 
                <p class="login-error"><?= e($error) ?></p>  <!-- '?=' shortcut for echo -->
            <?php endforeach;?>
    </div>
    </main>
    
  
</body>


</html>
