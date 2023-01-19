<?php

class Cart{

    public static function getProductsInCart()
    {
        $cart = [];

        if(isset($_SESSION['cart']))
        {
            foreach($_SESSION['cart'] as $productid=>$quantity)
            {
                $product = Products::getProductById($productid);

                $cart[]=
                [
                    'id'=>$productid,
                    'name'=>$product['name'],
                    'price'=>$product['price'],
                    'total'=>$product['price']*$quantity,
                    'image'=>$product['image'],
                    'quantity'=>$quantity
                ];
            }
        }// end- if isset $_SESSION['cart']

        return $cart;
    }


    public static function totalAmountOfCart()
    {
        $total = 0;

        foreach(self::getProductsInCart() as $product)
        {
            $total+=$product['total'];
        }

        return $total;
    }


    public static function addToCart($productid)
    {
        if(isset($_SESSION['cart']))
        {
            $cart = $_SESSION['cart'];
        }else{
            $cart = [];
        }

        if(isset($cart[$productid]))
        {
            $cart[$productid]+=1;
        }else{
            $cart[$productid] = 1;
        }

        $_SESSION['cart'] = $cart;
        // var_dump($_SESSION['cart']);
    }

    public static function updateCart($action,$productid)
    {
         if(isset($_SESSION['cart'][$productid]))
        {
            switch($action){

                case 'increase' :
                    ++$_SESSION['cart'][$productid];
                    break;

                case 'decrease' :
                    if(($_SESSION['cart'][$productid])==1)
                    { 
                        unset($_SESSION['cart'][$productid]);
                    }else{
                       --$_SESSION['cart'][$productid];
                    }
                    break;

                case 'delete' :
                    unset($_SESSION['cart'][$productid]);
                    break;

            }
       
        }
    }
}