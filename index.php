<?php
include_once("./pages/lib.php");
// $item = new Item("Простоквашено",1,75, "2.5%",4,'');
// $item->Add();




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./wwwroot/css/bootstrap.css">
</head>
<body>
    <div class = "container">
        <div class="row">
            <div class="col-12">
                <?php
                    include_once("./pages/menu.php");
               ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php
                    $page = $_GET['page'];
                    switch($page) {
                        case "registration":
                            include_once("./pages/registration.php");
                            break;
                        case "admin":
                            include_once("./pages/admin.php");
                            break;
                        default:
                    }
               ?>
            </div>
        </div>
    </div>
</body>
</html>