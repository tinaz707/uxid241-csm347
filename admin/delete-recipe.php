<?php
declare(strict_types=1);
session_start();

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
} //from W6 lecture CSRF token -> checks if request came from my website (security check..)


//guard
if (!isset($_SESSION['user_id'])) {
  header('Location: ../login.php');
  exit;
}

$conn = require_once __DIR__ . '/../data/db.php';
require_once __DIR__ . '/../functions.php';


//CSRF ====================================
$sent = $_POST['csrf_token'] ?? '';
$known = $_SESSION['csrf_token'] ?? '';

if (!hash_equals($known, $sent)) {
  http_response_code(403);
  exit('Invalid CSRF token');
} 
// ====================================

// Safe to add / edit / delete a recipe below

$recipe_id = (int) $_GET['recipe_id']; //get the id from the index when clicked (getting it from url)

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $recipe_id = (int) $_POST['recipe_id']; //int is converting to a integer since  post values are strings..
  $sql= 'DELETE FROM recipes WHERE recipe_id = ?'; //AI troubleshoot...I had 'id' when i just needed 'recipe_id' bc that is whats in my db

  mysqli_execute_query(
      $conn,
      $sql,
      [$recipe_id] //this is that placeholder in sql --> '?'
  );

  header('Location: ../index.php');
  exit; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Page</title>

    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/main.css">

  
</head>
<body>

  <header>
        <?php
        $root = '../'; //location of where this file is rn
            include __DIR__ . '/../includes/header.php';
        ?>
    </header>   


  <main class="delete-recipe-page">
    <form id="delete-form" action="delete-recipe.php" method="post">
    
      <h1>Are you sure you want to DELETE this recipe?</h1>      
      <p>Once deleted it can not be undone</p>

      <button type="submit" aria-label="submit">Confirm delete</button>
      <input type="hidden" name="recipe_id" value="<?= $recipe_id ?>">        
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"> 

    </form>
  </main>


</body>
</html>