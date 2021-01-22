<?php
    require("include/authenticate.php");
    GLOBAL $valid;

    if(isset($_POST["update"])){
        $id = filter_input(INPUT_POST, "mealType", FILTER_SANITIZE_NUMBER_INT);
        $mealTypeName = filter_input(INPUT_POST, "mealTypeName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $mealType_update = $db->prepare("UPDATE mealTypes SET mealTypeName = :mealTypeName WHERE mealTypeId = :id");
        $mealType_update->bindValue(":mealTypeName", strtolower($mealTypeName));
        $mealType_update->bindValue(":id", $id);

        if($id != -1 && strlen($mealTypeName) > 0 && strlen($mealTypeName) <= 30){
            $mealType_update->execute();
            $valid = true;
            header("Location: index.php");
            exit;
        }
    }
    else{
        $valid = false;
    }
    include("include/head.php");
?>

    <title>Family Cookbook - Edit Meal Type</title>
</head>
<body>
    <?php include("include/header.php") ?>
    <main>
        <div class="container">
            <div class="nine columns">
            <?php if(isset($_POST) && !$valid): ?>
                <h3>You can <a href="editMealType.php">edit meal types here...</a></h3>
            <?php else: ?>
                <h3>Please enter a valid meal type.</h3>
            <?php endif ?>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
</body>
</html>