<?php

class PivotCatPro{

    // display product
    public static function getProductByCategory($categoryid)
    {

        $results = DB::connect()->select(
            'SELECT * FROM category_product WHERE category_id = :c_id',
            [
                'c_id'=>$categoryid
            ],
            true
            );

        $products=[];

        foreach($results as $result)
        {
            $products[] = Products::getProductById($result['product_id']);
        }

        return $products;
    }

    //display in stock product
    public static function inStockProductByCategory($categoryid)
    {
        $results = DB::connect()->select(
            'SELECT * FROM category_product WHERE category_id = :c_id',
            [
                'c_id'=>$categoryid
            ],
            true
            );

        $products=[];

        foreach(Products::listInStockProducts() as $instockprod)
        {
            foreach($results as $result)
            {
                if($instockprod['id']==$result['product_id']) $products[] = Products::getProductById($result['product_id']);
            } 
        }

        return $products;
    }
    
    // display category
    public static function getCategoryByProduct($productid)
    {
        $results = DB::connect()->select(
            'SELECT * FROM category_product WHERE product_id = :id',
            [
                'id'=>$productid
            ],
            true
            );
    
        $category=[];
    
        foreach($results as $result)
        {
            $category[] = Category::getCategoryById($result['category_id']);
        }
    
        return $category;
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
        return DB::connect()->delete(
            'DELETE FROM category_product WHERE product_id=:productid AND category_id=:categoryid',
            [
                'productid'=>$product,
                'categoryid'=>$category
            ]
        );
    }
}