<?php
    $sidebar_recipes_select = $db->prepare("SELECT * FROM recipes ORDER BY recipeId DESC");
    $sidebar_recipes_select->execute();
    $sidebar_recipes = $sidebar_recipes_select->fetchAll();

    $sidebar_tags_select = $db->prepare("SELECT * FROM tags ORDER BY tagName");
    $sidebar_tags_select->execute();
    $sidebar_tags = $sidebar_tags_select->fetchAll();

    $sidebar_mealTypes_select = $db->prepare("SELECT * FROM mealTypes");
    $sidebar_mealTypes_select->execute();
    $sidebar_mealTypes = $sidebar_mealTypes_select->fetchAll();
?>

<aside>
    <div class="row">
        <div class="twelve columns">
            <form action="search.php" method="post">
                <ul class="navbar-list search">
                    <li class="navbar-item">
                        <input placeholder="Search recipes..." type="text" name="searchTerm"
                        <?php if(isset($_POST["search"])): ?> value="<?= $_POST["searchTerm"] ?>" <?php endif ?>>
                    </li>
                    <li class="navbar-item">
                    <select name="navbarMealType" id="navbarMealType">
                        <?php if(isset($_POST["search"]) && $_POST["navbarMealType"] != -1): ?>
                            <option value="<?= $_POST["navbarMealType"] ?>"><?= $header_mealTypes[$_POST["navbarMealType"] - 1]["mealTypeName"]?></option>
                        <?php endif ?>
                        <option value="-1">All meal types</option>
                        <?php foreach($header_mealTypes as $header_mealType): if(isset($_POST["search"])): ?>
                            <?php if($header_mealType["mealTypeId"] != $_POST["navbarMealType"]): ?>
                                <option value="<?= $header_mealType["mealTypeId"] ?>"><?= $header_mealType["mealTypeName"] ?></option>
                            <?php endif ?>
                        <?php else: ?>
                            <option value="<?= $header_mealType["mealTypeId"] ?>"><?= $header_mealType["mealTypeName"] ?></option>
                        <?php endif ?>
                        <?php endforeach ?>
                    </select>
                    </li>
                    <li class="navbar-item">
                        <input name="search" type="submit" class="button-primary" value="Search">
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns">
            <h4>Recipes: </h4>
            <ul>
                <?php foreach($sidebar_recipes as $sidebar_recipe): ?>
                    <li class="sidebar-recipes capitalize">
                        <a href="recipe.php?id=<?= $sidebar_recipe["recipeId"] ?>"><?= $sidebar_recipe["recipeName"] ?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns">
            <h4>Tags: </h4>
            <ul>
                <?php foreach($sidebar_tags as $sidebar_tag): ?>
                    <?php $sidebar_get_tag = str_replace(" ", "-", $sidebar_tag["tagName"]) ?>
                    <li class="sidebar-tags">
                        <a href="tag.php?tag=<?= $sidebar_get_tag ?>"><?= $sidebar_tag["tagName"] ?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns">
            <h4>Meal Types:</h4>
            <ul>
                <?php foreach($sidebar_mealTypes as $sidebar_mealType): ?>
                    <li class="sidebar-mealTypes capitalize">
                        <a href="mealType.php?id=<?= $sidebar_mealType["mealTypeId"] ?>"><?= $sidebar_mealType["mealTypeName"] ?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns">
            <a href="editMealType.php">Edit Meal Types</a>
        </div>
    </div>
</aside>