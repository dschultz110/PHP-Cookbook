<?php
    require("include/connect.php");
    GLOBAL $action;

    if(isset($_POST["login"])){
        $login_select = $db->prepare("SELECT * FROM users WHERE email = :email AND permissionLevel > 1 LIMIT 1");

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

        $login_select->bindValue(":email", $email);
        $login_select->execute();
        $credentials = $login_select->fetch();
        $password = password_verify($_POST["password"], $credentials["password"]);

        if($password){
            $_SESSION["admin"] = $email;

            if(isset($_GET["redirect"])){
                if($_GET["redirect"] == "new"){
                    header("Location: new.php" );
                }
                if($_GET["redirect"] == "mealTypes"){
                    header("Location: editMealType.php");
                }
            }
        }
    }

    require("include/head.php");
?>

    <title>Family Cookbook - Admin</title>
</head>
<body>
    <div class="container">
        <div class="twelve columns">
            <header>
                <h1>Family Cookbook</h1>
                <h2>Admin Page</h2>
                <hr>
            </header>
        </div>
    </div>
    <main>
        <div class="container">
            <div class="twelve columns">
                <?php if(!isset($_SESSION["admin"])): ?>
                    <h3>Admin Log-in: </h3>
                    <form action="admin.php" method="post">
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="email">

                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password">
                        <br>
                        <input class="button-primary" type="submit" name="login" value="Log In">
                    </form>
                <?php endif ?>
                <?php if(isset($_SESSION["admin"])): ?>
                    <h3>Welcome <?= $credentials["firstName"] . " " . $credentials["lastName"] ?></h3>
                    <h4>What would you like to do?</h4>
                    <ul>
                        <li><a href="deleteUser.php">Delete a user...</a></li>
                        <li><a href="deleteTag.php">Delete a tag...</a></li>
                        <li><a href="index.php?logout=1">Return to the site...</a></li>
                    </ul>
                <?php endif ?>
            </div>
        </div>
    </main>
    <?php if(isset($_POST["login"])): ?>
        <?php if($login_select->rowCount() < 1): ?>
            <script>
                alert("You do not have the correct permissions.");
            </script>
        <?php elseif(!$password): ?>
            <script>
                alert("Incorrect email/password combination.");
            </script>
        <?php endif ?>
    <?php endif ?>
</body>
</html>