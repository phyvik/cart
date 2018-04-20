<?php
require_once "DBController.php";

class ShoppingCart extends DBController
{

    function getAllProduct()
    {
        $query = "SELECT * FROM meals";
        $productResult = $this->getDBResult($query);
        return $productResult;
    }
    
     function getmeals($id)
    {
        $query = "SELECT * FROM meals where id='".$id."'";
        $productResult = $this->getDBResult($query);
        return $productResult[0];
    }
    
    
    /*
    
    CREATE TABLE  `goodmeals`.`meals_cart` (
                  `cardid` INT(12) NOT NULL,
                  `meal_id` INT(12) NOT NULL,
                  `quantity` INT(12) NOT NULL,
                  `mealorigin` VARCHAR(45) NOT NULL,
                  `price` INT(12) NOT NULL,
                  `subtotal` INT(12) NOT NULL,
                  `phone` VARCHAR(45) NOT NULL,
                  `date_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  `order_flag` INT NULL,
                  `json_data` VARCHAR(500) NULL,
                   PRIMARY KEY (`cardid`)); 
    */
    function insertmeals_to_cart($mealid, $quantity, $mealorigin, $mealsdata, $price, $subtotalprice, $phone, $jsondata ){
        
         echo $query = "INSERT INTO `goodmeals`.`meals_cart`
                        (`meal_id`, `quantity`, `mealorigin`, `mealdata`, `price`, `subtotal`, `phone`, json_data) 
                    VALUES 
                        ('".$mealid."', '".$quantity."','".$mealorigin."','".$mealsdata."','".$price."','".$subtotalprice."','".$phone."','".$jsondata."')"; 
                        
        $this->updateDB($query);               
        
    }
    
    function updatemeals_to_cart($mealid, $quantity, $subtotalprice, $phone, $jsondata ){
        
         echo $query = "update `goodmeals`.`meals_cart` set `quantity` = ? , `subtotal` = ? where meal_id='".$mealid."' and phone='".$phone."' and order_flag='0' "; 
                   
         $params = array(
            array(
                "param_type" => "i",
                "param_value" => $quantity
            ),
            array(
                "param_type" => "i",
                "param_value" => $subtotalprice
            )
        );
        $this->updateDB($query, $params);               
        
    }
    
    function get_mealscart($meals_id, $customer_phn)
    {
        
        $query = "SELECT id FROM `goodmeals`.`meals_cart` WHERE meal_id = ? AND phone = ? and order_flag = 0 ";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $meals_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $customer_phn
            )
        );
        
        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
        
    }
    
    function get_mealscartlist($customer_phn)
    {
        $query = "SELECT * FROM  meals_cart WHERE phone = ? and order_flag= 0 ";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $customer_phn
            ) 
        ); 
        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    } 
    

    function getProductByCode($product_code)
    {
        $query = "SELECT * FROM meals WHERE id=?";
        
        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $product_code
            )
        );
        $productResult = $this->getDBResult($query, $params);
        return $productResult;
    }

    function getCartItemByProduct($meals_id, $customer_phn)
    {
        $query = "SELECT * FROM tbl_cart WHERE meals_id = ? AND customer_phn = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $meals_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $customer_phn
            )
        );
        
        $cartResult = $this->getDBResult($query, $params);
        return $cartResult;
    }

    function addToCart($product_id, $quantity, $customer_phn)
    {
        $query = "INSERT INTO tbl_cart (meals_id, quantity,customer_phn) VALUES (?, ?, ?)";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $product_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $quantity
            ),
            array(
                "param_type" => "i",
                "param_value" => $customer_phn
            )
        );
        
        $this->updateDB($query, $params);
    }

    function updateCartQuantity($quantity, $cart_id)
    {
        $query = "UPDATE tbl_cart SET  quantity = ? WHERE id= ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $quantity
            ),
            array(
                "param_type" => "i",
                "param_value" => $cart_id
            )
        );
        
        $this->updateDB($query, $params);
    }

    function deleteCartItem($cart_id)
    {
        $query = "DELETE FROM tbl_cart WHERE id = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $cart_id
            )
        );
        
        $this->updateDB($query, $params);
    }

    function emptyCart($customer_phn)
    {
        $query = "DELETE FROM tbl_cart WHERE customer_phn = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $customer_phn
            )
        );
        
        $this->updateDB($query, $params);
    }
}
