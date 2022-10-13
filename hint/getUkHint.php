<?php
require __DIR__ . '/../vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;
use Pes\Debug\Table;

// configure the Google Client
$client = new Client();
$client->setApplicationName('Google Sheets API');
$client->setScopes([Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
// credentials.json is the key file we downloaded while setting up our Google Sheets API
$path = 'credentials.json';
$client->setAuthConfig($path);

// configure the Sheets Service
$service = new Sheets($client);

//https://docs.google.com/spreadsheets/d/1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s/edit?usp=sharing
$spreadsheetId = '1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s';
$spreadsheet = $service->spreadsheets->get($spreadsheetId);

$range = 'Odpovědi formuláře 2!M:M'; // the column
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues(); // array of arrays - dvourozměrné

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);

    $len=strlen($q);
    $cnt = 0;
    foreach($values as $rowArray) {
        if (isset($rowArray[0])) {  // není prázdná buňka
            $phone = $rowArray[0];
    $phone = trim($phone, "\n\r\t\v\x00");
    $phone = trim($phone, "+");
    $phone = trim($phone, "0");            
            // chování datalist:
            // zdá se, že Firefox napovídá hodnoty, které substring obsahují, zatímco Chrome, Opera, a další zobrazují je hodnoty, které substringem začínají
            // - pokud použiji variantu "začíná" - datalist se aktualizuje a i Firefox pak zobrazuje jen položky, kde začíná
            // - pokud použiji variantu "obsahuje" chová se v módu obsahuje jen Firefox (ostatní v datalistu stejně hledají jen položky. které začínají)
            // !! navíc pro variantu "obsahuje" stačí Firefoxu poslat datalist jen jednou (celý) při prvním znaku - pak už si FF vybírá sám
            // začíná
            if (stristr($q, substr($phone, 0, $len))) {
            //obsahuje
//            if (strpos($phone, $q) != false) {
                if ($hint === "") {
                    $hint = $phone;
                } else {
                    $hint .= ",$phone";
                }
                $cnt++;
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
