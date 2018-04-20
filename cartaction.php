  
<?php
	require_once "shoppingcart.php";
	$shoppingCart = new shoppingcart();
	?>

<?php
if(isset($_REQUEST['action']) == "add"){
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
        echo "<tr>
                    <th scope='row'>".$i."</th>
                        <td>".$val['mealorigin']."</td>
                        <td>".$val['quantity']."</td>
                        <td>".$val['subtotal']."</td>
                        <td>
						<div class='btn btn-primary' onclick='return delete_mealitem(\'".$val['id']."\'); > 
							Delete 
						</div>
						</td>
                </tr>" ;
        $total = $total + $val['subtotal'];
        $i++;
    } 
    echo " 
		<tr>
                    <th scope='row'></th>
                        <td> </td> 
                        <td> Total : ".$total."</td>
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


if(isset($_REQUEST['action']) == "del"){
    $mycartlist = "";
	$mycart  = $shoppingCart->get_mealscart($_REQUEST['mealid'], $_REQUEST['phone']);
     
    $subtotalprice = $mycart['price'] * $mycart['subtotal'];
    $jsondata = ""; 
    $shoppingCart->delete_mealscart($_REQUEST['mealid'], $_REQUEST['quantity'], $mycart['price'], $subtotalprice, $_REQUEST['phone'], $jsondata );
    
    $mycartlist = $shoppingCart->get_mealscartlist($_REQUEST['phone']);
    
	$str = '
    <div id = "book" class = "container-fluid" style = "text-align:center; background-color:#f5efd5">
		<div class="text-center text-uppercase u-heading-v6-2 g-pt-30">
			<h2 class="h3 u-heading-v6__title g-font-size-20"> Cart </h2>
		</div>	
	
            <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Handle</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>@fat</td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td colspan="2">Larry the Bird</td>
              <td>@twitter</td>
            </tr>
          </tbody>
        </table>
        </div>
      ';
       
	return true;
	die();
}


?>