<?php 
declare(strict_types=1);

?>
        <nav>
            <ul class="menu">
                <li class="menu-item">
                    <a class="menu-item-link" href="index.php">Recipes</a>
                </li>
<!--AI to help with setting up logout, helped to figure out how to show the text without using echo-->
                <li class="menu-item"> <!-- if  session is(isset=if) where the user is logged in show logout or else if not show login  -->
                   <?php if (isset($_SESSION['user_id'])):?>        
                        <a class="menu-item-link" href="../logout.php">Logout</a>
                    <?php else:?>
                        <a class="menu-item-link" href="login.php">Login</a>
                    <?php endif;?>

                    
                </li>
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
