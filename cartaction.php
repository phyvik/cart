  
<?php
	require_once "shoppingcart.php";
	$shoppingCart = new shoppingcart();
	?>

<?php

if($_REQUEST['action'] == "add"){
	$mycartlist = ""; 
    $myMenu  = $shoppingCart->getmeals($_REQUEST['mealid']); 
    //$orderid = $_REQUEST['phone']_time();
    $subtotalprice = $myMenu['price'] * $_REQUEST['quantity'];
    $jsondata = "";
    
    $checkmealcart = $shoppingCart->get_mealscart($_REQUEST['mealid'], $_REQUEST['phone']);
    if(isset($checkmealcart[0]['id'])){
        $shoppingCart->updatemeals_to_cart($_REQUEST['mealid'], $_REQUEST['quantity'], $subtotalprice, $_REQUEST['phone'], $jsondata );
    } else {
        $shoppingCart->insertmeals_to_cart($_REQUEST['mealid'], $_REQUEST['quantity'], $myMenu['mealorigin'],  $myMenu['mealdata'], $myMenu['price'], $subtotalprice, $_REQUEST['phone'], $jsondata );
    }
    
    $mycartlist = $shoppingCart->get_mealscartlist($_REQUEST['phone']);
    
    $i = 0;
    $total = 0;
	 echo $str = '
    <div id = "book" class = "container-fluid" style = "text-align:center; background-color:#f5efd5">
		<div class="text-center text-uppercase u-heading-v6-2 g-pt-30">
			<h2 class="h3 u-heading-v6__title g-font-size-20"> Cart </h2>
		</div>
	</div>
	<div class="container">
	<div class="row" id="cart_viewer">
		 
	<table class="table table-hover">
			  <tbody>
	'; 
    foreach($mycartlist as $key => $val){ 
        echo '<tr><th scope="row">'.$i.'</th>
                  <td style="color:#000;">'.$val['mealorigin'].'</td>
                        <td style="color:#000;">'.$val['quantity'].'</td>
                        <td style="color:#000;">'.$val['subtotal'].'</td>
                        <td>
						<div class="btn btn-primary" 
						onclick="return delete_mealitem('.$val['id'].' , '.$_REQUEST['phone'].' , '.$val['meal_id'].' )"> 
							Delete 
						</div>
						</td>
                </tr>';
        $total = $total + $val['subtotal'];
        $i++;
    } 
    echo " 
		<tr>
			<th scope='row'></th>
				<td> </td> 
				<td style='color:#000; font-weight:bold; font-size:20px;'> Total : ".$total."</td>
				<td><div class='btn btn-primary' onclick='return placeorder(".$_REQUEST['phone'].")'> Place Order  </div></td>
				<td> </td>
		</tr>
	</tbody>
		</table>
		
		</div></div>
		";
    
	return true;
	die();
}
//deleteMealsCart($cart_id)

