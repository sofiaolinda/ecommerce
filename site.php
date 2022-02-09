<?php

use \Hcode\Page;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Product;

$app->get('/', function () {

    $products = Product::listAll();

    $page = new Page();
    $page->setTpl("index", [
        "products"=>Product::checkList($products)
    ]);

});

$app->get("/categories/:idcategory", function ($idcategory) {

    User::verifyLogin();

    $category = new Category();

    $category->get((int)$idcategory);

    $page = new Page();

    $page->setTpl("category", [
        "category"=>$category->getValues(),
        "product"=>Product::checkList($category->getProducts())
    ]);
});

?>