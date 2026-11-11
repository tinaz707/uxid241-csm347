<?php
declare(strict_types=1);
session_start();

$conn = require_once 'data/db.php';
require_once 'functions.php';


//Ai helped me verify out the steps to setting up (form submitted -> getting email+pw --> find user....)
$errors = []; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //if a form is submitting then...

    // receiving form info
    $email = trim_post('email');                                    //getting the user input - trimming space - turning it into string
    $plain = trim_post('password');


    //Finding the information in the database
    $results = mysqli_execute_query(                                //run a query (the sql instructions to find info)
        $conn,                                                      //my connection to my database which i define at the start
        'SELECT id, password_hash FROM users WHERE email = ? ',     //select = give the id + pw | from = look inside 'users' table in DB | Where = only give the user whose email matches ?(where ?=[email])
        [$email]                                                   
    );                                                              //go to user table -> find email match -> get id + pw


    $user = mysqli_fetch_assoc($results);                            //take the db row from results and turn it into an ASSOCIATIVE array(has the named keys rather than number positions like 0,1,2...)
    


    //email verify
    if ($user !== null && password_verify($plain, $user['password_hash'])) { //if someone has that email in the DB...and the password matches the hash
    session_regenerate_id(true);                                             //log in was a success so replace the session with a new ID(replacing the random one created from the session(start...since now users are logged in))

    // store the logged-in user's ID into the session
    $_SESSION['user_id'] = $user['id'];

    header('Location: admin/index.php'); //once logged in send them to this page
    exit;                               //stop running this page
    }
         else{
                $errors[] = 'Invalid email or password.'; //if no email matches or if email matches but pw is wrong...add this error to the errors array
    }
       
}


///log out?
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/main.css"> <!--renamed to main bc xxamp wasn't loading it when it was called styles???-->
</head>

<body>
    <header>
        <?php
        include 'includes/header.php';
        ?>
    </header>   

  <main class="login-page">
        <div class="login">
        <h2>Log In</h2>
        <form id="login-style" action='login.php' method="post">
            <input class="login-input" placeholder="Email" type="text" name="email"/>
            <input class="login-input" placeholder="Password*" type="password" name="password" required/>
            <button type="submit" aria-label="submit">Submit</button>
        </form>

            <?php foreach($errors as $error): ?> 
                <p class="login-error"><?= e($error) ?></p>  <!-- '?=' shortcut for echo -->
            <?php endforeach;?>
    </div>
    </main>
    
  
</body>


</html>