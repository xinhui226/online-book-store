<?php

class Category{

    //get all category
    public static function listAllCategory()
    {
        //fetchall
        return DB::connect()->select(
            'SELECT * FROM categories ORDER BY id',
            [],
            true);
    }

    //get category by id
    public static function getCategoryById($id)
    {
        return DB::connect()->select(
            'SELECT * FROM categories WHERE id=:id',
            [
                'id'=>$id
            ]
        );
    }

     //quantity of category
     public static function totalCategories()
     {
         //fetch
         return DB::connect()->select('SELECT COUNT(id) AS quantity FROM categories');
     } 


    //search
    public static function search($category)
    {
        return DB::connect()->select(
            'SELECT * FROM categories WHERE CONCAT(id,name,created_at) LIKE "%'.$category.'%"',
            [],
            true
            );
        
    }

    //add new category
    public static function addCategory($category)
    {
        return DB::connect()->insert(
            'INSERT INTO categories (name) VALUES (:category)',
            [
                'category'=>trim($category)
            ]
         );

        //   return 'Successfully add category "'.trim($category).'" !';
   
    }


    //delete category
    public static function deleteCategory($id)
    {
          return  DB::connect()->delete(
                'DELETE FROM categories WHERE id = :id',
                [
                    'id'=>$id
                ]);

            // return 'Successfully delete category!';
    }


    //update category name
    public static function updateCategory($id,$category)
    {

      return DB::connect()->update(
            'UPDATE categories SET name = :name WHERE id = :id',
            [
                'name'=>trim($category),
                'id'=>$id
            ]
        );

        // return 'Successfully update Category "'.trim($category).'" !';
    }

}