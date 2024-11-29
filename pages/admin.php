
<?php

include_once("./pages/lib.php");

if(isset($_POST['buttonCategory'])) {
    $name = $_POST['nameCategory'];
    $category = new Categories($name);
    if($category->Add()) {
        echo "Категория добавлена";
    } else {
        echo "Ошибка добавления категории";
    }
}


if(isset($_POST['buttonAddProduct'])) {
    if(empty($_POST['nameProduct']) || empty($_POST['priceProduct']) || empty($_POST['informationProduct']) || empty($_POST['ratingProduct']) || empty($_POST['categoryId']) || empty($_FILES['productImage']['name'])) {
        echo "Некорректные данные";
    } else {
        $pathTemp = $_FILES['productImage']['tmp_name'];
        if(is_uploaded_file($pathTemp)) {
            $path = "./wwwroot/images/" . $_FILES['productImage']['name'];
            move_uploaded_file($pathTemp, $path);

            $nameProduct = $_POST['nameProduct'];
            $priceProduct = $_POST['priceProduct'];
            $informationProduct = $_POST['informationProduct'];
            $ratingProduct = $_POST['ratingProduct'];
            $categoryId = $_POST['categoryId'];

            $product = new Item($nameProduct, $categoryId, $priceProduct, $informationProduct, $ratingProduct, $path);
            if($product->Add()) {
                echo "Товар добавлен";
            } else {
                echo "Ошибка добавления товара";
            }
        } else {
            echo "Ошибка загрузки изображения";
        }
    }
}

?>
<h3>Добавить категорию</h3>

<form class="row g-6" 
      method="post" 
      action="index.php?page=category"> 
  <div class="col-auto">
    <label class="visually-hidden">Name category:</label>
    <input type="text" id="nameCategory" class="form-control" name="nameCategory" placeholder="Input Category">
  </div>
  <div class="col-auto">
    <input type="submit" class="btn btn-primary mb-3" name="buttonCategory" value="Add Category">
  </div>
</form>



<h3>Добавить товар</h3>

<form class="row g-3" method="post" action="index.php?page=admin" enctype="multipart/form-data">
    <div class="col-auto">
        <label class="visually-hidden">Name:</label>
        <input type="text" id="nameProduct" class="form-control" name="nameProduct" placeholder="Input name">
    </div>

    <div class="col-auto">
        <label class="visually-hidden">Price:</label>
        <input type="number" id="priceProduct" class="form-control" name="priceProduct" placeholder="Input price">
    </div>

    <div class="col-auto">
        <label class="visually-hidden">Information:</label>
        <textarea type="text" id="informationProduct" class="form-control" name="informationProduct" placeholder="Input information"></textarea>
    </div>

    <div class="col-auto">
        <label class="visually-hidden">Rating:</label>
        <input type="number" id="ratingProduct" class="form-control" name="ratingProduct" placeholder="Input rating" min="0" max="5">
    </div>

    <div class="col-auto">
        <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
        <input type="file" class="form-control" name="productImage">
    </div>

    <div class="col-auto">
        <label class="visually">Category:</label>
        <select name="categoryId">
            <?php
               $table = Categories::Show();
               foreach ($table as $item) {
                  $id = $item->id;
                  $name = $item->name;
                  echo "<option value='$id'>$name</option>";
               }
            ?>
        </select>
        <input type="submit" class="btn btn-primary mb-3" name="buttonAddProduct" value="Add product">
    </div>
</form>