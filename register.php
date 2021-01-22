<?php
    require("include/connect.php");

    $errors = array();

    if(isset($_POST["submit"])){
        $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = $_POST["password"];
        $passwordVerify = $_POST["passwordVerify"];

        // checking that fields are filled
        if(strlen(trim($firstName)) < 1 || strlen(trim($firstName)) > 50){
            array_push($errors, "First name is required.");
        }
        if(strlen(trim($lastName)) < 1 || strlen(trim($lastName)) > 50){
            array_push($errors, "Last name is required.");
        }
        if(strlen($email) < 1 || strlen(trim($email)) > 80){
            array_push($errors, "Email is required.");
        }
        if(strlen(trim($password)) < 1){
            array_push($errors, "Password is required.");
        }
        if(trim($password) != trim($passwordVerify)){
            array_push($errors, "Passwords do not match");
        }

        // if there is no errors, execute the registration
        if(count($errors) == 0){
            $user_select = $db->prepare("SELECT email FROM users WHERE email = :email");
            $user_select->bindValue(":email", $email);
            $user_select->execute();
            // if the email doesn"t already exist, create the account
            if($user_select->rowcount() > 0){
                array_push($errors, "That email is already registered.");
            } else {
                $user_insert = $db->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)");
                $user_insert->bindValue(":firstName", $firstName);
                $user_insert->bindValue(":lastName", $lastName);
                $user_insert->bindValue(":email", $email);
                $user_insert->bindValue(":password", password_hash($password,PASSWORD_DEFAULT));

                $user_insert->execute();
                $_SESSION["user"] = $email;
                header("location: index.php");
            }
        }
    }

    require("include/head.php");
?>

    <title>Family Cookbook - Register</title>
</head>
<body>
    <?php include("include/header.php") ?>
    <main>
        <div class="container">
            <div class="nine columns">
                <h3>New User: </h3>
                <?php if(isset($_POST["submit"]) && count($errors) > 0): ?>
                    <ul>
                        <?php foreach($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
                <form class="register" action="register.php" method="post">
                    <div class="row">
                        <div class="one-half column">
                            <label for="firstName">First Name: </label>
                            <input type="text" name="firstName" id="firstName" <?php if(isset($_POST["firstName"])): ?> value="<?= $_POST["firstName"] ?>" <?php endif ?>>
                        </div>
                        <div class="one-half column">
                            <label for="lastName">Last Name: </label>
                            <input type="text" name="lastName" id="lastName" <?php if(isset($_POST["lastName"])): ?> value="<?= $_POST["lastName"] ?>" <?php endif ?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="twelve columns">
                            <label for="email">Email: </label>
                            <input type="email" name="email" id="email" <?php if(isset($_POST["email"])): ?> value="<?= $_POST["email"] ?>" <?php endif ?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="one-half column">
                            <label for="password">Password: </label>
                            <input type="password" name="password" id="password">
                        </div>
                        <div class="one-half column">
                            <label for="passwordVerify">Repeat password: </label>
                            <input type="password" name="passwordVerify" id="passwordVerify">
                        </div>
                    </div>
                    <input name="submit" type="submit" value="Register" class="button-primary">
                </form>
            </div>
            <div class="three columns">
                <?php include("include/side.php") ?>
            </div>
        </div>
    </main>
</body>
</html>