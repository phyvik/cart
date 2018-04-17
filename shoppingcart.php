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

    function getMemberCartItem($customer_phn)
    {
        $query = "SELECT 
					meals.*, 
					tbl_cart.id AS cart_id,
					tbl_cart.quantity 
				FROM meals, tbl_cart 
				WHERE 
					`tbl_cart`.`meals_id` = meals.id 
				AND tbl_cart.customer_phn = ?";
        
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
