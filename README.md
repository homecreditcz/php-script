# Sada PHP scriptů pro jednoduché řešení klientské strany Home Credit API

> Nastaveno pro CZ train!!!

> Pro SK train změňte v souboru `optionv3.php` URL (`$url_base`) a měnu (`$mena`). Pokud chcete předávat klientem vybrané splátky z widget kalkulačky na vstupní bod MyLoan, pak upravte i sekci `$installment`.

Sada PHP skriptů slouží k vytvoření žádosti o financování nákupu (*createApplication*) skrz Home Creditem vystavené REST API. Sada zajišťuje komunikaci zabezpečenou pomocí OAuth2 tokenu (autentizace) a odeslání dat POST dotazy.

## Zpracování chybových stavů
Jde o třetí verzi skriptů (proto *...v3*), kde se již využívá příkazu `curl`, který umožňuje zobrazit chybové stavy:
- `422 - DUPLICATE_ORDER_NUMBER` = duplikované číslo objednávky ==> změňte číslo objednávky v `json.php`
- `422 - APPLICATION_REJECTED` = nepovolená operace, nelze stornovat zamítnutou žádost
- `404 - PAGE_NOT_FOUND` = train prostředí může mít krátkodobé výpadky z přetížení ==> odešlete žádost opakovaně v anonymním okně prohlížeče pomocí CTRL+F5 nebo zavřete a znovu otevřete prohlížeč (chyby se ukládají v cache prohlížeče a prohlížeč ji zobrazuje i v případě, že jste zdroj opravili)
- `400 - BAD_REQUEST` = nevalidní request, patrně jste chybně upravili `json.php` ==> použijte zdrojový

## Základní zdrojové skripty

### optionv3.php
- Pomocný soubor, kde se specifikuje základní nastavení pro bezproblémový chod skriptu
  - Adresa `$url_base` pro jednotlivá prostředí (CZtrain, SKtrain, CZprodukce, SKprodukce)
  - Volí se měna CZK/EUR
  - Specifikuje se `$username` a `$password`

### tokenv3.php
- Pomocný soubor k vygenerování OAuth2 access tokenu

### startv3.php
- Automatické vygenerování žádosti
- Vytvoří se token, provolá se *createApplication* a klient je přesměrován na stránku MyLoan, kde dochází ke kalkulaci úvěru

### manualv3.php
- Manuální vygenerování žádosti, po kterém nedojde k přesměrování do prostředí MyLoan
- Používá se, pokud chcete klientům zobrazit sumář objednávky (na odkaz si již musí kliknout klient sám), případně doplníte automatickým přesměrováním po xx vteřinách

### json.php
- Zdrojová data pro provedení `startv3.php`, která zasíláte do HC aplikace - MyLoan.
- Zde si upravujete číslo objednávky, data o klientovi a zboží
- Můžete si zde případně i nastavit klientem preferované splátky, které jste si uložili z widget kalkulačky v detailu produktu - *Toto neplatí pro eshopy v režimu Tipař - tito mohou použít pouze kalkulačku Standalone, která údaje o klientem preferované variantě nepřenáší.*

## Rozšiřující zdrojové skripty
Následující funkce nemusíte nutně použít. Stavy se e-shopům zobrazují v obslužné aplikaci Webclient.

### applicationDetail.php
- Používá se k doptávání na aktuální stav žádosti skrz její identifikátor `applicationId`
  -  `applicationId` se vám vrátí v odpovědi *createApplication* (tedy provedením souboru `startv3.php` či `manualv3.php`) a uloží se do pomocného souboru `applicationID.txt`  
- Provedením `applicationDetail.php` se dotážete na stav žádosti, jejíž číslo je uloženo v souboru `applicationID.txt`
- Nejdůležitější stav je `READY_TO_SHIP`, tedy *Pokyn k vyskladnění*. Pokud je stav `READY_TO_SHIP`, e-shop může expedovat zboží klientovi.

### changeState.php
- Pouze pro integraci/testování - **nelze použít pro produkci!**
- Tento skript slouží pouze pro posun stavu žádosti do potřebného stavu. Reálně jej tedy využijete především pro kontrolu příjmu notifikací po změně stavu žádosti, proto si dobře rozmyslete, zda jej opravdu potřebujete.
- Na train prostředí neodcházejí e-maily ani SMS
- Pokud chcete ověřit návrat na e-shop, postupujte jako klient
  - v prohlížeči zadejte rodné číslo 350101053
  - číslo účtu 123/0100
  - smlouvu podepište SMS kódem ***123456***
- Tento skript je možné provést jedině až po vytvoření žádosti (*createApplication*), pokud jste již provedli nějaké kroky jako klient (vyplňováním dotazníku v prostředí MyLoan), tak již tato funkce nemusí být dostupná nebo je dokonce zablokována (např. zadáním rodného čísla v nesprávém formátu)
- Tento skript má poměrně vysokou odezvu (v desítkách sekund), může dokonce překročit timeout a skončit chybou `500`. Po jeho provedení zavolejte funkci `applicationDetail.php`, abyste si zkontrolovali skutečný stav žádosti, a zda tedy došlo k jeho požadovanému posunu.
- Pokud se Vám na Vaši žádost o schválení nebo překlopení do `READY_TO_SHIP` vrátil stav `REJECTED`, zkontrolujte, zda máte v žádosti (`json.php`) příjmení ***Trener*** (`"lastName": "Trener"`). V takovém případě, prosím, kontaktujte Tomáše Bártu (kontakt níže)

### sendv3.php
- U žádosti, která je ve stavu `READY_TO_SHIP`, potvrdí vyskladnění, tedy přepne do stavu `READY_SHIPPED`
> **POZOR: Nelze kombinovat s `deliverv3.php`** - jedná se o jiný proces vyskladnění ==> musíte si tedy vybrat, zda zboží označíte za odeslané (**`sendv3.php`**), nebo jako doručené (`deliverv3.php`)

### deliverv3.php
- U žádosti, která je ve stavu `READY_TO_SHIP`, potvrdí doručení klientovi, tedy přepne do stavu `READY_DELIVERED`
> **POZOR: Nelze kombinovat se `sendv3.php`** - jedná se o jiný proces vyskladnění ==> musíte si tedy vybrat, zda zboží označíte za odeslané (`sendv3.php`), nebo jako doručené (**`deliverv3.php`**)

### cancelv3.php
- Stornuje nezamítnutou žádost (nesmí být ve stavu `REJECTED`), a podle původního stavu přepne do `CANCELLED_NOT_PAID` (dokud nebyla žádost proplacena), nebo `CANCELLED_RETURNED` (po proplacení žádosti).
- Umožňuje specifikovat důvod stornování žádosti

### json_cancel.php
- Zdrojová data pro provedení `cancelv3.php` s uvedením důvodu storna (nepovinné).
- Zde můžete specifikovat jeden z předdefinovaných důvodů stornování žádosti, případně použít volnou textaci obecného důvodu


---
9.8.2019 Vytvořil Tomáš Bárta, tomas.barta@homecredit.cz, tel.: 602546502
6.11.2019 Upravil Jakub Klos, jakub.klos@homecredit.cz
