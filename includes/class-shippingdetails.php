<?php

class Shipment{

    //get shipping details by order id
    public static function getShippingDetails($orderid)
    {
        return DB::connect()->select(
            'SELECT * FROM shipping_details WHERE order_id =:orderid',
            [
                'orderid'=>$orderid
            ]
        );
    }

    //insert user address details
    public static function insert($name,$phone,$address,$postcode,$state,$city,$orderid)
    {

       return DB::connect()->insert(
            'INSERT INTO shipping_details (name,phone,address,postcode,state,city,order_id) VALUES (:name,:phone,:address,:postcode,:state,:city,:orderid)',
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

    }
}