<?php
    require("include/connect.php");

    $recipe_select = $db->prepare("SELECT * FROM recipes LEFT OUTER JOIN users ON recipes.userId=users.userId ORDER BY recipeId DESC");
    $recipe_select->execute();
    $recipes = $recipe_select->fetchAll();

    if(isset($_SESSION["user"])){
        $users_select = $db->prepare("SELECT * FROM users WHERE email = :email");
        $users_select->bindValue(":email", $_SESSION["user"]);
        $users_select->execute();
        $user = $users_select->fetch();
    }
    if(isset($_GET["logout"])){
        session_destroy();
        unset($_SESSION["user"]);
        header("location: index.php");
    }
    if(isset($_GET["redirect"])){
        if($_GET["redirect"] == "new"){
            header("location: new.php");
        }
        if($_GET["redirect"] == "mealTypes"){
            header("location: editMealType.php");
        }
    }

    include("include/head.php");
?>

    <title>Family Cookbook</title>
</head>
<body>
    <?php include("include/header.php")?>
    <main>
        <div class="container">
        <div class="nine columns">
            <?php if(isset($_SESSION["user"])): ?>
                <p class="welcome">Welcome <?= $user["firstName"] ?></p>
            <?php endif ?>
            <h3>Recent Recipes</h3>
            <?php foreach($recipes as $recipe): ?>
            <div class="row">
                <div class="two-thirds column">
                    <a class="recipe-name" href="recipe.php?id=<?= $recipe["recipeId"] ?>"><?= $recipe["recipeName"] ?></a>
                </div>
                <div class="one-third column">
                    <a class="user-name" href="profile.php?userId=<?= $recipe["userId"] ?>"><?= $recipe["firstName"] . " " . $recipe["lastName"] ?></a>
                </div>
            </div>
            <div class="row">
                <div class="one-half column">
                    <?= "Preparation time: " . $recipe["prepTime"] ?>
                </div>
                <div class="one-half column">
                    <?= "Cook Time: " . $recipe["cookTime"] ?>
                </div>
            </div>
            <div class="row">
                <ul>
                    <?php $tags = explode(",", $recipe["tags"]); foreach($tags as $tag): if(strlen(trim($tag)) > 0): ?>
                        <?php $tagRefined = str_replace(" ", "-", trim($tag)) ?>
                        <li class="tag"><a href="tag.php?tag=<?= $tagRefined ?>"><?=$tag?></a></li>
                    <?php endif; endforeach ?>
                </ul>
                <a href="recipe.php?id=<?= $recipe["recipeId"] ?>">See full details...</a>
                <br><br>
            </div>
            <?php endforeach ?>
        </div>
        <div class="three columns">
            <?php include("include/side.php") ?>
        </div>
    </div>
    </main>

</body>
</html>
