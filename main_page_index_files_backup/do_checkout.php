<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "config.php";
require "mails.php";
@session_start();

// 0 - USPS
// 1 - UPS
// 2 - freight w/o docklift
// 3 - freight w docklift

$params = array();
parse_str($_POST['serialize'], $params);

function no($str)
{
  $str = stripslashes($str);
  $str = mysql_real_escape_string($str);
  $str = trim($str);
  $str = htmlspecialchars($str);
  return $str;
}

$errors = array();
$shipping_first_name = no($params["shipping_first_name"]);
$shipping_last_name = no($params["shipping_last_name"]);
$email = no($params["email"]);
$phone = no($params["phone"]);
$shipping_address = no($params["shipping_address"]);
$shipping_city = no($params["shipping_city"]);
$location_type = no($params["location_type"]);
$shipping_zip = no($params["shipping_zip"]);
$billing_first_name = no($params["billing_first_name"]);
$billing_last_name = no($params["billing_last_name"]);
$billing_address = no($params["billing_address"]);
$billing_city = no($params["billing_city"]);
$billing_state = no($params["billing_state"]);
$billing_zip = no($params["billing_zip"]);
$cc_number = no($params["cc_number"]);
$cc_month = no($params["cc_month"]);
$cc_year = no($params["cc_year"]);
$ccv = (int)no($params["ccv"]);


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
  return trim($xml->ZipCode->State);
}

// // freight_center_quote

