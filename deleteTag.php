<?php
    require("include/connect.php");

    if(!isset($_SESSION["admin"])){
        header("location: admin.php");
    }

    $tags_select = $db->prepare("SELECT * FROM tags ORDER BY tagName");
    $tags_select->execute();
    $tags=$tags_select->fetchAll();

    if(isset($_POST["delete"])){
        $tagId = filter_input(INPUT_POST, "tagId", FILTER_SANITIZE_NUMBER_INT);
        $tag_delete = $db->prepare("DELETE FROM tags WHERE tagId = :tagId LIMIT 1");
        $tag_delete->bindValue(":tagId", $tagId, PDO::PARAM_INT);
        $tag_delete->execute();
        header("Location: deletetag.php");
    }

    require("include/head.php");
?>
    <title>Family Cookbook - Delete Tag</title>
</head>
<body>
    <div class="container">
        <div class="twelve columns">
            <header>
                <h1>Family Cookbook</h1>
                <h2>Delete Tag</h2>
            </header>
        </div>
    </div>
    <main>
        <div class="container">
            <div class="twelve columns">
                <?php foreach($tags as $tag): ?>
                    <form onsubmit="return confirm("Are you sure you want to delete this tag? This will not delete any recipes associated with that tag.")" action="deleteTag.php" method="post">
                        <input hidden name="tagId" value="<?= $tag["tagId"] ?>">
                        <input type="submit" value="<?= $tag["tagName"] ?>" name="delete" class="nostyle">
                    </form>
                <?php endforeach ?>
                <h4>What would you like to do?</h4>
                <ul>
                    <li><a href="deleteUser.php">Delete a user...</a></li>
                    <li><a href="deleteTag.php">Delete a tag...</a></li>
                    <li><a href="index.php?logout=1">Return to the site...</a></li>
                </ul>
            </div>
        </div>
    </main>
</body>
</html>