<?php
    require("include/connect.php");
    global $valid;

    if(isset($_POST["delete"])){
        $recipeId = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
        $recipes_delete = $db->prepare("DELETE FROM recipes WHERE recipeId = :recipeId LIMIT 1");
        $recipes_delete->bindValue(":recipeId", $recipeId, PDO::PARAM_INT);
        $recipes_delete->execute();

        header("Location: index.php");
    }
    if(isset($_POST["update"])
        && !empty($_POST["recipeName"])
        && !empty($_POST["prepTime"])
        && !empty($_POST["cookTime"])
        && ($_POST["mealType"] != -1)
        && !empty($_POST["ingredients"])
        && !empty($_POST["instructions"])
        && !empty($_POST["tags"])){
            $recipeId = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
            $recipeName = filter_input(INPUT_POST, "recipeName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prepTime = filter_input(INPUT_POST, "prepTime", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cookTime = filter_input(INPUT_POST, "cookTime", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mealType = filter_input(INPUT_POST, "mealType", FILTER_VALIDATE_INT);
            $ingredients = filter_input(INPUT_POST, "ingredients", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $instructions = filter_input(INPUT_POST, "instructions", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $tags = strtolower(filter_input(INPUT_POST, "tags", FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            if(strlen($recipeName) <= 50
                && strlen($prepTime) <= 50
                && strlen($cookTime) <= 50
                && strlen($ingredients) <= 1000
                && strlen($instructions) <= 2000
                && strlen($tags) <= 500) {
                    $valid = true;

                    $recipes_update = $db->prepare("UPDATE recipes SET recipeName = :recipeName, prepTime = :prepTime, cookTime = :cookTime, ingredients = :ingredients, instructions = :instructions, tags = :tags, mealType = :mealType WHERE recipeId = :recipeId");
                    $recipes_update->bindValue(":recipeId", $recipeId);
                    $recipes_update->bindValue(":recipeName", $recipeName);
                    $recipes_update->bindValue("mealType", $mealType);
                    $recipes_update->bindValue(":prepTime", $prepTime);
                    $recipes_update->bindValue(":cookTime", $cookTime);
                    $recipes_update->bindValue(":ingredients", $ingredients);
                    $recipes_update->bindValue(":instructions", $instructions);
                    $recipes_update->bindValue(":tags", $tags);
                    $recipes_update->execute();

                    $tagsArray = explode(",", $tags);

                    // insert tags into tags table, converting to lowercase and removing whitespace
                    foreach($tagsArray as $tag){
                        $tags_select = $db->prepare("SELECT LOWER(tagName) FROM tags");
                        $tags_select->execute();
                        $all_tags = $tags_select->fetchAll();

                        $tags_insert = $db->prepare("INSERT INTO tags (tagName) VALUES (:tagName)");
                        $tags_insert->bindValue(":tagName", trim($tag));

                        if(!in_array(trim($tag), $all_tags)){
                            $tags_insert->execute();
                        }
                    }

                    // insert tags and recipe into recipeTags table
                    foreach($tagsArray as $tag){
                        // finds the specific recipe from $_GET defined above
                        $recipes_select = $db->prepare("SELECT recipeId FROM recipes WHERE recipeId = :recipeId");
                        $recipes_select->bindValue(":recipeId", $recipeId);
                        $recipes_select->execute();
                        $recipe = $recipes_select->fetch();

                        // matches the specific tag from $_GET defined above and compares it to the tag in the tag table
                        $tags_select_specific = $db->prepare("SELECT tagId FROM tags WHERE tagName=:tagName");
                        $tags_select_specific->bindValue(":tagName", trim($tag));
                        $tags_select_specific->execute();
                        $specific_tag = $tags_select_specific->fetch();

                        // insert the recipe and tag into the recipeTags table
                        $recipeTags_insert = $db->prepare("INSERT INTO recipeTags (tagId, recipeId) VALUES (:tagId, :recipeId)");
                        $recipeTags_insert->bindValue(":tagId", $specific_tag["tagId"]);
                        $recipeTags_insert->bindValue(":recipeId", $recipe["recipeId"]);
                        $recipeTags_insert->execute();
                    }

                    header("Location: index.php");
                    exit;
            } else {
                $valid = false;
            }
    } else {
        $valid = false;
    }
    include("include/head.php");
?>
    <title>Family Cookbook - Edit Recipe</title>
</head>
<body>
    <?php include("include/header.php"); include("include/side.php") ?>

    <?php if(!$valid): print_r($_POST)?>
        <p>Please make sure all the fields are filled.</p>
    <?php endif ?>
</body>
</html>