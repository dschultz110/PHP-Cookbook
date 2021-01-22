<?php
    require("include/connect.php");

    if(isset($_GET["id"])){
        $mealTypeId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

        $recipes_mealType_select = $db->prepare("SELECT * FROM recipes JOIN mealTypes ON recipes.mealType=mealTypes.mealTypeId JOIN users ON recipes.userId=users.userId WHERE mealTypes.mealTypeId = :mealTypeId" );
        $recipes_mealType_select->bindValue(":mealTypeId", $mealTypeId);
        $recipes_mealType_select->execute();
        $recipes = $recipes_mealType_select->fetchAll();
    } else {
        $mealTypeId = false;
        header("Location: index.php");
    }

    include("include/head.php");
?>
    <title>Family Cookbook - <?= $recipes[0]["mealTypeName"] ?></title>
</head>
<body>
    <?php include("include/header.php") ?>
    <main>
        <div class="container">
            <div class="nine columns">
                <?php if($mealTypeId && $recipes_mealType_select->rowCount()>0): ?>
                    <h3 class="capitalize"><?= $recipes[0]["mealTypeName"] ?> Recipes</h3>
                    <?php foreach($recipes as $recipe): ?>
                        <div class="row">
                            <div class="two-thirds column">
                                <a class="recipe-name" href="recipe.php?id=<?= $recipe["recipeId"] ?>"><?= $recipe["recipeName"] ?></a>
                            </div>
                            <div class="one-third column">
                                <a class="user-name" href="profile.php"><?= $recipe["firstName"] . " " . $recipe["lastName"] ?></a>
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
                <?php else: ?>
                    <h3>It doesn't look like any exist yet.</h3>
                <?php endif ?>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
</body>
</html>