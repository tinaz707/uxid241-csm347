<?php
declare(strict_types=1);
session_start();


//guard
if (!isset($_SESSION['user_id'])) {
  header('Location: ../index.php');
  exit;
}

$conn = require_once '../data/db.php';
require_once '../functions.php';

$recipe_id = (int) $_POST['recipe_id']; //int is converting to a integer since  post values are strings..
$sql= 'DELETE FROM recipes WHERE recipe_id = ?'; //AI troubleshoot...I had 'id' when i just needed 'recipe_id' bc that is whats in my db

mysqli_execute_query(
    $conn,
    $sql,
    [$recipe_id] //this is that placeholder in sql '?'

);

header('Location: ../index.php');
exit; //leave the hp and then literally come back


var_dump($recipe_id);
exit;
?>