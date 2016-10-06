<?
require "config.php";
$saving = 0;
function no($str)
{
    			$str = stripslashes($str);
				$str = mysql_real_escape_string($str);
				$str = trim($str);
				$str = htmlspecialchars($str);
				return $str;
}
if(isset($_SESSION['user_id'])){
    
@$u = $_SESSION['user_id']; 
$user      = mysql_query("SELECT * FROM users  WHERE `id`='$u'");
$n_user          = mysql_fetch_array($user);
}else{
  @$u = no($_COOKIE['user_id']);  
}
 
$result = mysql_query("SELECT * FROM  cart where user_id='$u'", $db);
$row    = mysql_fetch_array($result);
if (empty($row['id'])) { 
header('Location: /');

}
 

 
if (isset($_COOKIE['state_zipcode'])) { 


$location_type = no($_COOKIE['location_type']);
$shipping_zip  = no($_COOKIE['state_zipcode']);
function usps_get_rates($zip_to, $zip_from, $w, $h, $d, $weight)
{
  
  $data = "API=RateV4&XML= 
<RateV4Request USERID=\"568PANHA1730\">
<Package ID=\"0\">
<Service>PRIORITY MAIL</Service> <ZipOrigination>$zip_from</ZipOrigination> <ZipDestination>$zip_to</ZipDestination> <Pounds>$weight</Pounds> 
<Ounces>0</Ounces> <Container>RECTANGULAR</Container> <Size>LARGE</Size> 
<Width>$w</Width> 
<Length>$d</Length> 
<Height>$h</Height>     
</Package> 
</RateV4Request>";
  $url = "http://Production.ShippingAPIs.com/ShippingAPI.dll";
  $ch = curl_init();

  // set the target url

  curl_setopt($ch, CURLOPT_URL, $url);

  // curl_setopt($ch, CURLOPT_HEADER, 1);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  // parameters to post

  curl_setopt($ch, CURLOPT_POST, 1);

  // send the POST values to USPS

  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $result = curl_exec($ch);
  $xml = simplexml_load_string($result);
   
   
   return trim($xml->Package->Postage->Rate);
}

function check_US($zip_to)
{
  $data = "API=CityStateLookup&XML=<CityStateLookupRequest USERID=\"568PANHA1730\"><ZipCode ID=\"0\"><Zip5>$zip_to</Zip5></ZipCode></CityStateLookupRequest>";
  $url = "http://Production.ShippingAPIs.com/ShippingAPI.dll";
  $ch = curl_init();

  // set the target url

  curl_setopt($ch, CURLOPT_URL, $url);

  // curl_setopt($ch, CURLOPT_HEADER, 1);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  // parameters to post

  curl_setopt($ch, CURLOPT_POST, 1);

  // send the POST values to USPS

  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $result = curl_exec($ch);
  $xml = simplexml_load_string($result);
  return $xml->ZipCode->State;
}

// // freight_center_quote

function freight_center_quote($zip_origin, $origin_location_type, $w, $h, $d, $weight, $quantity, $ship_option, $zip_to)
{
    if(isset($_SESSION['user_id'])){
    
                   @$u = $_SESSION['user_id']; 
                }else{
  $u = no($_COOKIE['user_id']);
                }
  $options = array(
    0 => 'Residential',
    1 => 'BusinessWithDockOrForklift',
    2 => 'BusinessWithoutDockOrForklift',
    3 => 'Terminal',
    4 => 'ConstructionSite',
    5 => 'ConventionCenterOrTradeshow'
  );
  
  $check_me = check_US($zip_to);
   if (!empty($check_me)) {

    // $zip_origin           = $row_product['zipcode'];
    // $origin_location_type = $row_product['location_type'];
    // $w                    = $row_product['w'];
    // $h                    = $row_product['h'];
    // $d                    = $row_product['d'];
    // $weight               = $row_product['weight'];
    // $quantity             = $row_cart["quantity"];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
          <soap:Body>
            <GetRates xmlns="http://freightcenter.com/API/V05/">
              <request>
                <LicenseKey>49963d42-01d2-44d1-97cc-0056b3d85118</LicenseKey>
                <Username>mike@panhandlerestaurantservices.com</Username>
                <Password>123456</Password>
                <CompanyId>1</CompanyId>
                <OriginPostalCode>' . $zip_origin . '</OriginPostalCode>
                <OriginLocationType>' . $options[$origin_location_type] . '</OriginLocationType>
                <DestinationPostalCode>' . $zip_to . '</DestinationPostalCode>
                <DestinationLocationType>' . $options[$ship_option] . '</DestinationLocationType>
                <Items>
                  <RatesRequest_Item>
                    <Description>Test</Description>
                    <PackagingCode>Palletized</PackagingCode>
                    <Quantity>' . $quantity . '</Quantity>
                    <FreightClass>85</FreightClass>
                    <Dimensions>
                      <Length>' . $d . '</Length>
                      <Width>' . $w . '</Width>
                      <Height>' . $h . '</Height>
                      <UnitOfMeasure>IN</UnitOfMeasure>
                    </Dimensions>
                    <Weight>
                      <WeightAmt>' . $weight . '</WeightAmt>
                      <UnitOfMeasure>lbs</UnitOfMeasure>
                    </Weight>
                  </RatesRequest_Item>
         
                </Items>
           
              </request>
            </GetRates>
          </soap:Body>
        </soap:Envelope>';
    $url = "http://api.freightcenter.com/v05/rates.asmx?wsdl";
    $headers = array(
      'Content-Type: text/xml; charset=utf-8',
      'Content-Length: ' . strlen($xml) ,
      'SOAPAction: "http://freightcenter.com/API/V05/GetRates"'
    );
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    $result = curl_exec($ch);
    curl_close($ch);
    $pattern = "/<totalcharge>(.*)<\/totalcharge>/siU";
    preg_match_all($pattern, $result, $out);
    return $out[1][0];
  }
}

// //freight_center_quote END////
// ////USP quote

require "SoapRateClient.php";

//  ups(30115,03,10,10,10,10);
// ///END UPS quote
 
$check_me_2 = check_US($shipping_zip);
if(!empty($check_me_2)){

setcookie('state', check_US($shipping_zip), time() + (86400 * 30 * 120), "/");  
setcookie('state_zipcode', $shipping_zip, time() + (86400 * 30 * 120), "/");
setcookie('location_type', $location_type, time() + (86400 * 30 * 120), "/");  

  // echo json_encode($errors);

  if (check_US($shipping_zip) == "GA") {
    $tax_key = 6;
  }
  elseif (check_US($shipping_zip) == "FL") {
    $tax_key = 7.5;
  }
  else {
    $tax_key = 0;
  }
  $saving = 0;
  $subtotal = 0;
  $shipping_price = 0;
  if(isset($_SESSION['user_id'])){
    
                   @$u = $_SESSION['user_id']; 
                }else{
  $u = $_COOKIE['user_id'];}
  $result_cart = mysql_query("SELECT * FROM  cart where user_id='$u'", $db);
  $row_cart = mysql_fetch_array($result_cart);
  do {
    $product_id = $row_cart['product_id'];
    $quantity = $row_cart['quantity'];
    $price = $row_cart['price'];
    $subtotal+= $quantity * $price;
    $result_product = mysql_query("SELECT * FROM  products where id='$product_id'", $db);
    $row_product = mysql_fetch_array($result_product);
    $free_shipping_array = explode(",", $row_product['free_states']);
    if (count($free_shipping_array) > 0 && in_array(check_US($shipping_zip) , array_map('trim', $free_shipping_array))) {
      $shipping_price += 0;
    }
    else {
      $shippings_array = explode(",", $row_product['delivery']);
      foreach($shippings_array as $method) {
        if ($method == -1) { ///usps
           $shipping_price+= 0;
        }
        elseif ($method == 0) { ///usps
          $ship = usps_get_rates($shipping_zip, $row_product['zipcode'], $row_product['w'],  $row_product['h'], $row_product['d'], $row_product['weight']);
          $shipping_price+= $ship*$quantity;
        }
        elseif ($method == 1) { //UPS
          $ship = ups($shipping_zip, $row_product['zipcode'], 03, $row_product['weight'], $row_product['w'], $row_product['d'], $row_product['h']);
          $shipping_price+= $ship*$quantity;
        }
        else { //Freight
          $ship = freight_center_quote($row_product['zipcode'], $row_product['location_type'], $row_product['w'], $row_product['h'], $row_product['d'], $row_product['weight'], $quantity, $location_type, $shipping_zip);
          $shipping_price+= $ship;
        }
      }
    }
  }while ($row_cart = mysql_fetch_array($result_cart));
  
  if(isset($_SESSION['code'])){
    $saving = $subtotal/100*$_SESSION['discount'];
  }else{
      $saving = 0;
  }
  $tax = ($subtotal-$saving) / 100 * $tax_key;
  $total = round($subtotal - $saving + $shipping_price + $tax, 2);

  $json = array('subtotal' => $subtotal, 'total' => $total, 'tax' => $tax, 'shipping' => $shipping_price,'saving' => $saving);

 
}else{
    $json = array('subtotal' => $subtotal, 'total' => $total, 'tax' => '...', 'shipping' => '...','saving' => $saving);
}
}else{
  $subtotal = 0;
  if(isset($_SESSION['user_id'])){
    
                   @$u = $_SESSION['user_id']; 
                }else{
  $u = $_COOKIE['user_id'];}
  $result_cart = mysql_query("SELECT * FROM  cart where user_id='$u'", $db);
  $row_cart = mysql_fetch_array($result_cart);
  do {
  	$quantity = $row_cart['quantity'];
    $price = $row_cart['price'];
 	$subtotal+= $quantity * $price;
  	}while ($row_cart = mysql_fetch_array($result_cart));
 $json = array('subtotal' => $subtotal, 'total' => $subtotal, 'tax' => '...', 'shipping' => '...','saving' => $saving);
}

