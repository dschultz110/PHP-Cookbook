<?php
    require("include/connect.php");
    $statusMsg = "";
    if(isset($_POST["upload"]) && !empty($_FILES["image"]["name"])){
        $targetDir = "uploads/";
        $fileName = basename($_FILES["image"]["name"]) ;
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        $allowTypes = array("jpg","png","jpeg","gif");
        if(in_array($fileType, $allowTypes)){
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
                $image_insert = $db->prepare("INSERT INTO images (imageName) VALUES (:imageName)");
                $image_insert->bindValue(":imageName", $fileName);
                //$image_insert->bindValue(":recipeId", $recipeId);
                $image_insert->execute();
            } else {
                $statusMsg = "File upload failed, please try again.";
            }
        } else {
            $statusMsg = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
        }
    } else {
        $statusMsg = "Please select an image to upload.";
    }
    echo $statusMsg;
    require("include/head.php");

    $image_select = $db->prepare("SELECT * FROM images");
    $image_select->execute();
    $image = $image_select->fetch();
?>

    <title>Edit Recipe - Add Image</title>
</head>
<body>
    <?php include("include/header.php"); ?>
    <main>
        <div class="container">
            <div class="nine columns">
                <h3>Edit</h3>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <label for="image">Image: </label>
                    <input type="file" name="image" id="image">
                    <input type="submit" value="Upload Image" name="upload" class="button-primary">
                </form>
                <?php if($image_select->rowCount() > 0): ?>
                    <img src="uploads/<?= $image["imageName"] ?>" alt="<?= $image["imageName"] ?>">
                <?php endif ?>
            </div>
        </div>
    </main>
</body>
</html>
