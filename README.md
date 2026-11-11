# uxid241-csm347
IDM 232/UXID241 - YUM! is an online cookbook build with PHP, MySQL, HTML, and CSS. Users are able to browse recipes, search recipes through a search bar, and filter recipes by categories. Included is also a login where logged in users have access to adding, editing and even deleting recipes!

# How do I run this project locally?
First download the project code and place the folder into your local server's 'htdocs' folder. To open it, run either XAMPP or MAMP and start Apache and MySQL. Create a new database for this project and import uxid241.sql into the database to create the required tables and data. Copy config.example.php and change it to config.php. Open the config.php and enter the credentials of your local database. Finally open the project through localhost in your web browser.

# Admin Log-In 
Seeded admin account is included, go to login page and use these credentials below to access admin features such as adding, editing and deleting recipes:

Email: test@testemail.com
Password: test77

# Chosen Feature
For the Beta, both a search function AND category function is available. Users can search for recipes with a title through the search bar and/or user the category filtering to find a recipe on the homepage


## AI use
Overall: Used to help understand some of the concepts as well as using it for guidance on how to implement the concepts. Using it to walk me through the process of setting up php/ how to go about certain tasks. Also used it a lot to troubleshoot 

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
//Help to Verify what steps to take for building out the log in, helped troubleshoot errors and remove redundant code I had
//Help to figure out changing login to logout in the header once user was logged in
//Helped troubleshoot when I changed the search and category filtering to prepared SQL statements
//Helped troubleshooting when I continued to update the recipe_card function