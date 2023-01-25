<?php

class Authors{

    //get all author
    public static function listAllAuthor()
    {
        //fetchall
       return DB::connect()->select(
            'SELECT * FROM authors ORDER BY id',
            [],
            true);
    }

    //get author by id
    public static function getAuthorById($id)
    {
        return DB::connect()->select(
            'SELECT * FROM authors WHERE id=:id',
            [
                'id'=>$id
            ]
        );
    }

    //quantity of author
    public static function totalAuthors()
    {
      //fetch
      return DB::connect()->select('SELECT COUNT(id) AS quantity FROM authors');
    }


    //search
    public static function search($author)
    {
        return DB::connect()->select(
            'SELECT * FROM authors WHERE CONCAT(id,name,created_at) LIKE "%'.$author.'%"',
            [],
            true
            );
        
    }


    //add new author
    public static function addAuthor($name)
    {

       return DB::connect()->insert(
                        'INSERT INTO authors (name) VALUES (:name)',
                        [
                        'name' =>trim($name)
                        ]
                    );

        //   return 'Successfully add Author "'.trim($name).'" !';
    }


    //delete author
    public static function deleteAuthor($id)
    {
        return DB::connect()->delete(
                'DELETE FROM authors WHERE id = :id',
                [
                    'id'=>$id
                ]
                );
            // return 'Successfully delete author !' ;
    }


    //update author name
    public static function updateAuthor($id,$name)
    {

       return DB::connect()->update(
            ('UPDATE authors SET name = :name WHERE id = :id'),
            [
                'name'=>trim($name),
                'id'=>$id
            ]
        );
        
        // return 'Successfully update Author "'.trim($name).'" !' ;
    }

}