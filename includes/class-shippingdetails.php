<?php

class Shipment{

    //get shipping details by order id
    public static function getShippingDetailsById($orderid)
    {
        return DB::connect()->select(
            'SELECT * FROM shipping_details WHERE order_id =:orderid',
            [
                'orderid'=>$orderid
            ]
        );
    }

    //send message
    public static function insert($name,$phone,$address,$postcode,$state,$city,$orderid)
    {

       return DB::connect()->insert(
            'INSERT INTO messages (name,phone,address,postcode,$state,city,order_id) VALUES (:name,:phone,:address,:postcode,:state,:city,:orderid)',
            [
                'name'=>$name,
                'phone'=>$phone,
                'address'=>$address,
                'postcode'=>$postcode,
                'state'=>$state,
                'city'=>$city,
                'orderid'=>$orderid
            ]
        );

        // return 'We will get right back to you !';
    }
}