if (isset($_COOKIE['state_zipcode'])) {
				$state_zipcode = no($_COOKIE['state_zipcode']);
} else {
				$state_zipcode = "";
}

if (isset($_COOKIE['location_type'])) {
				$location_type = no($_COOKIE['location_type']);
} else {
				$location_type = "";
}

$options = array(
				0 => 'Residential',
				1 => 'BusinessWithDockOrForklift',
				2 => 'BusinessWithoutDockOrForklift',
				3 => 'Terminal',
				4 => 'ConstructionSite',
				5 => 'ConventionCenterOrTradeshow'
);
$states  = array(
				'AL' => 'Alabama',
				'AK' => 'Alaska',
				'AZ' => 'Arizona',
				'AR' => 'Arkansas',
				'CA' => 'California',
				'CO' => 'Colorado',
				'CT' => 'Connecticut',
				'DE' => 'Delaware',
				'DC' => 'District of Columbia',
				'FL' => 'Florida',
				'GA' => 'Georgia',
				'HI' => 'Hawaii',
				'ID' => 'Idaho',
				'IL' => 'Illinois',
				'IN' => 'Indiana',
				'IA' => 'Iowa',
				'KS' => 'Kansas',
				'KY' => 'Kentucky',
				'LA' => 'Louisiana',
				'ME' => 'Maine',
				'MD' => 'Maryland',
				'MA' => 'Massachusetts',
				'MI' => 'Michigan',
				'MN' => 'Minnesota',
				'MS' => 'Mississippi',
				'MO' => 'Missouri',
				'MT' => 'Montana',
				'NE' => 'Nebraska',
				'NV' => 'Nevada',
				'NH' => 'New Hampshire',
				'NJ' => 'New Jersey',
				'NM' => 'New Mexico',
				'NY' => 'New York',
				'NC' => 'North Carolina',
				'ND' => 'North Dakota',
				'OH' => 'Ohio',
				'OK' => 'Oklahoma',
				'OR' => 'Oregon',
				'PA' => 'Pennsylvania',
				'RI' => 'Rhode Island',
				'SC' => 'South Carolina',
				'SD' => 'South Dakota',
				'TN' => 'Tennessee',
				'TX' => 'Texas',
				'UT' => 'Utah',
				'VT' => 'Vermont',
				'VA' => 'Virginia',
				'WA' => 'Washington',
				'WV' => 'West Virginia',
				'WI' => 'Wisconsin',
				'WY' => 'Wyoming'
);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="Checkout">
		<meta name="author" content="">
	    <meta name="keywords" content="Checkout">
	    <meta name="robots" content="all">

	    <title>Checkout - Southeastern Restaurant Supply</title>

        <link rel="stylesheet" href="/assets/css/load.css">
	    <?require "header.php" ;?>

	</head>
    <body class="cnt-home">
	
		
	
		<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1 header-style-3">

	<!-- ============================================== TOP MENU ============================================== -->
