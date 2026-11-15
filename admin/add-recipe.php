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

       

        <form id="add-style" action='add-recipe.php' method="post">
           <fieldset><?php foreach($errors as $error): ?> 
                        <p class="error"><?= e($error) ?></p>  <!-- '?=' shortcut for echo -->
                    <?php endforeach;?>

                <div class="label-input">
                    <label for="title">Recipe Name</label>
                    <input placeholder="e.g. Ancho-Orange Chicken..." class="add-input" type="text" id="title" name="title" required>
                </div>

                <div class="label-input">
                    <label for="subtitle">Subtitle</label>
                    <input placeholder=" e.g. with Kale Rice" class="add-input" type="text" id="subtitle" name="subtitle" required>
                </div>

                <div class="label-input">
                    <label for="description">Description</label>
                    <input placeholder=" Provide a short description of the dish" class="add-input" type="text" id="description" name="description" required>
                </div>

                <div class="label-input">
                    <label for="photo">Cover Photo</label>
                    <input placeholder=" Provide a image of the completed dish" class="add-input" type="text" id="photo" name="photo" required>
                </div>
           </fieldset>


           <fieldset class="details-servings">
                <div class="label-input">
                    <label for="servings">Servings</label>
                    <input class="add-input" type="number" id="servings" name="servings" required>
                </div>

                <div class="label-input">
                    <label for="total-time">Total Time</label>
                    <input class="add-input" type="number" id="total-time" name="total-time" required>
                </div>

                <div class="label-input">
                    <label for="category">Category</label>
                    <select class="add-input" type="text" id="category" name="category" required>
                        <option value="">Select a Category</option>
                        <option value="1">Chicken</option>
                        <option value="2">Beef</option>
                        <option value="3">Vegetarian</option>
                        <option value="4">Seafood</option>
                        <option value="5">Pork</option>
                        <option value="6">Turkey</option>
                    </select>

                </div>
           </fieldset>

           <hr>

           <fieldset class="ingredients">
                <div class="label-input">
                    <label for="ingredients"> Ingredients</label>
                    <p class="note-for-user">
                        Please separate each ingredient using an asterisk (*).
                    </p>
                    <textarea
                        placeholder="e.g. ¾ cup Jasmine Rice*¾ lb Carrots*2 cloves Garlic*1 bunch Kale"
                        class="add-input"
                        id="ingredients"
                        name="ingredients"
                        rows="5"
                        required
                    ></textarea>                
                </div>

                <div class="label-input">
                    <label for="steps"> Steps</label>
                    <p class="note-for-user">
                        Please write the step title followed by a colon (:) and the instructions. Separate each complete step with an asterisk(*).
                    </p>
                    <textarea
                        placeholder="e.g. Step Title: Instructions for step*Cook the rice: Place an oven rack in the center of the oven, then preheat to 450°F. ....*Prepare the ingredients & make the glaze: While the rice cooks..."
                        class="add-input"
                        id="steps"
                        name="steps"
                        rows="15"
                        required
                    ></textarea>                
                </div>
           </fieldset>

        </form>


    </div>
    </main>


</body>
</html>

