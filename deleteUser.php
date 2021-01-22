<?php
    require("include/connect.php");

    if(!isset($_SESSION["admin"])){
        header("location: admin.php");
    }

    $users_select = $db->prepare("SELECT * FROM users ORDER BY firstName, lastName");
    $users_select->execute();
    $users=$users_select->fetchAll();

    if(isset($_POST["delete"])){
        $userId = filter_input(INPUT_POST, "userId", FILTER_SANITIZE_NUMBER_INT);
        $user_delete = $db->prepare("DELETE FROM users WHERE userId = :userId LIMIT 1");
        $user_delete->bindValue(":userId", $userId, PDO::PARAM_INT);
        $user_delete->execute();
        header("Location: deleteUser.php");
    }

    require("include/head.php");
?>
    <title>Family Cookbook - Delete User</title>
</head>
<body>
    <div class="container">
        <div class="twelve columns">
            <header>
                <h1>Family Cookbook</h1>
                <h2>Delete User</h2>
            </header>
        </div>
    </div>
    <main>
        <div class="container">
            <div class="twelve columns">
                <?php foreach($users as $user): ?>
                    <form onsubmit="return confirm("Are you sure you want to delete this user? This will not delete any recipes they have created.")" action="deleteUser.php" method="post">
                        <input hidden name="userId" value="<?= $user["userId"] ?>">
                        <input type="submit" value="<?= $user["firstName"] . " " . $user["lastName"] ?>" name="delete" class="nostyle">
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