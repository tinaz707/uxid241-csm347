<?php
declare(strict_types=1);
session_start();


$conn = require_once 'data/db.php';
require_once 'functions.php';



//get id through url
$id = (int) $_GET ['recipe_id'];

$sql = 'SELECT * FROM recipes WHERE recipe_id = ?'; //was missing the ? smh
$results = mysqli_execute_query(
    $conn, $sql, [$id]
);
$recipe_id = mysqli_fetch_assoc($results);

$ingredients = explode("*", $recipe_id["ingredients"]); //seperating the ingridents into seperate strings
$steps = explode("*", $recipe_id["steps"]);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Page</title>
    
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>

    <header>
        <?php
            include 'includes/header.php';
        ?>

           <div class="hero">
            <img class="hero-image" src="assets/hero_2x.png" alt="">
            <img class="logo-image" src="assets/logo_2x.png" alt="logo for YUM!">
        </div>

    </header>    


    <main class="recipe-main">
        <div class="recipe-overview">
            
            <a href="index.php" div class="recipe-nav">
                <img src="assets/arrow-left.svg" alt="back arrow">
                <p>All Recipes</p>
            </a>

            <div class="recipe-info">
                <div class="recipe-photo">
                    <img src="<?=e($recipe_id["main_image"])?>" alt="Completed dish image">
                </div>

                <div class="recipe-intro">
                    <div class="title-sub">
                        <h1 class="title"><?=e($recipe_id["title"])?></h1>
                        <h3 class="subtitle"><?=e($recipe_id["subtitle"])?></h3>

                    </div>
                    
                    <p class="description"><?=e($recipe_id["description"])?></p>
                </div>

            </div>

            <!---box that holds both-->
            <div class="ingredients-and-instructions"><!--LEFT SIDE-->
                <div class="ingredients">
                    
                    <div class="servings-and-timing">
                        <div id="hr-line" class="servings">
                            <p class="label">Servings</p>
                            <p class="value"><?=e((string)$recipe_id["servings"])?></p> <!--AI help troublesoot...need to add (string) since this is a integer not text-->
                        </div>
                        
                        <div class="servings">
                            <p class="label">Timing</p>
                            <p class="value"><?=e((string)$recipe_id["total_time"])?></p>
                        </div>

                    </div>

                    <hr>

                                        
                    <div class="ingredients-list-box">
                        <h2>ingredients</h2>
                        <ul class="ingredients-list">
                            <?php foreach ($ingredients as $ingredient):?>
                                <li><?= e($ingredient) ?></li>
                            <?php endforeach?>
                            <!-- <li>¾ lb Carrots</li>
                            <li>¾ lb Carrots</li>
                            <li>4 Boneless, Skinless Chicken Breasts</li>
                            <li>1 Tbsp Ancho Chile Paste</li>
                            <li>¾ lb Carrots</li> -->
                        </ul>

                        <!-- <img src="assets/images/ancho-orange-chicken/ingredients.png" alt="images of ingredients for recipe"> -->
                    </div>

                    <hr>

                    <!-- <div class="tools">
                        <h2>TOOLS</h2>
                        <p>Garlic Press</p>
                    </div> -->
                </div>


                <div class="instructions"> <!--RIGHT SIDE-->
                    <h3 class="instructions-title">instructions</h3>


                    <div class="step-format">
                        <!-- <div class="step-number-left">
                            <p>1</p>
                        </div> -->

                        <div class="step-desc-right">
                            <!--AI helped figured out how to double explode...split into more parts-->
                            <?php foreach ($steps as $step):?>
                                <?php
                                    $step_parts = explode(":", $step, 2); // split the string even further into TWO parts (so its everything before ':' and after)

                                ?>

                                    <h3><?= e($step_parts[0]) ?></h3>
                                    <p> <?=e($step_parts[1])?></p>

                                   <!-- <img src="assets/images/ancho-orange-chicken/step-1.jpg" alt="step image"> -->

                                 <hr>
                            <?php endforeach?>

                        </div>

                       

                    </div>

               

                    <!-- <div class="tip">
                        <h3>A little tip from the kitchen...</h3>
                        <p>Ancho chile is mild and smoky. For a little extra heat, add a pinch of cayenne to the glaze. Refrigerate leftovers within 2 hours and enjoy within 3 days.</p>
                    </div> -->


                </div>
            
            
            </div>


    </main>

    <footer>
      
            <a class="next-recipe" href="index.php" div class="recipe-nav">
                <img src="assets/arrow-right.svg" alt="arrow pointing right">
                <p>lets look at another recipe</p>
            </a>
        
    </footer>

</body>
</html>


