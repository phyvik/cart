<?php
	require_once "ShoppingCart.php";
	$shoppingCart = new ShoppingCart();
?>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script>
	function increment_quantity(idval) {
		 preval = document.getElementById(idval).value; 
		 var nxtval = parseInt(preval) + 1; 
		 document.getElementById(idval).value = nxtval;
	}

	function decrement_quantity(idval) {
		 nxtval = document.getElementById(idval).value;
		 if(nxtval != 0){
			var preval = parseInt(nxtval) - 1;
			document.getElementById(idval).value = preval;
		 }
	}
	
	function addcart(k) { 
		var quantity = document.getElementById("cartval_"+k).value;
		var txt = document.getElementById("mealid_"+k).value;
		$.post("cartaction.php", {action:'add',value:txt, quantity:quantity}, function(result){
			 alert(result);
		});
		return false;
	}
	
</script>
<div class="container">
<div class="row">     
    <?php
    $query = "SELECT * FROM meals";
    $product_array = $shoppingCart->getAllProduct($query);
    if (! empty($product_array)) {
		$i=0;
        foreach ($product_array as $key => $value) 
		{
    ?>
 	  
	<div class="col-md-3 g-py-20" style='text-align:center;'>
		<div class="u-shadow-v1-5 g-mx-10 g-my-10">
			<img class="img-fluid w-100" src="<?php echo $product_array[$key]["imageurl"]; ?>" alt="<?php echo $product_array[$key]["mealorigin"];?>">
		</div>
			<h4 class="text-uppercase g-line-height-1_2 g-font-size-14" style="text-align: center;"><?php echo $product_array[$key]["mealorigin"].' : &#x20B9; '.$product_array[$key]["price"]	 ;?>  
			</h4> 
		<form method="post" name='mealscart'>
			<div class='btn btn-success' onclick="decrement_quantity('cartval_<?php echo $i; ?>' )" > - </div>
			
				<input type="text" name="quantity" value="1" size="2" class="input-cart-quantity" id='cartval_<?php echo $i; ?>' />
				
				<div class='btn btn-success' onclick="increment_quantity('cartval_<?php echo $i; ?>')"> + </div>
				 
				<input type='hidden' id='mealid_<?php echo $i?>' name='mealid_<?php echo $i?>' value='<?php echo $product_array[$key]["id"]; ?>' >
				
				<img src="add-to-cart.png" alt='Add' class="btnAddAction" onclick=" return addcart('<?php echo $i; ?>'); return false;" /> 
			
		</form>
	</div> 
	
	<?php
		$i++;
		}
	}//End If 
	?>
</div>	
</div>	