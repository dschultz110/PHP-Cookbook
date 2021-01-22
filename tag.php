<?php
    require("include/connect.php");

    if(isset($_GET["tag"])){
        $getTag = filter_input(INPUT_GET, "tag", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tagName = str_replace("-", " ", $getTag);
        //echo $tagId;
        $statement = $db->prepare("SELECT * FROM recipes JOIN recipeTags ON recipes.recipeId=recipeTags.recipeId JOIN tags ON recipeTags.tagId=tags.tagId LEFT OUTER JOIN users ON recipes.userId=users.userId WHERE tags.tagName=:tag");
        $statement->bindValue(":tag", $tagName);
        $statement->execute();
        $recipes = $statement->fetchAll();
    } else {
        $tagName = false;
        header("Location: index.php");
    }
    include("include/head.php");
?>
    <title>Family Cookbook</title>
</head>
<body>
    <?php include("include/header.php") ?>
    <main>
        <div class="container">
            <div class="nine columns">
                <?php if($tagName): ?>
                    <h3 class="capitalize"><?= $tagName ?> Recipes</h3>
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
                                    <li class="tag"><a href="tag.php?tag=<?= trim($getTag) ?>"><?=$tag?></a></li>
                                <?php endif; endforeach ?>
                            </ul>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
                <?php if($statement->rowCount() < 1): ?>
                    <div class="row">
                        <div class="twelve columns">
                            <h3>Tag "<?= $tagName ?>" not found</h3>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
</body>
</html>