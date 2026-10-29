<?php
declare(strict_types=1);


function trim_value(string $key): string { //function trim_value gets a string and returns a string (": string")
    return trim($_GET[$key] ?? ''); //get the data and if it exists and isn't null(??) give the value or give an empty string('')
} //this function is for the search input!!

function e(string $key): string {
    return htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); 
} //this function is to safely display text

function recipe_card(array $recipe):string{ //recipe car will give one recipe an thats an array
     return '<div class="recipe-card">
                <img src="assets/images-renamed/ancho-orange-chicken/dish.jpg" alt="completed recipe image">
            
                    <div class="card-description">
                        <h2>'.e($recipe["title"]).'</h2>  
                        <p>'.e($recipe["subtitle"]).'</p>
                    </div>        
            </div>';
} //AI to help combine html with php --> remember to connect the html with the php you have to use a dot!! 



// DEFINE MATCHES ==============================================
// the function search_match will need an array/list of the recipes AND the search result, and bring that back in a array/list
function search_match(array $recipes, string $search): array{

    $matches = [];

    if ($search !== '' ){ //if the input is not empty
    foreach ($recipes as $recipe){ //loop through recipes and run each one as recipe(a single one)
        if (str_contains(strtolower($recipe['title']),strtolower($search))){ //if string contains the search term, covert the recipe name to lowercase and user serach to lowecase (this way it can match and come back as true)
             $matches[] = $recipe;//add the match to the new array
        }
        }
    }
    
    return $matches;
}

//DEFINE ERRORS
function search_error (string $search): array{ //define blank search error
    
    $errors=[];    

    if(isset($_GET['name'])){ //if the name field was submitted
        if ($search === ''){ //if its empty then its an error
            $errors[] = 'Search can not be empty!';
        }
    }

    return $errors;
}
// =============================================================

//RECIPE CARD DISPLAY

// function card_display(array $recipes): array{

//     $card_display = [];
//         if($search === ''){ //if the name field is empty show all the recipes
//                 foreach ($recipes as $recipe){
//                 echo recipe_card($recipe); //uses the function to display all 
//                 }
//             } else {
//                 foreach ($matches as $match){ //take the matches and make each item in the array as one 
//                 echo recipe_card($match); //uses the function to display matches
//                 }
//             }

//         return $card_display;
// }


?>
