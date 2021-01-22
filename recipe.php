<?php
    require("include/connect.php");
    if(isset($_SESSION["user"])){
        $user_select = $db->prepare("SELECT * FROM users WHERE email = :email");
        $user_select->bindValue(":email", $_SESSION["user"]);
        $user_select->execute();
        $user = $user_select->fetch();
    }
    if(isset($_GET["id"])){
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

        $recipes_select = $db->prepare("SELECT * FROM recipes LEFT OUTER JOIN users ON recipes.userId=users.userId WHERE recipeId = :id");
        $recipes_select->bindValue(":id", $id, PDO::PARAM_INT);
        $recipes_select->execute();
        $recipe = $recipes_select->fetch();
    } else {
        $id = false;
        header("Location: index.php");
    }
    if(!$id || $recipes_select->rowCount() != 1) {
        header("Location: index.php");
    }
    include("include/head.php");
?>
    <title>Family Cookbook - <?= $recipe["recipeName"] ?></title>
</head>
<body>
    <?php include("include/header.php")?>
    <main>
        <div class="container">
        <div class="nine columns">
            <div class="row">
                <div class="two-thirds column">
                    <a class="recipe-name" href="recipe.php?id=<?= $recipe["recipeId"] ?>"><?= $recipe["recipeName"] ?></a>
                </div>
                <div class="one-third column">
                    <a class="user-name" href="profile.php?userId=<?= $recipe["userId"] ?>"><?= $recipe["firstName"] . " " . $recipe["lastName"] ?></a>
                </div>
            </div>
            <div class="row">
                <div class="twelve columns">
                    <p class="title">Ingredients: </p>
                    <?= htmlspecialchars_decode($recipe["ingredients"]) ?>
                </div>
            </div>
            <div class="row">
                <div class="twelve columns">
                    <p class="title">Directions: </p>
                    <?= htmlspecialchars_decode($recipe["instructions"]) ?>
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
            <?php if(isset($_SESSION["user"])): ?>
                <?php if($user["userId"] == $recipe["userId"] || $user["permissionLevel"] == 2): ?>
                    <div class="row">
                        <a href="edit.php?recipeId=<?= $recipe["recipeId"] ?>">Edit</a>
                    </div>
                <?php endif ?>
            <?php endif ?>
        </div>
        <div class="three columns">
            <?php include("include/side.php") ?>
        </div>
    </div>
    </main>
</body>
</html>