<?php
/*
Soubor zajistí vygenerování žádosti "createApplication" 
a připraví odkaz pro redirect klienta k manuálnímu přechodu kliknutím
*/
include './tokenv3.php' ;
include './json.php' ;

$url = $url_base . '/financing/v1/applications';
  

// Prepare new cURL resource
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch,CURLOPT_HTTPHEADER,array(
                'Content-Type: application/json',
                'Charset: utf-8', 
                'Authorization: Bearer ' . $responze["accessToken"] 
    ));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
 
 
// Submit the POST request
$result = curl_exec($ch);
$responze2 = json_decode( $result,true );

// Vypsání kompletní responze na POST
var_dump($responze2);

// Výpis chyby, pokud se objeví
if (!curl_errno($ch)) {
  switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
    case 200:  
    echo 'Soubor manualv3.php => HTTP code : ', $http_code, ' # OK', '<br />';
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


//Uložení aplicationID do souboru applicationDetail ke zjišťování stavů objednávky

echo "ID:".$responze2["id"], '<br />';
$soubor = fopen("./applicationID.txt", "w+");
fwrite($soubor, $responze2["id"]);
fclose($soubor);


//echo $responze["gatewayRedirectUrl"] ;
echo "<a href='".$responze2["gatewayRedirectUrl"]."'>Odkaz</a>";


?>