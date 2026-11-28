<?php
declare(strict_types=1);
session_start();

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
} //from W6 lecture CSRF token -> checks if request came from my website (security check..)


//guard
if (!isset($_SESSION['user_id'])) { //if user is not logged in kick them out(to log in!)!
  header('Location: ../login.php');
  exit;
}

$conn = require_once __DIR__ . '/../data/db.php';
require_once __DIR__ . '/../functions.php';





    $recipe_id = (int) $_GET['recipe_id']; //getting the spefic id --> this works
    $errors = [];
            
    $sql = 'SELECT * FROM recipes WHERE recipe_id = ?'; //was missing the ? smh
          

    $recipe_update = mysqli_execute_query(
        $conn, $sql, [$recipe_id]
    );

    $recipe = mysqli_fetch_assoc($recipe_update);
    $ingredients = $recipe["ingredients"];
    $steps = $recipe['steps'];

    //UPDATE
    if($_SERVER['REQUEST_METHOD'] === 'POST'){


        //CSRF ====================================
        $sent = $_POST['csrf_token'] ?? '';
        $known = $_SESSION['csrf_token'] ?? '';

        if (!hash_equals($known, $sent)) {
        http_response_code(403);
        exit('Invalid CSRF token');
        } 
        // ====================================



            $title = trim_post('title');
            $subtitle = trim_post('subtitle');
            $description = trim_post('description');

            $servings = (int) trim_post('servings');
            $total_time = (int) trim_post('total-time');
            $category = (int) trim_post('categories_id');

            $ingredients = trim_post('ingredients');
            $steps = trim_post('steps');

        if ($title === '') {

                $errors[] = 'Recipe name is required!';
            }

            if ($subtitle === '') {
                $errors[] = 'Subtitle is required!';
            }

            if (empty($errors)) {
                $sql = 'UPDATE recipes
                        SET title =?, 
                            subtitle = ?,
                            description = ?,
                            servings = ?,
                            total_time = ?,
                            categories_id = ?,
                            ingredients = ?,
                            steps = ?
                            
                        
                        WHERE recipe_id = ?';


                mysqli_execute_query(
                    $conn,
                    $sql,
                     [$title, $subtitle, $description, $servings, $total_time, $category, $ingredients, $steps, $recipe_id] //no idea about images
                );

                header('Location: ../index.php'); //can't head to recipe page bc of the ingredients using explore(cant use NULL it needs a string)
                exit; //was missing this --> tells php to stop running the page

            }


        //===============below is stuff for image

            //=====UPLOADING SINGLE IMAGES=====================================================
        $upload_folder =  __DIR__ . '/../assets/uploads'; //folder on server for uploaded images
        //AI : __DIR__ → PHP automatically replaces this with the folder containing the PHP file you're currently in

        //AI to help clarify this was correct
        //=====MAIN IMAGE ======================================================================
    try{
                $main_image = 'assets/uploads/' . save_uploads( //send main image through the function and store that in the path ... ex (assets/uploads/chicken.png)
                $_FILES['photo'] ['tmp_name'],
                $_FILES['photo'] ['name'],
                $_FILES['photo'] ['size'],
                $_FILES['photo'] ['error'],
                $upload_folder
                
            );
    }
        catch (RuntimeException $e) { //if something goes wrong --> those error messages with throw
            $errors[] = $e->getMessage(); //AI to cut out the example code from lecture and make things work related to what's in my file..    
                
    }

    
        //=====INGREDIENTS IMAGE ====================================================================
    try{
            $ingredients_image = 'assets/uploads/' . save_uploads(
                    $_FILES['ingredients_image'] ['tmp_name'],
                    $_FILES['ingredients_image'] ['name'],
                    $_FILES['ingredients_image'] ['size'],
                    $_FILES['ingredients_image'] ['error'],
                    $upload_folder
                    
                );
    }  catch (RuntimeException $e) { //if something goes wrong --> those error messages with throw
            $errors[] = $e->getMessage(); //AI to cut out the example code from lecture and make things work related to what's in my file..    

    }


        //MULTIPLE STEPS IMAGES=======================================
        //AI helped reorganize my code that I had from the lecture -> had some missing brackets and semi-colons//
        $step_images = [];

        // Check that step images were submitted and that the names are an array
        // because name="steps_image[]" allows multiple files                      
        if (isset($_FILES['steps_image']['name']) && is_array($_FILES['steps_image']['name'])) {

            $files = $_FILES['steps_image'];

            foreach ($files['name'] as $i => $original_name) { //loop through EACH uploaded image

                // if there is a file error(no upload) just skip that one and CONTINUE
                if ($files['error'][$i] === UPLOAD_ERR_NO_FILE) {
                    continue;
                }

                try { //try to upload the image...something might go wrong..but save the image
                    $saved = save_uploads( //send image through function | the $saved value is what gets returned so ex 'chicken.png'...
                        $files['tmp_name'][$i], //tmp location of this '[i]=specific image'
                        $original_name,
                        $files['size'][$i],
                        $files['error'][$i],
                        $upload_folder
                    );

                $step_images[] = 'assets/uploads/' . $saved; //Add the browser-usable path for this image to the array


                } catch (RuntimeException $e) { //if something goes wrong --> those error messages with throw

                        $errors[] = $e->getMessage(); //AI to cut out the example code from lecture and make things work related to what's in my file..
                
                }

        
            }

            $steps_image = implode('*', $step_images);//AI help -> Turn step image array into same * format to match what i have in db

    }



    }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>

    <header>
        <?php
            $root = '../';
            include __DIR__ . '/../includes/header.php';
        ?>
    </header>   

    
    <main class="add-recipe-page">
        <div class="add-recipe">
        <h2>Edit Recipe!</h2>

       

        <!-- things weren't updated AI helped to troubleshoot and gave me value for action / edit-recipe php is changing the db so then the recipe.php reads the db and updates  -->
        <form id="add-style" action="edit-recipe.php?recipe_id=<?=$recipe_id?>" method="post"> 
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"> 
  
        <fieldset><?php foreach($errors as $error): ?> 
                        <p class="error"><?= e($error) ?></p>  <!-- '?=' shortcut for echo -->
                    <?php endforeach;?>

                <div class="label-input">
                    <label for="title">Recipe Name</label>
                    <input value = "<?= e($recipe["title"]) ?>" class="add-input" type="text" id="title" name="title" required>
                </div>

                <div class="label-input">
                    <label for="subtitle">Subtitle</label>
                    <input value = "<?= e($recipe["subtitle"]) ?>" class="add-input" type="text" id="subtitle" name="subtitle" required>
                </div>

                <div class="label-input">
                    <label for="description">Description</label>
                    <input value = "<?= e($recipe["description"]) ?>" class="add-input" type="text" id="description" name="description" required>
                </div>

                <div class="label-input">
                    <label for="photo">Main Photo</label>
                    <!-- <input value = "<?= e($recipe["main_image"]) ?>" class="add-input" type="text" id="photo" name="photo" required> -->
                    <input 
                         class="add-input"
                         type="file"
                         id="photo" 
                         name="photo" 
                         >
                
                </div>
           </fieldset>


           <fieldset class="details-servings">
                <div class="label-input">
                    <label for="servings">Servings</label>
                    <input value="<?= ($recipe['servings']) ?>" class="add-input" type="number" id="servings" name="servings" required>
                </div>

                <div class="label-input">
                    <label for="total-time">Total Time (Min)</label>
                    <input value="<?= ($recipe['total_time']) ?>" class="add-input" type="number" id="total-time" name="total-time" required>
                </div>

                <div class="label-input">
                    <label for="categories_id">Category</label>
                    <select class="add-input" type="text" id="categories_id" name="categories_id" required>
                        <option value=""  >Select a Category</option>
                       
                        
                        <option value="1"
                            <?php //AI helped to figure out what to echo + where to place this
                            if (($recipe['categories_id'] === 1)){
                                    echo 'selected';
                            } 
                        ?>
                        >Chicken</option>

                        <option value="2"
                        <?php
                            if (($recipe['categories_id'] === 2)){
                                    echo 'selected';
                            } 
                        ?>
                        >Beef</option>

                        <option value="3"
                        <?php
                            if (($recipe['categories_id'] === 3)){
                                    echo 'selected';
                            } 
                        ?>
                        >Vegetarian</option>


                        <option value="4"
                        <?php
                            if (($recipe['categories_id'] === 4 )){
                                    echo 'selected';
                            } 
                        ?>
                        >Seafood</option>

                        <option value="5"
                        <?php
                            if (($recipe['categories_id'] === 5)){
                                    echo 'selected';
                            } 
                        ?>
                        >Pork</option>

                        <option value="6"
                        <?php
                            if (($recipe['categories_id'] === 6)){
                                    echo 'selected';
                            } 
                        ?>
                        >Turkey</option>
                    </select>

                </div>
           </fieldset>

           <hr>

           <fieldset class="ingredients">
                <div class="label-input">
                    <label for="ingredients"> Ingredients</label>
                    <p class="note-for-user">
                        Add each ingredient on a new line
                    </p>
                    <textarea
                           
                        class="add-input"
                        id="ingredients"
                        name="ingredients"
                        rows="15"
                        required
                    ><?= e($ingredients)?></textarea>                
                </div> 
<!-- AI to help troubleshoot and lern where the value goes for a textarea -->
                <div class="label-input">
                    <label for="steps"> Steps</label>
                    <p class="note-for-user">
                        Please write the step title followed by a colon (:) and the instructions. Separate each complete step with an asterisk(*).
                    </p>
                    <textarea
                        placeholder=
                        "e.g. Step Title: Instructions for step*Cook the rice: Place an oven rack in the center of the oven, then preheat to 450°F. ....*Prepare the ingredients & make the glaze: While the rice cooks..."
                        class="add-input"
                        id="steps"
                        name="steps"
                        rows="15"
                        required
                    ><?= e($steps)?></textarea>                
                </div>
           </fieldset>

            <button type="submit" aria-label="submit">Submit</button>

        </form>


    </div>
    </main>

       <script src="../scripts/main.js"></script>   

</body>
</html>