<meta charset="utf-8">
<?php

// Dostupné důvody storna (položka "reason"):
// - APPLICATION_CANCELLED_CARRIER_CHANGED - Změna dodavatele zboží
// - APPLICATION_CANCELLED_CART_CONTENT_CHANGED - Obsah nákupního košíku změněn
// - APPLICATION_CANCELLED_BY_CUSTOMER - Zrušeno zákazníkem (ve správě jeho účtu/objednávek)
// - APPLICATION_CANCELLED_BY_ERP - Zrušeno na základě back-office procesu obchodu (např. z důvodu chybějící položky zboží)
// - APPLICATION_CANCELLED_EXPIRED - Vypršení platnosti žádosti/objednávky
// - APPLICATION_CANCELLED_UNFINISHED - Objednávka nebyla zákazníkem dokončena
// - APPLICATION_CANCELLED_BY_ESHOP_RULES - Porušení vnitřních pravidel e-shopu (např. z důvodu neplatných dodatečných dat zákazníka)
// - APPLICATION_CANCELLED_OTHER - Jiný důvod specifikovaný v položce customReason

$json ='{
  "reason": "APPLICATION_CANCELLED_OTHER",
  "customReason": "nespecifikovany duvod"
}
  ';
?>
