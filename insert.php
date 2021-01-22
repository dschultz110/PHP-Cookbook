<?php
    require("include/connect.php");
    GLOBAL $valid;

    $users_select = $db->prepare("SELECT userId FROM users WHERE email = :email");
    $users_select->bindValue(":email", $_SESSION["user"]);
    $users_select->execute();
    $user = $users_select->fetch();
    $userId = $user["userId"];

    // checks if all fields were filled
    if($_POST && !empty($_POST["recipeName"])
        && !empty($_POST["prepTime"])
        && !empty($_POST["cookTime"])
        && ($_POST["mealType"] != -1)
        && !empty($_POST["ingredients"])
        && !empty($_POST["instructions"])
        && !empty($_POST["tags"])){
            $recipeName = filter_input(INPUT_POST, "recipeName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prepTime = filter_input(INPUT_POST, "prepTime", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cookTime = filter_input(INPUT_POST, "cookTime", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mealType = filter_input(INPUT_POST, "mealType", FILTER_VALIDATE_INT);
            $ingredients = filter_input(INPUT_POST, "ingredients", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $instructions = filter_input(INPUT_POST, "instructions", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $tags = strtolower(filter_input(INPUT_POST, "tags", FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            // checks if the fields are acceptable lengths for the database
            if(strlen($recipeName) <= 50
                && strlen($prepTime) <= 50
                && strlen($cookTime) <= 50
                && strlen($ingredients) <= 1000
                && strlen($instructions) <= 2000
                && strlen($tags) <= 500){

                    $valid = true;

                    $recipes_insert = $db->prepare("INSERT INTO recipes (userId, recipeName, tags, prepTime, cookTime, mealType, ingredients, instructions) VALUES (:userId, :recipeName, :tags, :prepTime, :cookTime, :mealType, :ingredients, :instructions)");
                    $recipes_insert->bindValue(":userId", $userId);
                    $recipes_insert->bindValue(":recipeName", $recipeName);
                    $recipes_insert->bindValue(":tags", $tags);
                    $recipes_insert->bindValue(":prepTime", $prepTime);
                    $recipes_insert->bindValue(":cookTime", $cookTime);
                    $recipes_insert->bindValue(":mealType", $mealType);
                    $recipes_insert->bindValue(":ingredients", $ingredients);
                    $recipes_insert->bindValue(":instructions", $instructions);
                    $recipes_insert->execute();

                    $tagsArray = explode(",", $tags);
                    foreach($tagsArray as $tag){
                        $tag = trim($tag);
                        if(strlen($tag) > 0){
                            $tags_select = $db->prepare("SELECT TRIM(LOWER(tagName)) FROM tags");
                            $tags_select->execute();
                            $all_tags = $tags_select->fetchAll();

                            $tags_insert = $db->prepare("INSERT INTO tags (tagName) VALUES (:tagName)");
                            $tags_insert->bindValue(":tagName", strtolower($tag));

                            if(!in_array(strtolower($tag), $all_tags)){
                                $tags_insert->execute();
                            }
                        }
                    }

                    foreach($tagsArray as $tag){
                        $tag = trim($tag);
                        if(strlen($tag) > 0){
                            $recipes_select = $db->prepare("SELECT recipeId FROM recipes WHERE recipeId = (SELECT MAX(recipeId) FROM recipes)");
                            $recipes_select->execute();
                            $recipe = $recipes_select->fetch();

                            $tags_select_specific = $db->prepare("SELECT tagName, tagId FROM tags WHERE tagName=:tagName");
                            $tags_select_specific->bindValue(":tagName", strtolower($tag));
                            $tags_select_specific->execute();
                            $specific_tag = $tags_select_specific->fetch();

                            $recipeTags_insert = $db->prepare("INSERT INTO recipeTags (tagId, recipeId) VALUES (:tagId, :recipeId)");
                            $recipeTags_insert->bindValue(":tagId", $specific_tag["tagId"]);
                            $recipeTags_insert->bindValue(":recipeId", $recipe["recipeId"]);
                            $recipeTags_insert->execute();
                        }
                    }

                    header("Location: index.php");
                    exit;
            } else {
                $valid = false;
            }
    }
    include("include/head.php");
?>
    <title>Invalid Recipe</title>
</head>
<body>
    <?php include("include/header.php") ?>
    <main>
        <div class="container">
            <div class="nine columns">
                <?php if($_POST && !$valid): ?>
                    <h3>Some of the information in your recipe was invalid.</h3>
                <?php else: ?>
                    <h3>Please select Edit from the recipe you wish to change.</h3>
                <?php endif ?>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
</body>
</html>