function freight_center_quote($zip_origin, $origin_location_type, $w, $h, $d, $weight, $quantity, $ship_option, $zip_to)
{if(isset($_SESSION['user_id'])){
    
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
  $chh = check_US($zip_to);
  if (!empty($chh)) {

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
                <OriginPostalCode>34683</OriginPostalCode>
                <OriginLocationType>BusinessWithDockOrForklift</OriginLocationType>
                <DestinationPostalCode>61604</DestinationPostalCode>
                <DestinationLocationType>BusinessWithDockOrForklift</DestinationLocationType>
                <Items>
                  <RatesRequest_Item>
                    <Description>Test</Description>
                    <PackagingCode>Palletized</PackagingCode>
                    <Quantity>1</Quantity>
                    <FreightClass>85</FreightClass>
                    <Dimensions>
                      <Length>40</Length>
                      <Width>48</Width>
                      <Height>50</Height>
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

if (empty($shipping_first_name)) {
  $errors[] = "shipping_first_name";
}

if (empty($shipping_last_name)) {
  $errors[] = "shipping_last_name";
}

if (!preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $email)) {
  $errors[] = 'email';
}

if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
          $errors[] = 'phone'; 
}

if (empty($shipping_address)) {
  $errors[] = "shipping_address";
}

if (empty($shipping_city)) {
  $errors[] = "shipping_city";
}

// if (empty($shipping_state)){
//  $errors[] = "shipping_state";
// }

if (empty($shipping_zip)) {
  $errors[] = "shipping_zip";
}

if (empty($billing_first_name)) {
  $errors[] = "billing_first_name";
}

if (empty($billing_last_name)) {
  $errors[] = "billing_last_name";
}

if (empty($billing_address)) {
  $errors[] = "billing_address";
}

if (empty($billing_city)) {
  $errors[] = "billing_city";
}

if (empty($billing_state)) {
  $errors[] = "billing_state";
}

if (empty($cc_number)) {
  $errors[] = "cc_number";
}

if (empty($cc_month)) {
  $errors[] = "cc_month";
}

if (empty($cc_year)) {
  $errors[] = "cc_year";
}

if (empty($ccv)) {
  $errors[] = "ccv";
}

if (count($errors) > 0) {
  echo json_encode($errors);
}
else {

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

  $subtotal = 0;
  $shipping_price = 0;
  if(isset($_SESSION['user_id'])){
    
                   @$u = $_SESSION['user_id']; 
                }else{
  $u = $_COOKIE['user_id'];
                }
  $result_cart = mysql_query("SELECT * FROM  cart where user_id='$u'", $db);
  $row_cart = mysql_fetch_array($result_cart);
  
  if(empty($row_cart['id'])){
      exit ("ERROR");
  }
  
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
  }

  while ($row_cart = mysql_fetch_array($result_cart));
   
    if(isset($_SESSION['code'])){
    $saving = $subtotal/100*$_SESSION['discount'];
  }else{
      $saving = 0;
  }
  $tax = ($subtotal-$saving) / 100 * $tax_key;
  $total = round($subtotal-$saving + $shipping_price + $tax, 2) * 100;
  $serviceURL = 'https://api.payeezy.com/v1/transactions';
  $apiKey = "IBKFupcGtlUnyRWDVmRbeasiCYfCnFs7";
  $apiSecret = "27019aafdef69e0c87ea0bc465efe225173484abf05de871e179783f53eb6e34";
  $token = "fdoa-45d9f451bc254970a49131b9c77aba4c45d9f451bc254970";
  $nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));
  $timestamp = strval(time() * 1000); //time stamp in milli seconds
  function cardType($number)
  {
    $number = preg_replace('/[^\d]/', '', $number);
    if (preg_match('/^3[47][0-9]{13}$/', $number)) {
      return 'American Express';
    }
    elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/', $number)) {
      return 'Diners Club';
    }
    elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/', $number)) {
      return 'Discover';
    }
    elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/', $number)) {
      return 'JCB';
    }
    elseif (preg_match('/^5[1-5][0-9]{14}$/', $number)) {
      return 'Master Card';
    }
    elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $number)) {
      return 'Visa';
    }
    else {
      return 'Unknown';
    }
  }
 
  function setPrimaryTxPayload($cc_number, $cc_month, $cc_year, $ccv, $billing_first_name, $billing_last_name, $total)
  {
    $card_holder_name = $card_number = $card_type = $card_cvv = $card_expiry = $currency_code = $merchant_ref = "";
    $card_holder_name = no($billing_first_name . ' ' . $billing_last_name);
    $card_number = $cc_number;
    $card_type = cardType($cc_number);
    $card_cvv = no($ccv);
    $card_expiry = no($cc_month . $cc_year);
    $amount = no($total);
    $currency_code = no("USD");
    $merchant_ref = no("Astonishing-Sale");
    $primaryTxPayload = array(
      "amount" => $amount,
      "card_number" => $card_number,
      "card_type" => $card_type,
      "card_holder_name" => $card_holder_name,
      "card_cvv" => $card_cvv,
      "card_expiry" => $card_expiry,
      "merchant_ref" => $merchant_ref,
      "currency_code" => $currency_code,
    );
    return $primaryTxPayload;
  }

  /**
   * Payeezy
   *
   * Generate Payload
   */
  function getPayload($args = array())
  {
    $args = array_merge(array(
      "amount" => "",
      "card_number" => "",
      "card_type" => "",
      "card_holder_name" => "",
      "card_cvv" => "",
      "card_expiry" => "",
      "merchant_ref" => "",
      "currency_code" => "",
      "transaction_tag" => "",
      "split_shipment" => "",
      "transaction_id" => "",
    ) , $args);
    $data = "";
    $data = array(
      'merchant_ref' => $args['merchant_ref'],
      'transaction_type' => "authorize",
      'method' => 'credit_card',
      'amount' => $args['amount'],
      'currency_code' => strtoupper($args['currency_code']) ,
      'credit_card' => array(
        'type' => $args['card_type'],
        'cardholder_name' => $args['card_holder_name'],
        'card_number' => $args['card_number'],
        'exp_date' => $args['card_expiry'],
        'cvv' => $args['card_cvv'],
      )
    );
    return json_encode($data, JSON_FORCE_OBJECT);
  } 

  $payload = getPayload(setPrimaryTxPayload($cc_number, $cc_month, $cc_year, $ccv, $billing_first_name, $billing_last_name, $total));
  $data = $apiKey . $nonce . $timestamp . $token . $payload;
  $hashAlgorithm = "sha256";
 

  $hmac = hash_hmac($hashAlgorithm, $data, $apiSecret, false);

 

  $hmac_enc = base64_encode($hmac);

  

  $curl = curl_init($serviceURL);
  $headers = array(
    'Content-Type: application/json',
    'apikey:' . strval($apiKey) ,
    'token:' . strval($token) ,
    'Authorization:' . $hmac_enc,
    'nonce:' . $nonce,
    'timestamp:' . $timestamp,
  );
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
  curl_setopt($curl, CURLOPT_VERBOSE, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  $json_response = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $response = json_decode($json_response, true);
   
  curl_close($curl);  
  if ($response['transaction_status']=='approved' && $response['validation_status']=='success'){

    
  $shipping_state =  check_US($shipping_zip);
  $datetime = date("Y-m-d H:i:s");
  $total = $total/100;
    if(isset($_SESSION['code'])){
    $code = $_SESSION['code'];
    $query = "UPDATE coupons SET used = used + 1 WHERE code = '$code';";

    $result = mysql_query($query) or die('Не могу занести данные в таблицу физ');  
    unset($_SESSION['code']);
    unset($_SESSION['discount']);
  }else{
       $code = "";
  }
  $query = "INSERT INTO  orders (user_id, saving,code, datetime, status, shipping_price, tax, subtotal, total, shipping_first_name,shipping_last_name,email,phone,shipping_address,shipping_city,shipping_state,shipping_zip,billing_first_name,billing_last_name,billing_address,billing_city,billing_state,billing_zip,cc_number,cc_month,cc_year,ccv)" . "VALUES ('$u','$saving', '$code','$datetime','new','$shipping_price','$tax','$subtotal','$total','$shipping_first_name','$shipping_last_name','$email','$phone','$shipping_address','$shipping_city','$shipping_state','$shipping_zip','$billing_first_name','$billing_last_name','$billing_address','$billing_city','$billing_state','$billing_zip','$cc_number','$cc_month','$cc_year','$ccv')";
  $result = mysql_query($query) or die('Не могу занести данные в таблицу2');
  $dd = mysql_insert_id();
  $_SESSION['order_id'] = $dd;
   $result_cart = mysql_query("SELECT * FROM  cart where user_id='$u'", $db);
   $row_cart = mysql_fetch_array($result_cart);
   do{
  $product_id = $row_cart['product_id'];
  $various = $row_cart['various'];
  $quantity = $row_cart['quantity'];
  $price = $row_cart['price'];
      $result_product = mysql_query("SELECT * FROM  products where id='$product_id'", $db);
            $row_product = mysql_fetch_array($result_product);
            
            $query_q = "UPDATE products SET quantity = quantity - $quantity WHERE id='$product_id'";

    $result_q = mysql_query($query_q) or die('Не могу занести данные в таблицу физ'); 
            // $row_product
  $query = "INSERT INTO  order_products (order_id,product_id ,various,quantity,price)" . "VALUES ('$dd','$product_id','$various','$quantity','$price')";
  $result = mysql_query($query) or die('Не могу занести данные в таблицу2');
   } while ($row_cart = mysql_fetch_array($result_cart));
  $delete = mysql_query("DELETE FROM cart WHERE user_id='$u'", $db);
  
echo 1;
invoice($dd);
  }else{
    echo 2;
  }
  

}

?>
