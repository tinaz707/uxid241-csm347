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
} //AI to help combine html with php --> remeber to connect the html with the php you have to use a dot!! 

?>
