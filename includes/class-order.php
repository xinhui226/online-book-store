<?php

class Order
{

    public static function listAllOrder($limit=null)
    {
         return  DB::connect()->select(
               'SELECT * FROM orders ORDER BY id DESC'.($limit?' LIMIT '.$limit:''),
                   [],
                   true
               );
    }

    public static function countSales()
    {
        return DB::connect()->select(
            'SELECT SUM(total_amount) AS "sales" FROM orders WHERE payment_status = "Completed"'
        );
    }

    public static function createNewOrder($userid,$total)
    {
        return DB::connect()->insert(
            'INSERT INTO orders (total_amount,transaction_id,user_id) VALUES (:total,:transaction,:user)',
            [
                'total'=>$total,
                'transaction'=>'',
                'user'=>$userid
            ]
        );
    }

    public static function updatePayment($transactionid,$status)
    {
        return DB::connect()->update(
            'UPDATE orders SET payment_status=:status WHERE transaction_id = :transactionid',
            [
                'status'=>$status,
                'transactionid'=>$transactionid
            ]
            );
    }

    public static function updateOrderStatus($orderid,$status)
    {
        return DB::connect()->update(
            'UPDATE orders SET order_status=:status WHERE id=:id',
            [
                'id'=>$orderid,
                'status'=>$status
            ]
        );
    }
    
    
    public static function getOrderByUser($id)
    {
         return  DB::connect()->select(
            'SELECT * FROM orders WHERE user_id = :id ORDER BY id DESC',
                [
                'id'=>$id
                ],
                true
            );
        
    }
}


class PivotOrderPro
{
    // get product id by order id
    public static function getProductByOrder($orderid)
    {
       $orders = DB::connect()->select(
            'SELECT * FROM orders_products WHERE order_id = :id',
            [
                'id'=>$orderid
            ],
            true
            );

        $products=[];

        foreach($orders as $order)
        {
            $products[]=
            [
                'product'=> Products::getProductById($order['product_id']),
                'quantity'=> $order['quantity']
            ];
        }

        return $products;
    }

    public static function insert($product,$orderid,$quantity)
    {
        return DB::connect()->insert(
            'INSERT INTO orders_products (product_id,order_id,quantity)
                VALUES (:product_id,:order_id,:quantity)',
            [
                'product_id'=>$product,
                'order_id'=>$orderid,
                'quantity'=>$quantity
            ]
        );
    }
}