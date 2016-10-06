  <?
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
 
 
      
//       //Initialize curl
//       $ch = curl_init();
      
//       $headers = array(
//         'Content-Type: text/xml; charset=utf-8',
//         'Content-Length: ' . strlen($input_xml),
//         'SOAPAction: "http://tempuri.org/GetRatingEngineQuote"'
//       );
//       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//       curl_setopt($ch, CURLOPT_HEADER, 0); 
//       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//       curl_setopt($ch, CURLOPT_TIMEOUT, 180);
//       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//       curl_setopt($ch, CURLOPT_POST, 1);
//       curl_setopt($ch, CURLOPT_URL, "https://b2b.freightquote.com/WebService/QuoteService.asmx");
//       curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml); 
      
//  		$json = curl_exec($ch);
//         $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//         curl_close($ch);
//         echo "status:" . $http_status . "\n" . $json . "\n\n";
//         $response = json_decode($json);
//         echo $response;
 
//==============================================================================
// eco-worx.net Hybrid Shipping v1.0
//==============================================================================

$url = "http://api.freightcenter.com/v05/rates.asmx?wsdl";

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <soap:Body>
    <GetRates xmlns="http://freightcenter.com/API/V05/">
      <request>
        <LicenseKey>49963d42-01d2-44d1-97cc-0056b3d85118</LicenseKey>
        <Username>mike@panhandlerestaurantservices.com</Username>
        <Password>123456</Password>
        <CompanyId>1</CompanyId>

        <OriginLocationType>BusinessWithDockOrForklift</OriginLocationType>
        <OriginPostalCode>34683</OriginPostalCode>
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
</soap:Envelope>
';

$headers = array(
    'Content-Type: text/xml; charset=utf-8',
    'Content-Length: ' . strlen($xml), 
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
        
$error = '';
$error_msg = '';

print_r($result);
        
        if ($result) { 
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->load($result);
            
            
            $rate_response = $dom->getElementsByTagName('RateResponse')->item(0);
            $transaction_response = $rate_response->getElementsByTagName('TransactionResponse')->item(0);
            $response_status_code = $response->getElementsByTagName('MessageNumber');
            if ($response_status_code->item(0)->nodeValue != '200') {
               $error_msg  = $response_status_code;
               $error_msg .= ': ' . $transaction_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
            } else {
                    $rates       = $rate_response->getElementsByTagName('Rates')->item(0);
                    $carrierRate = $rates->getElementsByTagName('carrierRate')->item(0);
                    $total       = $carrierRate->getElementsByTagName('TotalCharge')->item(0)->nodeValue;
                    return ($total);
            }
                    return (9999);
      }


 