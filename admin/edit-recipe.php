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
   

    $recipe_id = (int) $_GET['recipe_id']; //getting the spefic id --> this works

            
    $sql = 'SELECT * FROM recipes WHERE recipe_id = ?'; //was missing the ? smh
          

    $recipe_update = mysqli_execute_query(
        $conn, $sql, [$recipe_id]
    );

    $recipe = mysqli_fetch_assoc($recipe_update);


    //UPDATE
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $title = trim_post('title');
            $subtitle = trim_post('subtitle');


            $sql = 'UPDATE recipes
                    SET title =?, subtitle = ? 
                    WHERE recipe_id = ?';


            mysqli_execute_query(
                $conn,
                $sql,
               [$title, $subtitle, $recipe_id]
            );

            header('Location: ../index.php'); //can't head to recipe page bc of the ingredients using explore(cant use NULL it needs a string)


    }



  


//Future me include some error or completion message/FEEDBACK

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
        <h2>Update Recipe!!</h2>

       

        <form id="add-style" method="post">
           <fieldset>
                <div class="label-input">
                    <label for="title">Recipe Name</label>
                    <input 
                        class="add-input" 
                        type="text" 
                        id="title" 
                        name="title" 
                        value = "<?= e($recipe["title"]) ?>"
                        required>
                </div>

                <div class="label-input">
                    <label for="subtitle">Subtitle</label>
                    <input
                        class="add-input" 
                        type="text" 
                        id="subtitle" 
                        name="subtitle" 
                        value = "<?= e($recipe["subtitle"]) ?>"
                        required
                    >
                </div>

           </fieldset>


                <button class="submit-button" type="submit" aria-label="submit">Update</button>

        </form>
        
    </div>
          


    </main>
    
  


</body>
</html>

