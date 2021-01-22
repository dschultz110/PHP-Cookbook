<?php
    require("include/connect.php");

    if(isset($_POST["search"])){
        $searchTerm = filter_input(INPUT_POST, "searchTerm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $searchMealType = filter_input(INPUT_POST, "navbarMealType", FILTER_VALIDATE_INT);

        if($searchMealType === -1){
            $search_select = $db->prepare("SELECT * FROM recipes LEFT OUTER JOIN users ON recipes.userID=users.userID JOIN mealTypes on recipes.mealType=mealTypes.mealTypeId WHERE (lower(recipeName) LIKE concat("%", :searchTerm, "%") OR lower(tags) LIKE concat("%", :searchTerm, "%") OR lower(ingredients) LIKE concat("%", :searchTerm, "%")) AND recipes.MealType > 0");
        } else {
            $search_select = $db->prepare("SELECT * FROM recipes JOIN users ON recipes.userID=users.userID JOIN mealTypes on recipes.mealType=mealTypes.mealTypeId WHERE (lower(recipeName) LIKE concat("%", :searchTerm, "%") OR lower(tags) LIKE concat("%", :searchTerm, "%") OR lower(ingredients) LIKE concat("%", :searchTerm, "%")) AND recipes.MealType=:mealType");
            $search_select->bindValue(":mealType", $searchMealType);
        }
        $search_select->bindValue(":searchTerm", strtolower($searchTerm));
        $search_select->execute();
        $recipes = $search_select->fetchAll();
    }

    require("include/head.php");
?>

    <title>Family Cookbook - Search</title>
</head>
<body>
    <?php include("include/header.php") ?>
    <main>
        <div class="container">
            <div class="nine columns">
                <?php if($search_select->rowCount() > 0): ?>
                <h3>Results: </h3>
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
                        <a href="recipe.php?id=<?= $recipe["recipeId"] ?>">See full details...</a>
                        <br><br>
                    </div>
                <?php endforeach; else: ?>
                    <h3>No results found for <?= $searchTerm ?>...</h3>
                <?php endif ?>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
</body>
</html>

