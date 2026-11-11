<?php
declare(strict_types=1);
session_start();


$conn = require_once '../data/db.php';
require_once '../functions.php';

//guard
if (!isset($_SESSION['user_id'])) { //if user is not logged in kick them out!
  header('Location: ../index.php');
  exit;
}

?>

<?php

// $added = ''; forgot what this was for ---delete later
$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = trim_post('title');
    $subtitle = trim_post('subtitle');

    //ERRORS
    if($title === ''){
        $errors[] = 'Recipe name is required!';
    }
     if($subtitle === ''){
        $errors[] = 'Subtitle is required!';
    }

    //NO ERRORS so...
    if (empty($errors)){
        $sql = 'INSERT INTO recipes (title, subtitle) VALUES (?, ?)';


        mysqli_execute_query(
            $conn,
            $sql,
            [$title , $subtitle]
        );

        header('Location: ../login.php');
        exit; 
      
    }


}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>

    <header>
         <?php
        include '../includes/header.php';
        ?>
    </header>   




  <main class="add-recipe-page">
        <div class="add-recipe">
        <h2>Add a Recipe!</h2>

          <!-- ERROR DISPLAY==============================================  -->


        <form id="add-style" action='add-recipe.php' method="post">
           <fieldset><?php foreach($errors as $error): ?> 
                        <p class="error"><?= e($error) ?></p>  <!-- '?=' shortcut for echo -->
                    <?php endforeach;?>
                <div class="label-input">
                    
                    <label for="title">Recipe Name</label>
                    <input placeholder="Ancho-Orange Chicken..." class="add-input" type="text" id="title" name="title" >
               
                </div>

                <div class="label-input">
                    <label for="subtitle">Subtitle</label>
                    <input placeholder="with Kale Rice and..." class="add-input" type="text" id="subtitle" name="subtitle">
                </div>
<!-- 
                <div class="label-input">
                    <label for="description">Description</label>
                    <input placeholder="Provide a short description of the dish..." class="add-input" type="text" id="description" name="description">
                </div> -->
           </fieldset>
<!-- 

           <fieldset>
                <div class="label-input">
                    <label for="description">Servings</label>
                    <input class="add-input" type="number" id="servings" name="servings">
                </div>

                <div class="label-input">
                    <label for="description">Total Time</label>
                    <input class="add-input" type="number" id="total-time" name="total-time">
                </div>

                <div class="label-input">
                    <label for="description">Category</label>
                    AI help here: since my categories are numbers using options with values will still send the # to php but not confused user
                    <select class="add-input" id="category" name="category">
                        <option value="1">Chicken</option>
                        <option value="2">Beef</option>
                        <option value="3">Vegetarian</option>
                        <option value="4">Seafood</option>
                        <option value="5">Pork</option>
                        <option value="6">Turkey</option>
                    </select>               
                </div>
           </fieldset>

            -->
               


                <button class="submit-button" type="submit" aria-label="submit">Submit</button>

        </form>
        
    </div>
          


    </main>
    
  


</body>
</html>

