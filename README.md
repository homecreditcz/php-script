# Sada PHP scriptů pro jednoduché řešení klientské strany Home Credit API

> Nastaveno pro CZ train!!! 

> Pro SK train změňte v souboru `optionv3.php` URL (`$url_base`) a měnu (`$mena`). Pokud chcete předávat klientem vybrané splátky z widget kalkulačky na vstupní bod myLoan, pak upravte i sekci `$installment`. 

Sada PHP skriptů slouží k vytvoření žádosti "createApplication" v prostředí applikace myLoan v Home Creditu a obsahuje vytvoření šifrovaného tunelu pomocí tokenu a následné odeslání dat POST dotazem.

## Zpracování chybových stavů
Jde o třetí verzi, proto v3, a využívá se příkazu *curl*, který umožňuje zobrazit chybové stavy:
- 422 - duplikované číslo objednávky --> změňte číslo objednávky v `json.php`
- 404 - page not found --> train prostředí může mít krátkodobé výpadky z přetížení, odešlete žádost opakovaně v anonymním okně prohlížeče pomocí CTRL+F5 nebo zavřete a znovu otevřete prohlížeč (chyby se ukládají v cache prohlížeče a prohlížeč ji zobrazuje i v případě, že jste zdroj opravili). 
- 400 - bad request- patrně jste chybně upravili `json.php`, použijte zdrojový

## Základní zdrojové skripty

### tokenv3.php
- pomocný soubor k vygenerování tokenu

### startv3.php
- automatické vygenerování žádosti
- vytvoří se token, createApplication, a klient je přesměrován na stránku myLoan-kalkulace úvěru

### manualv3.php
- manuální vygenerování žádosti, již nedojde k přesměrování do myLoan. Používá se, pokud chcete klientům zobrazit sumář objednávky, na odkaz si již musí kliknout klient sám, případně doplníte automatickým přesměrováním po xx vteřinách

### optionv3.php
- pomocný soubor, zde se zadává adresa url_base pro jednotlivá prostředí (CZtrain, SKtrain, CZprodukce, SKprodukce), měna CZK/EUR, username a password

### json.php
- Zde jsou zdrojová data, která zasíláte do HC aplikace-myLoan. Zde si upravujete číslo objednávky, data o klientovi a zboží, případně zde můžete nastavit klientem preferované splátky, které jste si uložili z widget kalkulačky v detailu produktu
> *toto neplatí pro eshopy v režimu Tipař-mohou použít pouze kalkulačku Standalone, která údaje o klientem preferované variantě nepřenáší.*

## Rozšiřující zdrojové skripty
Následující funkce nemusíte nutně použít. Stavy se eshopům zobrazují v aplikaci Webclient. 

### applicationDetail.php
- Používá se k opakovaným requestům (Webservice) na stav žádosti, resp. její applicationID. 
- Při createApplication (tedy spuštěním souboru startv3.php i manualv3.php) se Vám v odpovědi vrátí applicationID a uloží se do souboru applicationID.php. 
- Spuštěním souboru applicationDetail.php se dotážete na stav žádosti, jejíž číslo je uloženo v souboru applicationID.txt.
- Nejdůležitější stav je Ready_to_ship, tedy Pokyn k vyskladnění. Pokud je stav Ready_to_ship, eshop může odeslat zboží klientovi.

### changeState.php
- Pouze pro integraci/testování - nelze použít pro produkci!
- Tato funkce slouží pouze pro posun stavu žádosti do potřebného stavu, proto si dobře rozmyslete, zda ji opravdu potřebujete. 
- Na train prostředí neodcházejí e-maily ani SMS.
- Funkci využijete pouze pro kontrolu příjmu notifikací po změně stavu žádosti
- Pokud chcete ověřit návrat na e-shop, postupujte jako klient
  - v prohlížeči zadejte rodné číslo 350101053
  - číslo účtu 123/0100
  - smlouvu podepište SMS kódem 12345
- Funkci můžete zavolat pouze až po vytvoření createApplication, pokud jste již udělali nějaké kroky jako klient, vyplňováním dotazníku, tak již funkce nemusí být dostupná nebo je její funkce zablokována (např. nesprávným formátem rodného čísla)
- Funkce má poměrně vysokou odezvu (v desítkách sekund), může dokonce překročit timeout a skončit chybou 500. Po jejím spuštění zavolejte funkci applicationDetail.php, aby jste si zkontrolovali skutečný stav žádosti, a zda tedy funkce udělala, co měla. Pokud Vám na Vaši žádost o schválení nebo překlopení do ready_to_ship vrátila stav Rejected, zkontrolujte, zda máte v žádosti (json) Příjmení=Trener. V takovém případě, prosím, kontaktujte Tomáše Bártu (kontakt níže)

### sendv3.php
- U objednávky, která je ve stavu ready_to_ship, potvrdí vyskladnění, tedy přepne do stavu ready_shipped 
                  

---
9.8.2019 Vytvořil Tomáš Bárta, tomas.barta@homecredit.cz, tel.: 602546502
                        
            
            
