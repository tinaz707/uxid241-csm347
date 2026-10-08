<?php
declare(strict_types=1);


function trim_value(string $key): string { //function trim_value gets a string and returns a string (": string")
    return trim($_GET[$key] ?? ''); //get the data and if it exists and isn't null(??) give the value or give an empty string('')
} //this function is for the search input!!

function e(string $key): string {
    return htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); 
} //this function is to safely display text

// array of some of the sample recipes
$recipes = [
    "Ancho-Orange Chicken",
    "Beef Medallions & Mushroom Sauce",
    "Broccoli & Basil Pesto Sandwiches",
    "Bucatini Alfredo",
    "Bucatini & Tomato Sauce",
    "Roasted Cauliflower Salad",
    "Roasted Chicken & Fall Vegetables",
    "Salmon & Honey-Glazed Carrots",
    "Seared Chicken & Mashed Potatoes",
    "Seared Steaks & Garlic Butter",
    "Shrimp Fra Diavolo",
    "Spicy Pork & Korean Rice Cakes",
    "Sweet & Sour Vegetable Stir-Fry",
    "Thai Curry Chicken"
];

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
    if (str_contains(strtolower($recipe),strtolower($name))){ //if string contains the search term, covert the recipe name to lowercase and user serach to lowecase (this way it can match and come back as true)
        $matches[] = $recipe; //add the match to the new array
    } 
 } 
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
    <h1>W2</h1>

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

    <!-- matching recipes display -->
    <?php foreach($matches as $recipe): ?> <!--loop(':' = open a loop) through matches array -->
        <p><?= e($recipe) ?></p> <!--paragraph created and echos the recipe after it is safely converted(e)-->
    <?php endforeach; ?>


    //-----
    <!-- AI: ChatGPT (GPT-6), 2026-10-07.
     Helped implement a conditional to display a message when no matching recipes are found. -->

    <!--No match display!-->
    <?php if ( $name !== '' && empty($matches)): ?> <!--if the input has no match with anything in the array-->
        <p>Sorry we don't have <?= e($name)?> !</p> <!--display this-->
    <?php endif; ?>
    //-----
    
</body>
</html>