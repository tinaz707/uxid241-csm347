<?php 
declare(strict_types=1);


//Used AI to figure out troubleshooting with header links when logged in vs logged out -> rather than file location, used the url...
?>
        <nav>
            <ul class="menu">

<!--AI to help with setting up logout, helped to figure out how to show the text without using echo-->
                 <!-- if  session is(isset=if) where the user is logged in show logout or else if not show login  -->
                   <?php if (isset($_SESSION['user_id'])):?>   
                        <li class="menu-item">
                            <a class="menu-item-link" href="../index.php">Recipes</a>
                      </li>
                    
                    <li class="menu-item">
                        <a class="menu-item-link" href="../admin/add-recipe.php">Add Recipe</a>
                    </li>

                        <li class="menu-item">
                        <a class="menu-item-link" href="logout.php">Logout</a>
                    </li>

                    <?php else:?>     
                        <li class="menu-item">
                            <a class="menu-item-link" href="/~csm347/idm232/index.php">Recipes</a>
                      </li>
                        <li class="menu-item">
                            <a class="menu-item-link" href="login.php">Login</a>
                        </li>
                        
                    <?php endif;?>

                    
            </ul>

             <div class="menu-icon">
                <div class="open-menu">
                    <img src="assets/menu-open.png" alt="hamburger menu icon">
                </div>

                <div class="close-icon">
                    <img src="assets/menu-close.png" alt="x">
                </div>
            </div>
        </nav>
