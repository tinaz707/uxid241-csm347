<?php
declare(strict_types=1);
session_start();

$conn = require_once 'data/db.php';
require_once 'functions.php';

$search = trim_value('name'); //defines user input
$categories = trim_value('category'); //php reads top to bottom so this has to be first
$errors =search_error($search); //array for errors

    if ($search !== ''){ //if the search is not empty...

                //SEARCHHH
                $like = '%' . $search . '%'; //W4 Lecture -- user input ex %chicken% -- tells SQL to find titles containing 'chicken'
                
                //sql = WHAT i want my db to do
                $sql = 'SELECT * FROM recipes
                        WHERE title LIKE ?'; // ? = value provided/ like a blank

                $result = mysqli_execute_query($conn, $sql, [$like]);
                    //conn = use my db | sql = execute this sql statment | [$like] = put this value into ? | and then save the resule into $result
                                            
                //CATEGORY
            } elseif ($categories !== ''){ //if category is not empty..
                    $sql = 'SELECT * FROM recipes
                                WHERE categories_id = ?';
                    $result = mysqli_execute_query($conn, $sql, [$categories]);

            } else{ //if search is empty and no category is clicked
                    $sql = 'SELECT * FROM recipes';
                    $result = mysqli_execute_query($conn, $sql,);
            }
    
            $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

//===================
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

        <div class="hero">
            <img class="hero-image" src="assets/hero_2x.png" alt="">
            <img class="logo-image" src="assets/logo_2x.png" alt="logo for YUM!">
        </div>


    </header>    

<main>
    <div class="search-bar">
        <form id="search-bar-style" action='index.php' method="get">
            <input id="search-input" placeholder="Search for a yummy recipe!" type="text" name="name" />
            <button type="submit" aria-label="Search">
                
            </button>
        </form>
    </div>

     <!-- ERROR DISPLAY==============================================  -->
    <?php foreach($errors as $error): ?> 
       <p class="error"><?= e($error) ?></p>  <!-- '?=' shortcut for echo -->
    <?php endforeach;?>
    <!--=============================================================  -->

    <div class="filter">
        <p>Filters:</p>
    <!--AI to gelp fix my button formatiing...was missing a form! without the form(how _GET gets the info) the "submit" means nothing-->
        <div>
            <form action="index.php" method="get" class="filter-choices"> <!--VALUE IS DECIDING WHAT THE NEXT CLICK DOES - ?=(echo the result) is $categories === '1'( is chicken ALREADY selected) then '?(if true)' do nothing when clicked again(turn filter off) ': (if false/other wise) turn it back on(click it again)-->
                <button type="submit" name="category" value="<?= $categories === '1' ? '' : '1' ?>" class="filter-choices-button <?= $categories === '1' ? 'active' : '' ?>"> <!--AI: helped to figure out how to add a class: if categories = to '1' echo out active, otherwise echo out nothing/empty ''-->
                    Chicken
                </button>

                <button type="submit" name="category" value="<?= $categories === '2' ? '' : '2' ?>" class="filter-choices-button <?= $categories === '2' ? 'active' : '' ?>">
                    Beef
                </button>

                
                <button type="submit" name="category" value="<?= $categories === '3' ? '' : '3' ?>" class="filter-choices-button <?= $categories === '3' ? 'active' : '' ?>">
                    Vegetarian
                </button>
                
                
                <button type="submit" name="category" value="<?= $categories === '4' ? '' : '4' ?>" class="filter-choices-button <?= $categories === '4' ? 'active' : '' ?>">
                    Seafood
                </button>
                
                
               <button type="submit" name="category" value="<?= $categories === '5' ? '' : '5' ?>" class="filter-choices-button <?= $categories === '5' ? 'active' : '' ?>">
                    Pork
                </button>
                
                
                <button type="submit" name="category" value="<?= $categories === '6' ? '' : '6' ?>" class="filter-choices-button <?= $categories === '6' ? 'active' : '' ?>">
                    Turkey
                </button>

            </form>
    
        </div>
    </div>

    <!-- NO MATCH====================================================  -->
    <?php if ( $search !== '' && empty($recipes)): ?> <!--if the input has no match with anything in the array-->
        <p>Sorry we don't have<?= e($search)?>!</p> <!--display this-->
    <?php endif; ?>
    <!--=============================================================  -->

    <!-- Used ai to troubleshoot foreach loop, was using ';' rather than : -->
    <div class="recipe-board">
    <!-- RECIPE CARD DISPLAY====================================================  -->
        <?php  //if the matches is empty show the cards for all , else show the matches
            // if ($search !== ''){ //if the search is not empty...
            //     foreach ($recipes as $recipe){ //take the matches and make each item in the array as one 
            //     echo recipe_card($recipe); //uses the function to display matches
            //     }
            // } elseif ($categories !== ''){ //if category is not empty..
            //     foreach($category_matches as $category_match){
            //         echo recipe_card($category_match);
            //     }
            // } else{ //if search is empty and no button is clicked
            //     foreach ($recipes as $recipe){
            //     echo recipe_card($recipe); //uses the function to display all 
            //     }
            // }

           foreach ($recipes as $recipe){
                echo recipe_card($recipe);
           }
        
        ?>
    <!--=============================================================  -->

    </div>


    
</main>


</body>
</html>