<? require "top.php"; ?>

	<!-- ============================================== NAVBAR ============================================== -->
<? require "menu.php"; ?>
<!-- ============================================== NAVBAR : END ============================================== -->

</header>

<!-- ============================================== HEADER : END ============================================== -->
<div class="body-content outer-top-bd"> 
<div class="container">
<div class="checkout-box inner-bottom-sm">
			<div class="row">
				<div class="col-md-6">
					<div class="panel-group checkout-steps" id="accordion">
						<!-- checkout-step-01  -->
<div class="panel panel-default checkout-step-01" >

	<!-- panel-heading -->
		<div class="panel-heading">
    	<h4 class="unicase-checkout-title">
	        <a data-toggle="collapse" style="cursor:default;" class="" data-parent="#accordion" href="#collapseOne">
	          <span>1</span>Shipping Information
	        </a>
	     </h4>
    </div>
    <!-- panel-heading -->

	<div id="collapseOne" class="panel-collapse collapse in">

		<!-- panel-body  -->
	    <div class="panel-body"  style="    padding: 8px;">
			<div class="col-md-12 col-sm-12 sign-in">
	 <div id="check1">
	 
		<div class="form-group">
		    <label class="info-title" for="exampleInputEmail1">First name:<span>*</span></label>
            <? if(!isset($_SESSION['user_id'])){?>
		    <input type="test" name="shipping_first_name"  placeholder="Your name" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputEmail1">
		    <?}else{?>
             <input type="test" name="shipping_first_name" value="<?=$n_user['firstname']?>" placeholder="Your name" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputEmail1">
            <?}?>
        </div>
	  	<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Last name:<span>*</span></label>
            <? if(!isset($_SESSION['user_id'])){?>
		    <input type="text" name="shipping_last_name" placeholder="Your lastname" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
            <?}else{?>
              <input type="text" name="shipping_last_name" value="<?=$n_user['lastname']?>" placeholder="Your lastname" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">

            <?}?>
    </div>
		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Email:<span>*</span></label>
            <? if(!isset($_SESSION['user_id'])){?>
		    <input type="email" name="email" placeholder="Your contact email" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
	       	<?}else{?>
          <input type="email" name="email" value="<?=$n_user['email']?>" placeholder="Your contact email" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">

               <?}?>
        </div>

		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Phone:<span>*</span></label>
            <? if(!isset($_SESSION['user_id'])){?>
		    <input type="text" name="phone" placeholder="Your phone number (XXX-XXX-XXXX)" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
	        <?}else{?>
             <input type="text" name="phone" value="<?=$n_user['phone']?>" placeholder="Your phone number" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">

            <?}?>
    </div>

		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Street address:<span>*</span></label>
		    <input type="text"  name="shipping_address" placeholder="Shipping address" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
		</div>
		 <div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">City:<span>*</span></label>
		    <input type="text" name="shipping_city" placeholder="Shipping town" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
		</div>
		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Location type:<span>*</span></label>
		    <select name="location_type" id="lct" style="width: 100%;height: 50px;"  class="form-control unicase-form-control text-input">
		    <?foreach ($options as $key => $name) {?>
		    	<?if($location_type==$key){$selected = "selected";}else{$selected="";}?>
		    	<option value="<?=$key?>" <?=$selected?>><?=preg_replace('/(?<!\ )[A-Z]/', ' $0', $name);?></option>
		    <?}?>
		   	</select> 
		</div>
