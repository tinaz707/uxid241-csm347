<?php
declare(strict_types=1);
session_start();


//guard
if (!isset($_SESSION['user_id'])) { //if user is not logged in kick them out!
  header('Location: ../index.php');
  exit;
}

$conn = require_once __DIR__ . '/../data/db.php';
require_once __DIR__ . '/../functions.php';

 
$errors = [];

//FORM SUBMISSION =================================================================
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = trim_post('title');                     //get name=title + trim space...
    $subtitle = trim_post('subtitle');
    $description = trim_post('description');

    $servings = (int) trim_post('servings');        //get servings + convert value into integer
    $total_time = (int) trim_post('total-time');
    $category = (int) trim_post('category');    

    $ingredients = trim_post('ingredients');
    $steps = trim_post('steps'); //AI to troubleshoot and realize I only had title and subtitle -> hadn't updated this


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

    //ERRORS===================================================================
    if($title === ''){
        $errors[] = 'Recipe name is required!';
    }
     if($subtitle === ''){
        $errors[] = 'Subtitle is required!';
    }

    //NO ERRORS so...
    if (empty($errors)){
        $sql = 'INSERT INTO recipes (title, subtitle, description, servings, total_time, categories_id, main_image, ingredients, ingredients_image, steps, steps_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'; 


        mysqli_execute_query(
            $conn,
            $sql,
            [$title, $subtitle, $description, $servings, $total_time, $category, $main_image, $ingredients, $ingredients_image, $steps, $steps_image]
        );

        header('Location: ../index.php');
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
        $root = '../'; //location of where this file is rn
        include __DIR__ . '/../includes/header.php';
        ?>
    </header>   

    
    <main class="add-recipe-page">
        <div class="add-recipe">
        <h2>Add a Recipe!</h2>

       

        <form id="add-style" action='add-recipe.php' method="post" enctype="multipart/form-data">
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
                    <label for="photo">Main Photo</label>
                    <input 
                         class="add-input"
                         type="file"
                         id="photo" 
                         name="photo" 
                         required>
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
                        Add each ingredient on a new line
                    </p>
                    <textarea
                            placeholder="e.g.
¾ cup Jasmine Rice
¾ lb Carrots
2 cloves Garlic
1 bunch Kale"
                        class="add-input"
                        id="ingredients"
                        name="ingredients"
                        rows="15"
                        required
                    ></textarea>                
                </div>

                <div class="label-input">
                    <label for="ingredients_image">Ingredient Photo</label>
                    <!-- <p class="note-for-user">
                        Image of ingredients is not required but recommended!                    
                    </p> -->
                    <input 
                         class="add-input"
                         type="file"
                         id="ingredients_image" 
                         name="ingredients_image" 
                         required
                        >
                </div>

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
                    ></textarea>                
                </div>



                <div class="label-input">
                    <label for="steps_image">Steps Photo</label>
                    <p class="note-for-user">
                        Upload one image for each step, in the same order as your steps!
                    </p>
                    <input 
                         class="add-input"
                         type="file"
                         id="steps_image" 
                         name="steps_image[]" 
                         multiple
                         required
                        >
                </div>
                
           </fieldset>

            <button type="submit" aria-label="submit">Submit</button>

        </form>


    </div>
    </main>


</body>
</html>

