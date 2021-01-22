<?php
    require("include/connect.php");

    if(!isset($_SESSION["user"])){
        header("location: login.php?redirect=mealTypes");
    }

    $mealType_select = $db->prepare("SELECT * FROM mealTypes");
    $mealType_select->execute();
    $mealTypes = $mealType_select->fetchAll();

    include("include/head.php");
?>

    <title>Family Cookbook - Edit Meal Types</title>
</head>
<body>
    <?php include("include/header.php") ?>
    <main>
        <div class="container">
            <div class="nine columns">
                <form action="updateMealType.php" method="post">
                    <select name="mealType" id="mealType">
                        <option value="-1">Please select a meal type to edit...</option>
                        <?php foreach($mealTypes as $mealType): ?>
                            <option value="<?= $mealType["mealTypeId"] ?>"><?= $mealType["mealTypeName"] ?></option>
                        <?php endforeach ?>
                    </select>
                    <label for="mealTypeName">New Meal Type Name: </label>
                    <input type="text" name="mealTypeName" id="mealTypeName">
                    <br>
                    <input class="button-primary" type="submit" name="update" value="Update Meal Type">
                </form>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
</body>