<!-- 		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">State:<span>*</span></label>
		    <select name="shipping_state" style="width: 100%;height: 50px;" id="tax_state" class="form-control unicase-form-control text-input">
		    <?foreach ($states as $abb => $name) {?>
		    	<?if($state==$abb){$selected = "selected";}else{$selected="";}?>
		    	<option value="<?=$abb?>" <?=$selected?>><?=$name?></option>
		    <?}?>
		   	</select> 
		</div> -->
		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Zip:<span>*</span></label>
		    <input type="text" name="shipping_zip" placeholder="Shipping zipcode" style="width: 100%;" class="form-control unicase-form-control text-input" value="<?=$state_zipcode?>" id="exampleInputPassword1">
		</div>
	</div>
		<button type="submit" id="complete_step_1" style="float:right;" class="btn-upper text-right btn btn-primary checkout-page-button">Next step</button>&nbsp;&nbsp;
		<button type="submit" id="calculate_shipping" style="     margin-left: 45%;background: #466591" class="btn-upper text-right btn btn-primary checkout-page-button">Calculate shipping</button>
	  	
	 					
</div>		
		</div>
		<!-- panel-body  -->

	</div><!-- row -->
</div>
<!-- checkout-step-01  -->
					    <!-- checkout-step-02  -->
					  	<div class="panel panel-default checkout-step-02">
						    <div class="panel-heading">
						      <h4 class="unicase-checkout-title">
						        <a data-toggle="collapse" style="cursor:default;" class="collapsed" data-parent="#accordion" href="#collapseTwo" >
						          <span>2</span>Billing Information
						        </a>
						      </h4>
						    </div>
						    <div id="collapseTwo" class="panel-collapse collapse">
						      <div class="panel-body" style="    padding: 8px;">
						        <div class="col-md-12 col-sm-12 sign-in">
                                    <button type="submit" id="copy_paste" style="float:right;" class="btn-upper text-right btn btn-warning checkout-page-button" style="background-color:#4CAF50;">Same as Shipping? (click here)</button>&nbsp;&nbsp;
	 <div id="check2">
	 <div class="form-group">
		    <label class="info-title" for="exampleInputEmail1">First name:<span>*</span></label>
		    <input type="text" name="billing_first_name" placeholder="Your name" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputEmail1">
		</div>
	  	<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Last name:<span>*</span></label>
		    <input type="text" name="billing_last_name" placeholder="Your lastname" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
		</div>
	 
		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Street address:<span>*</span></label>
		    <input type="text" name="billing_address"  placeholder="Your billing address" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
		</div>
		 <div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">City:<span>*</span></label>
		    <input type="text" name="billing_city"  placeholder="Your billing city" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
		</div>
		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">State:<span>*</span></label>
		    <select name="billing_state" style="width: 100%;height: 50px;" class="form-control unicase-form-control text-input">
		    <?foreach ($states as $abb => $name) {?>

		    	<option value="<?=$abb?>"><?=$name?></option>
		    <?}?>
		   	</select> 
		</div>
		<div class="form-group">
		    <label class="info-title"   for="exampleInputPassword1">Zip:<span>*</span></label>
		    <input type="text" name="billing_zip"  placeholder="Your billing zipcode" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
		</div>
	</div>
	  	<button type="submit" id="complete_step_2" style="float:right;" class="btn-upper text-right btn btn-primary checkout-page-button">Next step</button>	
		
	 				
