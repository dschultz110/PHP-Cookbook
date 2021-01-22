<?php
    require("include/connect.php");
    GLOBAL $action;

    if(isset($_GET["redirect"])){
        if($_GET["redirect"] == "new"){
            $action = "login.php?redirect=new";
        }
        if($_GET["redirect"] == "mealTypes"){
            $action = "login.php?redirect=mealTypes";
        }
    }

    if(isset($_POST["login"])){
        $login_select = $db->prepare("SELECT email, password FROM users WHERE email = :email LIMIT 1");

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

        $login_select->bindValue(":email", $email);
        $login_select->execute();
        $credentials = $login_select->fetch();
        $password = password_verify($_POST["password"], $credentials["password"]);

        if($password){
            $_SESSION["user"] = $email;

            if(isset($_GET["redirect"])){
                if($_GET["redirect"] == "new"){
                    header("Location: new.php" );
                }
                if($_GET["redirect"] == "mealTypes"){
                    header("Location: editMealType.php");
                }
            } else {
                header("Location: index.php");
            }
        }

    }

    require("include/head.php");
?>

    <title>Family Cookbook - Login</title>
</head>
<body>
    <?php include("include/header.php") ?>
    <main>
        <div class="container">
            <div class="nine columns">
                <h3>Log-in: </h3>
                <form <?php if(isset($_GET["redirect"])): ?> action="<?= $action ?>" <?php else: ?> action="login.php" <?php endif ?> method="post">
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="email">

                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password">
                    <br>
                    <input class="button-primary" type="submit" name="login" value="Log In">
                </form>
                <h4>Or if you don"t have an account, <a href="register.php">register</a> for one now!</h4>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
    <?php if(isset($_POST["login"])): ?>
        <?php if(!$password): ?>
            <script>
                alert("Incorrect email/password combination.");
            </script>
        <?php endif ?>
    <?php endif ?>
</body>
</html>