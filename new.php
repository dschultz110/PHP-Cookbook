<?php
    require("include/connect.php");

    if(!isset($_SESSION["user"])){
        header("location: login.php?redirect=new");
    }

    $mealTypes_select = $db->prepare("SELECT * FROM mealTypes");
    $mealTypes_select->execute();
    $mealTypes = $mealTypes_select->fetchAll();

    include("include/head.php");
?>

    <title>Family Cookbook - Create Recipe</title>
    <script src="node_modules/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({selector:"textarea",   plugins: "lists",
  toolbar: "numlist bullist", branding: false, menubar: false});</script>

</head>
<body>
    <?php include("include/header.php") ?>

    <main>
        <div class="container">
            <div class="nine columns">
                <form action="insert.php" method="post">
                    <h3>New Recipe: </h3>
                        <label for="recipeName">Recipe Name: </label>
                        <input type="text" name="recipeName" id="recipeName">

                        <label for="prepTime">Preparation Time: </label>
                        <input type="text" name="prepTime" id="prepTime">

                        <label for="cookTime">Cook Time: </label>
                        <input type="text" name="cookTime" id="cookTime">

                        <label for="mealType">Meal Type: </label>
                        <select name="mealType" id="mealType">
                            <option value="-1">Please select a meal type...</option>
                            <?php foreach($mealTypes as $mealType): ?>
                                <option value="<?= $mealType["mealTypeId"] ?>"><?= $mealType["mealTypeName"] ?></option>
                            <?php endforeach ?>
                        </select>

                        <label for="ingredients">Ingredients: </label>
                        <textarea name="ingredients" id="ingredients" cols="30" rows="10"></textarea>

                        <label for="instructions">Directions: </label>
                        <textarea name="instructions" id="instructions" cols="30" rows="10"></textarea>

                        <label for="tags">Tags: (comma separated)</label>
                        <input type="text" name="tags" id="tags">
                        <br>
                        <input class="button-primary" type="submit" name="create" value="Create Recipe">
                    </form>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
</body>
</html>