</div>
						      </div>
						    </div>
					  	</div>


					<div class="panel panel-default checkout-step-03">
						    <div class="panel-heading">
						      <h4 class="unicase-checkout-title">
						        <a data-toggle="collapse" style="cursor:default;" class="collapsed" data-parent="#accordion" href="#collapseThree">
						          <span>3</span>Credit Card Information
						        </a>
						      </h4>
						    </div>
						    <div id="collapseThree" class="panel-collapse collapse">
						      <div class="panel-body" style="    padding: 8px;">
						        <div class="col-md-12 col-sm-12 sign-in">
						        	<div id="check3">
						        	<div class="form-group">
		    <label class="info-title" for="exampleInputEmail1">Card number:<span>*</span></label>
		    <input type="text" name="cc_number"   placeholder="Your credit card number" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputEmail1">
		</div>
	  	<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Month:<span>*</span></label>
		    <input type="text" name="cc_month"  placeholder="05" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
		</div>
		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Year:<span>*</span></label>
		    <input type="text" name="cc_year"  placeholder="19" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
		</div>

		<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">CCV:<span>*</span></label>
		    <input type="text" name="ccv"  placeholder="***" class="form-control unicase-form-control text-input" style="width: 100%;" id="exampleInputPassword1">
		</div>
 </div>
 <input type="checkbox" id="agreement" class="unicase-form-control text-input"   style="float:left;">&nbsp; <span id="read">I Read Terms and Conditions Agreement</span>  
	  	<button type="submit" id="complete_step_3" style="float:right;" class="btn-upper btn text-right btn-primary checkout-page-button">Complete</button>
					
