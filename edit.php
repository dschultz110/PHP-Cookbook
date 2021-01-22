<?php
    require("include/connect.php");

    if(!isset($_SESSION["user"])){
        header("location: login.php");
    }

    $mealTypes_select = $db->prepare("SELECT * FROM mealTypes");
    $mealTypes_select->execute();
    $mealTypes = $mealTypes_select->fetchAll();

    if(isset($_GET["recipeId"])){
        $recipeId = filter_input(INPUT_GET, "recipeId", FILTER_SANITIZE_NUMBER_INT);

        $recipes_select = $db->prepare("SELECT * FROM recipes LEFT OUTER JOIN users ON recipes.userID = users.userId WHERE recipeId = :recipeId");
        $recipes_select->bindValue(":recipeId", $recipeId, PDO::PARAM_INT);
        $recipes_select->execute();
        $recipe = $recipes_select->fetch();

        if(isset($_SESSION["user"])){
            $email = $_SESSION["user"];
            $user_select = $db->prepare("SELECT * FROM users WHERE email = :email");
            $user_select->bindValue(":email", $email);
            $user_select->execute();
            $user = $user_select->fetch();
            $recipe_creator = $recipe["userId"];

            if($user["permissionLevel"] < 2 && $user["userId"] != $recipe_creator){
                header("location: index.php");
            }
        }
    } else {
        $recipeId = false;
    }

    if(!$recipeId || $recipes_select->rowCount() != 1){
        header("Location: index.php");
    }

    include("include/head.php");
?>

    <title>Family Cookbook - Edit</title>
    <script src="node_modules/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({selector:"textarea",   plugins: "lists",
  toolbar: "numlist bullist", branding: false, menubar: false});</script>
</head>
<body>
    <?php include("include/header.php");?>
    <main>
        <div class="container">
            <div class="nine columns">
                <?php if($recipeId): ?>
                <h3>Editing <?= $recipe["recipeName"] ?></h3>
                    <form class="edit" action="update.php" method="post">
                        <input hidden name="id" id="id" value="<?= $recipe["recipeId"] ?>">

                        <label for="recipeName">Recipe Name:</label>
                        <input type="text" name="recipeName" id="recipeName" value="<?= $recipe["recipeName"] ?>">

                        <label for="tags">Tags:</label>
                        <input type="text" name="tags" id="tags" value="<?= $recipe["tags"] ?>">

                        <label for="prepTime">Preparation Time:</label>
                        <input type="text" name="prepTime" id="prepTime" value="<?= $recipe["prepTime"] ?>">

                        <label for="cookTime">Cook Time:</label>
                        <input type="text" name="cookTime" id="cookTime" value="<?= $recipe["cookTime"] ?>">

                        <label for="mealType">Meal Type:</label>
                        <select name="mealType" id="mealType">
                            <option value="<?= $recipe["mealType"] ?>"><?= $mealTypes[$recipe["mealType"] -1]["mealTypeName"] ?></option>
                            <?php foreach($mealTypes as $mealType): if($recipe["mealType"] != $mealType["mealTypeId"]): ?>
                                <option value="<?= $mealType["mealTypeId"] ?>"><?= $mealType["mealTypeName"] ?></option>
                            <?php endif; endforeach ?>
                        </select>
                        <label for="ingredients">Ingredients: </label>
                        <textarea name="ingredients" id="ingredients" cols="30" rows="10"><?= $recipe["ingredients"] ?></textarea>

                        <label for="instructions">Directions: </label>
                        <textarea name="instructions" id="instructions" cols="30" rows="10"><?= $recipe["instructions"] ?></textarea>
                        <br>
                        <input class="button-primary" type="submit" name="update" value="Update Recipe">
                    </form>
                    <form class="delete" action="update.php" method="post" onsubmit="return confirm("Are you sure you want to delete this recipe?")">
                        <input hidden name="id" id="id" value="<?= $recipe["recipeId"] ?>">
                        <input type="submit" name="delete" value="Delete Recipe">
                    </form>
                <?php else: ?>
                    <p>That recipe doesn"t exist!</p>
                <?php endif ?>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
</body>
</html>