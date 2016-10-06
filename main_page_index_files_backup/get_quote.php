<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "config.php";

@session_start();

// 0 - USPS
// 1 - UPS
// 2 - freight w/o docklift
// 3 - freight w docklift


function no($str)
{
  $str = stripslashes($str);
  $str = mysql_real_escape_string($str);
  $str = trim($str);
  $str = htmlspecialchars($str);
  return $str;
}

 
$location_type = no($_POST['ship_option']);
$shipping_zip  = no($_POST['zip']);
 

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
  $qqq = check_US($zip_to);
   if (!empty($qqq)) {

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
 
 $qqqq = check_US($shipping_zip);
  
 if (!empty($qqqq)) {
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

  $subtotal = 0;
  $shipping_price = 0;
   if(isset($_SESSION['user_id'])){
    
                   @$u = $_SESSION['user_id']; 
                }else{
                  $u = no($_COOKIE['user_id']);  
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
    if(!empty($row_product['free_states'])){
    $free_shipping_array = explode(",", $row_product['free_states']);
    
}else{
$free_shipping_array = array();
}

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

  $json = array('total' => $total, 'tax' => $tax, 'shipping' => $shipping_price);

  echo json_encode($json);
}else{
    $json = array('FAILED' => 'ERROR'); 
    echo json_encode($json);
}
  ?>