</div>
						      </div>
						    </div>
					  	</div>
					   
					  	
					</div><!-- /.checkout-steps -->
				</div>
				<div class="col-md-4">
					<!-- checkout-progress-sidebar -->
<div class="checkout-progress-sidebar ">
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h4 class="unicase-checkout-title">Your Summary</h4>
		    </div>
		     <center><img src="/facebook.gif" height="112px" class="spinner_show" style="display:none;"></center>
	<table class="table table-bordered" id="hide_summary">
		<thead>
			<tr>
				<th>
					  <!-- <div class="cart-sub-total">
						Subtotal<span class="inner-left-md">$600.00</span>
					</div>   -->
					 <span style="font-size: 18px;">Items total:</span><span   style=" float:right;">$<?=number_format($json['subtotal'],2)?></span>
					 
				</th>
			</tr>
                		<tr>
				<th>
					  <!-- <div class="cart-sub-total">
						Subtotal<span class="inner-left-md">$600.00</span>
					</div>   -->
					 <span style="font-size: 18px;">Saving:</span><span   style=" float:right;">$<?=number_format($json['saving'],2)?></span>
					 
				</th>
			</tr>
			<tr>
				<th>
					    
					 <span style="font-size: 18px;">Shipping:</span><span id="shipping" style="float:right;"><?if($json['shipping']!=='...'){?>$<?echo number_format($json['shipping'],2);}else{echo '...';}?></span>
					 
				</th>
			</tr>
			<tr>
				<th>
					    
					<span style="font-size: 18px;"> Tax: </span><span id="tax" style="float:right;"><?if($json['tax']!=='...'){?>$<? echo number_format($json['tax'],2);}else{echo '...';}?></span>
					 

				</th>
			</tr>
						<tr>
				<th>
					    
					<span style="font-size: 22px;color:#D33433;">TOTAL: </span><span id="total" style="float:right;">$<?=number_format($json['total'],2)?></span>
					 

				</th>
			</tr>
		</thead><!-- /thead -->
		 
	</table><!-- /table -->
 
		</div>
	</div>
