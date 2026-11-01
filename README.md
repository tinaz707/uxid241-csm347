# uxid241-csm347
IDM 232 - An Online Cookbook where you can search, add, edit and delete recipes.

# How do I run this project locally?
First download the project code and place the folder into your local server's 'htdocs' folder. To open it, run either XAMPP or MAMP and start Apache and MySQL. Create a new database for this project and import uxid241.sql into the database to create the required tables and data. Copy config.example.php and change it to config.php. Open the config.php and enter the credentials of your local database. Finally open the project through localhost in your web browser.

## AI use
Overall: Used to help understand some of the concepts such as the recipe-search loop using foreach, str_contains(), and strtolower() as well as using it for guidance on how to implement the concepts. Using it to walk me through the process of setting up php.

ChatGPT-6:
//Helped me with figuring out how to upload data into the database
//Helped develop logic for my $recipes loop and to be able to find matching recipes in an array
//Helped implement a conditional to display a message when no matching recipes are found
//Helped setting up foreach loop to correctly show recipe title and description 
//Helped connect search results to the main recipe list
//Helped understand any errors that came along the process
//Help fix my button formatting...was missing a form! to get the $_GET
//Helped figure out how to add a class when button was clicked <?= $categories === '1' ? 'active' : '' ?>
    //Also used this logic to figure out how to have the button be selected and unselected and used AI to verify logic was correct
//Helped troubleshoot my categories function when I came across errors
//Help troubleshoot my recipe_card issue with the main_image; forgot to add a '.' at the end of '.e($recipe["main_image"]).' 
//Used to fix responsive CSS styling 