<?php
/*
Požadavek slouží k nastavení stavu Žádosti (Application) na Vyskladněno (ready_shipped)
Volat jde pouze u žádostí se stateReason = ready_to_ship

Stavy žádosti:
  Processing_redirect_needed ... stav po přesměrování, resp. po vytvoření createApplication, 1.krok
  Processing_preapproved, Processing_approved, Processing_review, Processing_alt_offer
  Processing_signed ... klient podepsal smlouvy, nyní je přesměrován zpět na eshop na adresu Url_approved
  Ready_to_ship ... objednávka je připravena k odeslání klientovi, zboží odešlete nebo předejte klientovi
  Ready_shipped ... potvrzeno eshopem, že zboží bylo odesláno klientovi (Webclient nebo odesláním Mark Order as Sent)
  Ready_delivered ... potvrzeno eshopem, že zboží bylo dodáno klientovi (odesláním Mark Order as Delivered)
  !!! eshop odesílá vždy pouze Mark Order as Sent nebo Mark Order as Delivered. Nikdy ne oboje.
  Rejected ... klient byl zamítnut, nyní je odeslán zpět na eshop na adresu url_rejected
  Ready_paid, Cancelled_not_paid, Cancelled_returned
*/
include './tokenv3.php' ;


$soubor = fopen("./applicationID.txt", "r");
$applicationID = fgets($soubor);
fclose($soubor);


$url = $url_base . '/financing/v1/applications/' . $applicationID . '/order/send';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch,CURLOPT_HTTPHEADER,array(
                'Content-Type: application/json',
                'Charset: utf-8', 
                'Authorization: Bearer ' . $responze["accessToken"] 
    ));
   
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
 
 
// Submit the POST request
$result = curl_exec($ch);
$responze2 = json_decode( $result,true );

// Vypsání kompletní responze na POST
var_dump($responze2);

// Výpis chyby, pokud se objeví
if (!curl_errno($ch)) {
  switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
    case 200:  
    echo 'Soubor applicationDetailv3 => HTTP code : ', $http_code, ' # OK', '<br />';
      break;
    default:
      echo 'Unexpected HTTP code: ', $http_code, '<br />';
  }
}

// Výpis podrobností
$info=curl_getinfo($ch);
//var_dump( $info);


// Close cURL session handle
curl_close($ch);



 echo '<br />';
 echo 'URL adresa pro Request :', $url, '<br />';
 echo '<br />';

echo '<br />', 'stateReason: ' . $responze2['stateReason'], '<br />';


?>
