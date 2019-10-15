<meta charset="utf-8">
<?php
/*
Pomocný soubor pro vygenerování "tokenu"
Pro vygenorování žádosti použijte startv3.php nebo manualv3.php
Pro zjištění stavu žádosti použijte applicationDetailv3.php

Přednastavena je adresa pro CZ train prostředí
*/
//CZ train prostředí
$url_base = 'https://apicz-test.homecredit.net/verdun-train';
$mena='"CZK"';

//SK train prostředí
//$url_base = 'https://apisk-test.homecredit.net/verdun-train';
//$mena='"EUR"';

//CZ produkční prostředí
//$url_base = 'https://api.homecredit.cz';
//$mena='"CZK"';

//SK produkční prostředí
//$url_base = 'https://api.homecredit.sk';
//$mena='"EUR"';

//Nastavení klientem preferovaných splátek. 
//#1  Pro Tipaře v CZ - prázdná hodnota
$installment = '';
//#2  Pro widget - chcete-li předávat do myLoan klientem vybrané splátky  
 /* 
    $installment = '
    "preferredMonths": 0,
     "preferredInstallment": {
      "amount": 26800,
      "currency": ' . $mena . '
    },
    "preferredDownPayment": {
      "amount": 0,
      "currency": ' . $mena . '
    },
    "productCode": "COCONL08",
    "productSetCode": "COCHCONL"
   '; 
 */
//username a password pro CZ a SK train prostředí - pro produkci nutno získat od HC
$login = '{
  "username" : "024243tech",
  "password" : "024243tech"
}';

?>