<?php
declare(strict_types=1);

require_once 'db.php';


function trim_value(string $key): string { //function trim_value gets a string and returns a string (": string")
    return trim($_GET[$key] ?? ''); //get the data and if it exists and isn't null(??) give the value or give an empty string('')
} //this function is for the search input!!

function e(string $key): string {
    return htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); 
} //this function is to safely display text


$sql = 'SELECT * FROM recipes'; // Select=recieve data | *=select all columns | FROM...=gets data from table
$result = mysqli_query($conn, $sql); //run the SQL using db connection
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC); // get the rows and sroes them in recipes



$name = trim_value('name'); //this will get user input

//-----
// AI: ChatGPT (GPT-6), 2026-10-07.
// Helped debug incorrect array initialization.
$errors = []; //place for all the errors
$matches = []; //place for matches to sit
//-----



//-----
//error function
if (isset($_GET['name'])){ //isset will check if something was submitted basically
        if ($name === ''){ //if its empty give an error
        $errors[] = 'Enter a recipe please!'; //this will add this new message it to the error array
    } 
}
//-----



//-----
// AI-assisted recipe search logic using foreach,
// str_contains(), and strtolower().

//look through each recipe
if ($name !== ''){ //if the input is NOT empty
     foreach ($recipes as $recipe){ //loop through recipes and run each one as recipe(a single one)
    if (str_contains(strtolower($recipe['title']),strtolower($name))){ //if string contains the search term, covert the recipe name to lowercase and user serach to lowecase (this way it can match and come back as true)
        $matches[] = $recipe; //add the match to the new array
    } 
 } 
}


//AI: ChatGPT (GPT-6), 2026-10-14
//Helped connect search results to the main list
if ($name !== ''){
    $display_recipes = $matches; //if the search is not empty display the matching recipe
} else{
    $display_recipes = $recipes; //else display all the recipes
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
            .error{
                color: #FF0000;
            }

            .success{
                color: #008000;
            }
    </style>
</head>
<body>
    <h1>W3</h1>

    <!-- search -->
    <form action='index.php' method="get">
        <input placeholder="Search for a recipe!" type="text" name="name" />
        <button type="submit">Search!</button>
    </form>

   <!-- error display -->
    <?php foreach($errors as $error): ?>
       <p class="error"><?= e($error) ?></p>  <!-- '?=' shortcut for echo -->
    <?php endforeach; ?>    

    <!-- user search display -->
    <?php if ($name !==''): ?> <!--if the input is not empty display the following-->
        <p class="success">You searched for <?= e($name)?> </p> 
    <?php endif; ?>

    <h2>Recipes</h2>

    <!--
    //AI: ChatGPT (GPT-6), 2026-10-14
    //Helped setting up foreach loop to correctly show recipe title and description 
    -->
    <?php foreach ($display_recipes as $recipe): ?>
        <h3><?= e($recipe['title']) ?></h3>
        <p><?= e($recipe['description']) ?? ''?></p> <!--If the value exists ?? and isn't null '', use it -->
    <?php endforeach; ?>

 



  

    <!-- AI: ChatGPT (GPT-6), 2026-10-07.
     Helped implement a conditional to display a message when no matching recipes are found. -->

    <!--No match display!-->
    <?php if ( $name !== '' && empty($matches)): ?> <!--if the input has no match with anything in the array-->
        <p>Sorry we don't have <?= e($name)?> !</p> <!--display this-->
    <?php endif; ?>
 
    
</body>
</html>