<?php
    $mealTypes_header_select = $db->prepare("SELECT * FROM mealTypes");
    $mealTypes_header_select->execute();
    $header_mealTypes = $mealTypes_header_select->fetchAll();
?>

<div class="container">
    <div class="twelve columns">
        <header>
            <h1>Family Cookbook</h1>
            <h2>A collection of the family's best recipes accumulated over the past generation.</h2>
            <nav>
                <div class="container">
                    <div class="one-half column">
                        <ul class="navbar-list main-links">
                            <li class="navbar-item">
                                <a class="navbar-link" href="index.php">Home</a>
                            </li>
                            <li class="navbar-item">
                                <a href="new.php?redirect=new" class="navbar-link">New Recipe</a>
                            </li>
                        </ul>
                    </div>
                    <div class="one-half column">
                        <ul class="navbar-list meta-links">
                            <?php if(isset($_SESSION["user"])): ?>
                                <li class="navbar-item">
                                    <a class="navbar-link" href="profile.php">Profile</a>
                                </li>
                                <li class="navbar-item">
                                    <a href="index.php?logout=1" class="navbar-link">Log-Out</a>
                                </li>
                            <?php else: ?>
                                <li class="navbar-item">
                                    <a class="navbar-link" href="login.php">Log-In</a>
                                </li>
                                <li class="navbar-item">
                                    <a href="register.php" class="navbar-link">Register</a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content"></div>
        </header>
    </div>
</div>


