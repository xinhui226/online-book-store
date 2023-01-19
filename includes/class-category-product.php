<?php

class PivotCatPro{

    // display product
    public static function getProductByCategory($category)
    {
        return DB::connect()->select(
            'SELECT * FROM category_product WHERE category_id = :id',
            [
                'id'=>$category
            ],
            true
            );
    }

    // display product
    public static function getCategoryByProduct($product)
    {
        return DB::connect()->select(
            'SELECT * FROM category_product WHERE product_id = :id',
            [
                'id'=>$product
            ],
            true
            );
    }

    //insert data into pivot table
    public static function insert($product,$category)
    {
        return DB::connect()->insert(
            'INSERT INTO category_product (product_id,category_id)
                VALUES (:product_id,:category_id)',
            [
                'product_id'=>$product,
                'category_id'=>$category
            ]
        );
    }

    //delete data
    public static function delete($product,$category)
    {
        return DB::connect()->insert(
            'DELETE FROM category_product WHERE product_id=:productid AND category_id=:categoryid',
            [
                'productid'=>$product,
                'categoryid'=>$category
            ]
        );
    }
}