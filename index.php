<?php
declare(strict_types=1);

$conn = require_once 'data/db.php';
require_once 'functions.php';

//from lecture 
$sql = 'SELECT * FROM recipes'; //Select=recieve data | *=select all columns | FROM...=gets data from table
$result = mysqli_query($conn, $sql); //run the SQL using db connection
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC); // get the rows and puts them in recipes , this defines recipes


$search = trim_value('name'); //defines user input
$errors =[]; //array for erroys
$matches =[]; //array for matches




//ERROR FUNCTION ==============================================
if(isset($_GET['name'])){ //if the name field was submitted
        if ($search === ''){ //if its empty then its an error
            $errors[] = 'Search can not be empty!';
        }
 }

//=============================================================



//DEFINE MATCHES ==============================================
//look through the database and take the recipes as one
if ($search !== '' ){ //if the unput is not empty
    foreach ($recipes as $recipe){ //loop through recipes and run each one as recipe(a single one)
        if (str_contains(strtolower($recipe['title']),strtolower($search))){ //if string contains the search term, covert the recipe name to lowercase and user serach to lowecase (this way it can match and come back as true)
             $matches[] = $recipe;//add the match to the new array
        }
    }
}
//=============================================================


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    
<div class="hero">
   <img class="hero-image" src="assets/hero_2x.png" alt="zoomed picture of person in kitchen">
   <img class="logo-image" src="assets/logo_2x.png" alt="logo for YUM!">
</div>

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
    <?php endforeach; ?>
    <!--=============================================================  -->


    <div class="filter">
        <p>Filters:</p>
        <div class="filter-choices">
                
            <button class="filter-choices-button">Chicken</button>
            <button class="filter-choices-button">Beef</button>
            <button class="filter-choices-button">Vegetarian </button>
            <button class="filter-choices-button">Seafood</button>
            <button class="filter-choices-button">Pork</button>
            <button class="filter-choices-button">Turkey</button>

        </div>
    </div>

    <!-- NO MATCH====================================================  -->
    <?php if ( $search !== '' && empty($matches)): ?> <!--if the input has no match with anything in the array-->
        <p>Sorry we don't have <?= e($search)?>!</p> <!--display this-->
    <?php endif; ?>
    <!--=============================================================  -->

    <!-- Used ai to troubleshoot foreach loop, was using ';' rather than : -->
    <div class="recipe-board">
    <!-- RECIPE CARD DISPLAY====================================================  -->
        <?php  //if the matches is empty show the cards for all , else show the matches
            if($search === ''){ //if the name field is empty show all the recipes
                foreach ($recipes as $recipe){
                echo recipe_card($recipe); //uses the function to display all 
                }
            } else {
                foreach ($matches as $match){ //take the matches and make each item in the array as one 
                echo recipe_card($match); //uses the function to display matches
                }
            }
        ?>
    <!--=============================================================  -->

    </div>


    
</main>

</body>
</html>