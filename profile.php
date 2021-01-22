<?php
    require("include/connect.php");

    if(isset($_GET["userId"])){
        $userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_NUMBER_INT);
        $profile_user_select = $db->prepare("SELECT * FROM users WHERE userId = :userId");
        $profile_user_select->bindValue(":userId", $userId, PDO::PARAM_INT);
    } else {
        $email = $_SESSION["user"];
        $profile_user_select = $db->prepare("SELECT * FROM users WHERE email = :email");
        $profile_user_select->bindValue(":email", $email);
    }
    $profile_user_select->execute();
    $user = $profile_user_select->fetch();
    $userId = $user["userId"];

    // if($profile_user_select->rowCount() != 1){
    //     header("location: index.php");
    // }

    $profile_recipes_select = $db->prepare("SELECT * FROM recipes JOIN users ON recipes.userId=users.userId WHERE users.userId=:userId");
    $profile_recipes_select->bindValue(":userId", $userId, PDO::PARAM_INT);
    $profile_recipes_select->execute();
    $profile_recipes = $profile_recipes_select->fetchAll();

    include("include/head.php");
?>
    <title><?= $user["firstName"] ?>'s Profile</title>
</head>
<body>
    <?php include("include/header.php")?>
    <main>
        <div class="container">
        <div class="nine columns">
        <h3><?= $user["firstName"] ?>'s Recipes</h3>
            <?php if($profile_recipes_select->rowCount() == 0): ?>
                <div class="row">
                    <div class="twelve columns">
                        <p>You have no recipes. <a href="new.php">Create one now!</a></p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach($profile_recipes as $recipe): ?>
                <div class="row">
                    <div class="twelve columns">
                        <a class="recipe-name" href="recipe.php?id=<?= $recipe["recipeId"] ?>"><?= $recipe["recipeName"] ?></a>
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
                            <li class="tag"><a href="tag.php?tag=<?= trim($tag) ?>"><?=$tag?></a></li>
                        <?php endif; endforeach ?>
                    </ul>
                </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
        <div class="three columns">
            <?php include("include/side.php") ?>
        </div>
    </div>
    </main>
</body>
</html>