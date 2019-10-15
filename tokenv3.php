<meta charset="utf-8">
<?php
/*
Pomocný soubor pro vygenerování "tokenu"
Pro vygenorování žádosti použijte startv3.php nebo manualv3.php
Pro zjištění stavu žádosti použijte applicationDetailv3.php
*/
include './optionv3.php';

$url=$url_base . '/authentication/v1/partner/';
//echo ('Url: ' . $url . '<br />');

// Prepare new cURL resource
//$ch = curl_init('https://api.example.com/api/1.0/user/login');
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $login);
curl_setopt($ch,CURLOPT_HTTPHEADER,array(
                'Content-Type: application/json',
                'Charset: utf-8' 
    )); 
 
// Submit the POST request
$result = curl_exec($ch);


$responze = json_decode( $result,true );

// Vypsání kompletní responze na POST
//var_dump($responze);

// Výpis chyby, pokud se objeví
if (!curl_errno($ch)) {
  switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
    case 200:  
    echo 'Soubor tokenv3.php => HTTP code : ', $http_code, ' # OK', '<br />';
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



echo 'accessToken: ' . $responze["accessToken"], '<br />';



?>