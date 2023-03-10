<?php

class Products{

    // get all product
    public static function listAllProducts()
    {
        //fetchall
        return DB::connect()->select(
            'SELECT p.id,p.name,p.image,p.price,p.description,p.created_at,p.trending,p.available,a.id AS authorid,a.name AS authorname FROM products p JOIN authors a ON p.author_id = a.id ORDER BY id DESC',
            [],
            true);
    }

    // get in stock product
    public static function listInStockProducts()
    {
        //fetchall
        return DB::connect()->select(
            'SELECT p.id,p.name,p.image,p.price,p.description,p.created_at,p.trending,p.available,a.id AS authorid,a.name AS authorname FROM products p JOIN authors a ON p.author_id = a.id HAVING available=1 ORDER BY id DESC',
            [],
            true);
    }

    //quantity of product
    public static function totalProducts()
    {
       //fetch
        return DB::connect()->select('SELECT COUNT(id) AS quantity FROM products');
    } 

    //get product by id
    public static function getProductById($id)
    {
        return DB::connect()->select(
            'SELECT p.id,p.name,p.image,p.price,p.description,p.created_at,p.trending,p.available,a.id AS authorid,a.name AS authorname FROM products p JOIN authors a ON p.author_id = a.id HAVING id=:id',
            [
                'id'=>$id
            ]
        );
    }

    //get product by author
    public static function getProductByAuthor($author)
    {
        return DB::connect()->select(
            'SELECT p.id,p.name,p.image,p.price,p.description,p.created_at,p.trending,p.available,a.id AS authorid,a.name AS authorname FROM products p JOIN authors a ON p.author_id = a.id HAVING authorid=:id',
            [
                'id'=>$author
            ],
            true
        );
    }

    //search
    public static function search($product)
    {
        return DB::connect()->select(
            'SELECT p.id,p.name,p.image,p.price,p.description,p.created_at,p.trending,p.available,a.id AS authorid,a.name AS authorname FROM products p JOIN authors a ON p.author_id = a.id WHERE p.name LIKE "%'.$product.'%"',
            [],
            true
            );
        
    }

    //user page search
    public static function userSearch($product)
    {
        return DB::connect()->select(
            'SELECT p.id,p.name,p.image,p.price,p.description,p.created_at,p.trending,p.available,a.id AS authorid,a.name AS authorname FROM products p JOIN authors a ON p.author_id = a.id WHERE p.available=1 AND p.name LIKE "%'.$product.'%"',
            [],
            true
            );
        
    }

    //trending productl
    public static function trendingProducts()
    {
        return DB::connect()->select(
            'SELECT p.id,p.name,p.image,p.price,p.description,p.created_at,p.trending,p.available,a.id AS authorid,a.name AS authorname FROM products p JOIN authors a ON p.author_id = a.id HAVING trending=1 AND available=1 ORDER BY name',
            [],
            true);
    }

    // delete product
    public static function deleteProduct($id)
    {
       return DB::connect()->delete(
            'DELETE FROM products WHERE id = :id',
            [
                'id'=>$id
            ]
        );
        // return 'Successfully delete !';
    }

    //add product
    public static function addProduct($name,$price,$author,$description,$image,$trending=null)
    {
        $params =[
            'name'=>$name,
                'image'=>$image,
                'price'=>$price,
                'description'=>$description,
                'author'=>$author
        ];

        if($trending)
        {
            $params['trending']=1;
        }

      return DB::connect()->insert(
            'INSERT INTO products (name,image,price,description,author_id'.($trending?',trending':'').') 
                           VALUES (:name,:image,:price,:description,:author'.($trending?',:trending':'').')',
            $params
            );
    }

    //update product
    public static function updateProduct($id,$name,$price,$author,$description,$image=null,$trending,$available)
    {
        $params = [
            'id'=>$id,
            'name'=>$name,
            'price'=>$price,
            'author'=>$author,
            'description'=>$description,
            'trending'=>$trending,
            'available'=>$available
        ];

        if($image)
        {
            $params['image']=$image;
        }

       return DB::connect()->update(
            'UPDATE products SET name=:name,price=:price,author_id=:author,'.($image?'image=:image,':'').'description=:description,trending=:trending,available=:available WHERE id=:id',
            $params
        );

    }

    //upload product image to folder 'upload'
    public static function imageUpload($filename)
    {
        $file = rand().basename($filename["name"]);

        move_uploaded_file($filename["tmp_name"],
        "assets/uploads/" . $file
        );

        return $file;
    }

}