<meta charset="utf-8">
<?php

$json ='{
  "customer": {
    "firstName": "Jaroslav",
    "lastName": "Trener",
    "email": "Jar.Trener954@sezznamm.cz",
    "phone": "+420765787435",
    "addresses": [
                      {
                        "city": "Brno",
                        "streetAddress": "Holandská",
                        "streetNumber": "510",
                        "zip": "60500",
                        "addressType": "PERMANENT"
                      }
                   ]
  },
  "order": {
    "number": "57834704124",
  "variableSymbols": [
                "989595"
            ],

    "totalPrice": {
      "amount": 200000,
      "currency": ' . $mena . '
    },
    "totalVat": [
      {
        "amount": 42000,
        "currency": ' . $mena . ',
        "vatRate": 21
      }
    ],
    "addresses": [
      {
        "city": "Brno",
        "streetAddress": "Holandská",
        "streetNumber": "622",
        "zip": "60500",
        "addressType": "DELIVERY"
      }
    ],
    
   
    "items": [
      {
                "code": "5202",
                "ean": "9999545",
        "name": "iPhone 6s 32GB SpaceGray",
        "quantity": 1,
        "unitPrice": {
          "amount": 200000,
          "currency": ' . $mena . '
        },
        "unitVat": {
          "amount": 42000,
          "currency": ' . $mena . ',
          "vatRate": 21
        },
        "totalPrice": {
          "amount": 200000,
          "currency": ' . $mena . '
        },
        "totalVat": {
          "amount": 42000,
          "currency": ' . $mena . ',
          "vatRate": 21
        },
        "productUrl": "https://www.example.com?itemId=10"
 
      }
    ]
  },
  "type": "INSTALLMENT",
  "settingsInstallment": {
  '.$installment.'
   },
  "agreementPersonalDataProcessing": true,
  "merchantUrls": {
    "approvedRedirect": "http://localhost9",
    "rejectedRedirect": "http://localhost",
    "notificationEndpoint": "http://uzjepekne.cz"
  }
}
  ';
?>