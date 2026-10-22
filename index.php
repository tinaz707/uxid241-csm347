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


//ERROR FUNCTION
if(isset($_GET['name'])){ //if the name field was submitted
    $search = $_GET['name'];{       //get it
        if ($search === ''){
            $errors[] = 'Search can not be empty!';
        }
    }
}

//display match


//look through the database and take the recipes as one
if ($search !== ''){ //if the unput is not empty
    foreach ($recipes as $recipe){ //loop through recipes and run each one as recipe(a single one)
        if (str_contains(strtolower($recipe['title']),strtolower($search))){ //if string contains the search term, covert the recipe name to lowercase and user serach to lowecase (this way it can match and come back as true)
             $matches[] = $recipe;//add the match to the new array
        }
    }
}

//if its a match -> display ONLy the match


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

     <!-- ERROR DISPLAY=============================================================  -->
    <?php foreach($errors as $error): ?> 
       <p class="error"><?= e($error) ?></p>  <!-- '?=' shortcut for echo -->
    <?php endforeach; ?>
    <!--============================================================================  -->


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

    <!-- Used ai to troubleshoot foreach, was using ';' rather than : -->
    <div class="recipe-board">
        
        <?php foreach ($recipes as $recipe): ?>   <!-- takes the recipe and puts each as it's own card -->
            <div class="recipe-card">
                <img src="assets/images-renamed/ancho-orange-chicken/dish.jpg" alt="completed recipe image">
            
                    <div class="card-description">
                        <h2><?=e($recipe['title']);?></h2>
                        <p><?=e($recipe['subtitle']);?></p>
                    </div>        
            </div>
        <?php endforeach; ?>

    </div>

   <!--if the match = recipe display it-->

    
</main>

</body>
</html>