</div> 
<!-- checkout-progress-sidebar -->				</div>
			</div><!-- /.row -->
		</div><!-- /.checkout-box -->
<!-- ============================================== BLOG SLIDER : END ============================================== -->

      <!-- ============================================== BRANDS CAROUSEL ============================================== -->
<? require "brands.php"; ?>
<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	
	

	</div><!-- /.container -->
</div><!-- /#top-banner-and-menu -->




<? require "footer.php"; ?>
 <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

 
 
<script type="text/javascript">
	$(document).ready(function() {
    

		function total() {
			var total = <?=$json['subtotal']?>;
			// 			$( ".cart-grand-total-price" ).each(function() {
			//   total += numeral().unformat($(this).text());
			// });
			$(".cart-grand-total").find("span").text(numeral(total).format('$0,0.00'));
			$("#total_price_top").text(numeral(total).format('0,0.00'));
		}
		$("#tax_state").change(function() {
			var amount = <?=$json['subtotal']?>;
			var val = $(this).val();
			if (val == "GA") {
				var p = 6;
			} else if (val == "FL") {
				var p = 7.5;
			} else {
				var p = 0;
			}
			var total = amount + amount / 100 * p;
			$("#tax").text(numeral(amount / 100 * p).format('$0,0.00'));
			$("#total").text(numeral(total).format('$0,0.00'));
		});
		$('body').on('click', '#calculate_shipping, #complete_step_1', function() {
			var errors = [];
			var amount = <?=$json['subtotal']?>;
			var zip = $.trim($("input[name=shipping_zip]").val());
			var ship_option = $("#lct option:selected").val();
			if (zip == "") {
				errors.push("ZIP");
				$("input[name=shipping_zip]").css("border-color", "red");
			} else {
				delete errors["ZIP"];
				$("input[name=shipping_zip]").css("border-color", "");
			}
			if (errors.length == 0) {
				$(".spinner_show").show();
				$("#hide_summary").hide();
				$.ajax({
					url: '/get_quote.php',
					method: 'POST',
					data: {
						ship_option: ship_option,
						zip: zip
					},
					success: function(data) { 
						var json = $.parseJSON(data);
						$(".spinner_show").hide();
						$("#hide_summary").show();
						



						if(json.FAILED=="ERROR"){
							alert("This zip code is not belong to U.S!")
						}else{ 
						$("#shipping").text(numeral(json.shipping).format('$0,0.00'));
						 
						//var sub_total = numeral().unformat($("#sub_total").text());
						$("#tax").text(numeral(json.tax).format('$0,0.00'));
						$("#total").text(numeral(json.total).format('$0,0.00'));


						// $("#shipping").text(numeral(json.price).format('$0,0.00'));
						// var val = json.state;
						// if(val == "ERROR"){
						// 	alert("This ZIPCODE is not belong to U.S!")
						// }else{
						// 	if (val == "GA") {
						// 		var p = 6;
						// 	} else if (val == "FL") {
						// 		var p = 7.5;
						// 	} else {
						// 		var p = 0;
						// 	}
						// 	$("#tax").text(numeral(amount / 100 * p).format('$0,0.00'));
						// 	var total = amount + json.price + amount / 100 * p;
						// 	$("#total").text(numeral(total).format('$0,0.00'));
						// 	}
					}
					}
				});
			}
		});
		$('body').on('click', '#complete_step_1', function() {
			var errors = [];
			$('#check1 :input').each(function(index, value) {
				if ($.trim($(this).val()) == "") {
					$(this).css("border-color", "red");
					errors.push($(this).attr("name"));
				} else if ($(this).attr("name") == "email") {
					if (!isValidEmailAddress($(this).val())) {
						$(this).css("border-color", "red");
						errors.push($(this).attr("name"));
					} else {
						$(this).css("border-color", "");
					}
				} else {
					$(this).css("border-color", "");
				}
			});
			if (errors.length > 0) {
				$("#collapseOne").addClass("in");
			} else {
				// $("#collapseOne").removeClass("in");
				$("a[href=#collapseTwo]").click();
				// $("#collapseTwo").addClass("in");
				//$("#collapseTwo").removeAttr("style");
				//$("#collapseOne").addClass("panel-collapse collapse in");
			}
		});
        
        
        
        $('body').on('click', '#copy_paste', function() { 
		  $("input[name=billing_first_name]").val($.trim($("input[name=shipping_first_name]").val()));
			  $("input[name=billing_last_name]").val($.trim($("input[name=shipping_last_name]").val()));
			  $("input[name=billing_address]").val($.trim($("input[name=shipping_address]").val()));
			 $("input[name=billing_city]").val($.trim($("input[name=shipping_city]").val()));
             
             function readCookie(name) {
                    var nameEQ = name + "=";
                    var ca = document.cookie.split(';');
                    for(var i=0;i < ca.length;i++) {
                        var c = ca[i];
                        while (c.charAt(0)==' ') c = c.substring(1,c.length);
                        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                    }
                    return null;
                }
                var cookie_state = readCookie('state');
		  $("select[name=billing_state]").val(cookie_state);
			 $("input[name=billing_zip]").val( $.trim($("input[name=shipping_zip]").val()));
		 
		});
        
        
        
		$('body').on('click', '#complete_step_2', function() {
			var errors = [];
			var billing_first_name = $.trim($("input[name=billing_first_name]").val());
			var billing_last_name = $.trim($("input[name=billing_last_name]").val());
			var billing_address = $.trim($("input[name=billing_address]").val());
			var billing_city = $.trim($("input[name=billing_city]").val());
			var billing_state = $.trim($("select[name=billing_state]").val());
			var billing_zip = $.trim($("input[name=billing_zip]").val());
			$('#check2 :input').each(function(index, value) {
				if ($.trim($(this).val()) == "") {
					$(this).css("border-color", "red");
					errors.push($(this).attr("name"));
				} else {
					$(this).css("border-color", "");
				}
			});
			if (errors.length > 0) {
				$("#collapseTwo").addClass("in");
			} else {
				// $("#collapseTwo").removeClass("in");
				// $("a[href=#collapseTwo]").addClass("collapsed");
				// $("#collapseThree").addClass("in");
				// $("#collapseThree").removeAttr("style");
				$("a[href=#collapseThree]").click();
				//$("#collapseOne").addClass("panel-collapse collapse in");
			}
		});
		$('body').on('click', '#complete_step_3', function() {
			var errors = alert("You have errors!");
			if ($('#agreement').is(':checked')) {
				$('#read').css("color", "");
			} else {
				$('#read').css("color", "red");
				errors.push("agrrement");
			}
			$('#check3 :input').each(function(index, value) {
				if ($.trim($(this).val()) == "") {
					$(this).css("border-color", "red");
					errors.push($(this).attr("name"));
				} else {
					$(this).css("border-color", "");
				}
			});
			if (errors.length > 0) {} else {
				var serialize = $('#accordion :input, select').serialize();
                var html = "<div class='loading'>Loading&#8230;</div>";
    			$(html).hide().appendTo("#accordion").fadeIn(1000);
				$.ajax({
					url: '/do_checkout.php',
					method: 'POST',
					data: {
						serialize
					},
					success: function(data) {    
						if (data == 1) {
							 window.location.replace("/success.php");
						} else {
							var list = JSON.parse(data);
							alert("You have incorrect infromation!");
                            $(".loading").fadeOut();
							$.each(list, function(index, val) {
								$("#accordion").find("input[name=" + val + "]").css("border-color", "red");
							});
						}
					}
				});
			}
		});
	});

	function isValidEmailAddress(emailAddress) {
		var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return pattern.test(emailAddress);
	};
</script>