if($_REQUEST['action'] == "del"){
    $mycartlist = "";
	 
	$mycart  = $shoppingCart->getProductCart_mealid($_REQUEST['mealid'], $_REQUEST['phone']); 
	
	$subtotalprice = $mycart[0]['subtotal'] - $mycart[0]['price'] ;
	$subtotalprice;
	$jsondata = ""; 
	if($_REQUEST['quantity'] == 0){
		$shoppingCart->deletemealwithmealsId($_REQUEST['mealid'],$_REQUEST['phone']);
	}
    $shoppingCart->updatemeals_to_cart($_REQUEST['mealid'], $_REQUEST['quantity'], $subtotalprice, $_REQUEST['phone'], $jsondata );
    
    $mycartlist = $shoppingCart->get_mealscartlist($_REQUEST['phone']);
	 
    if($mycartlist[0]['quantity'] == 0 ){
		echo '
			<div id = "book" class = "container-fluid" style = "text-align:center; background-color:#f5efd5">
			<div class="text-center text-uppercase u-heading-v6-2 g-pt-30">
				<h2 class="h3 u-heading-v6__title g-font-size-20"> Empty Cart </h2>
			</div>	
		</div>';
		return true;
		die();
	}
	
    $i = 0;
    $total = 0;
	 echo $str = '
    <div id = "book" class = "container-fluid" style = "text-align:center; background-color:#f5efd5">
		<div class="text-center text-uppercase u-heading-v6-2 g-pt-30">
			<h2 class="h3 u-heading-v6__title g-font-size-20"> Cart </h2>
		</div>
	</div>
	<div class="container">
	<div class="row" id="cart_viewer">
		 
	<table class="table table-hover">
			  <tbody>
	'; 
	
    foreach($mycartlist as $key => $val){ 
	
	if($val['quantity'] == 0){

		continue;
	}
			echo '<tr>
					<th scope="row">'.$i.'</th>
                    <td style="color:#000;">'.$val['mealorigin'].'</td>
                        <td style="color:#000;">'.$val['quantity'].'</td>
                        <td style="color:#000;">'.$val['subtotal'].'</td>
                        <td>
						<div class="btn btn-primary" 
						onclick="return delete_mealitem('.$val['id'].' , '.$_REQUEST['phone'].')"> 
							Delete 
						</div>
					</td>
                </tr>';
        $total = $total + $val['subtotal'];
        $i++;
    } 
    echo " 
		<tr>
			<th scope='row'></th>
				<td> </td> 
				<td style='color:red; font-weight:bold; font-size:20px;'> Total : ".$total."</td>
				<td><div class='btn btn-primary' onclick='return placeorder(".$_REQUEST['phone'].")'> Place Order  </div></td>
				<td> </td>
		</tr>
	</tbody>
		</table>
		</div></div>";
		
	return true;
	die();
}

if($_REQUEST['action'] == "cartdelrow"){
    
	$mycartlist = ""; 
	$shoppingCart->deletemealwithId( $_REQUEST['cartid']);
	
	$mycart  = $shoppingCart->get_mealscartlist($_REQUEST['phone']);
	
    $mycartlist = $shoppingCart->get_mealscartlist($_REQUEST['phone']);
	if(count($mycartlist) < 1 ){
		echo '
			<div id = "book" class = "container-fluid" style = "text-align:center; background-color:#f5efd5">
			<div class="text-center text-uppercase u-heading-v6-2 g-pt-30">
				<h2 class="h3 u-heading-v6__title g-font-size-20"> Empty Cart </h2>
			</div>	
		</div>';
		return true;
		die();
	}
    $i = 0;
    $total = 0;
	 echo $str = '
    <div id = "book" class = "container-fluid" style = "text-align:center; background-color:#f5efd5">
		<div class="text-center text-uppercase u-heading-v6-2 g-pt-30">
			<h2 class="h3 u-heading-v6__title g-font-size-20"> Cart </h2>
		</div>
	</div>
	<div class="container">
	<div class="row" id="cart_viewer">
		 
	<table class="table table-hover">
			  <tbody>
	'; 
	if(count($mycartlist) > 0 ){
		foreach($mycartlist as $key => $val){ 
			echo '<tr><th scope="row">'.$i.'</th>
					  <td style="color:#000;">'.$val['mealorigin'].'</td>
							<td style="color:#000;">'.$val['quantity'].'</td>
							<td style="color:#000;">'.$val['subtotal'].'</td>
							<td>
							<div class="btn btn-primary" 
							onclick="return delete_mealitem('.$val['id'].' , '.$_REQUEST['phone'].' , '.$val['meal_id'].' )"> 
								Delete 
							</div>
							</td>
					</tr>';
			$total = $total + $val['subtotal'];
			$i++;
		}
		
		echo " 
		<tr>
			<th scope='row'></th>
				<td> </td> 
				<td style='color:red; font-weight:bold; font-size:20px;'> Total : ".$total."</td>
				<td><div class='btn btn-primary' onclick='return placeorder(".$_REQUEST['phone'].")'> Place Order  </div></td>
				<td> </td>
		</tr>";
		
	}else {
		echo '
			<div id = "book" class = "container-fluid" style = "text-align:center; background-color:#f5efd5">
			<div class="text-center text-uppercase u-heading-v6-2 g-pt-30">
				<h2 class="h3 u-heading-v6__title g-font-size-20"> Empty Cart </h2>
			</div>	
		</div>';
	}	
    echo "
	</tbody>
		</table>
		</div></div>";
	
	return true;
	die();
}


?>