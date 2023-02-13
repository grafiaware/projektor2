<?php
require __DIR__ . '/../vendor/autoload.php';

use Gogo\Service\Googlesheets;
use Gogo\Service\GoogleSheetsHelper;
use Gogo\Viewmodel\Person;
use Gogo\Hydrator\PersonHydrator;

try {
    // credentials.json is the key file we downloaded while setting up our Google Sheets API

    // Google disk Jana Nováková - Přihlášky na kurzy/Ukrajinci - Zájem o práci - v ukrajinštině (Odpovědi)
    //https://docs.google.com/spreadsheets/d/1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s/edit?usp=sharing
//    $config = [
//        'phone' => [
//            'path' => 'credentials.json',
//            'spreadsheetId' => '1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s',
//            'sheetName' => 'Odpovědi formuláře 2',
//            'range' => 'M:M', // sloupec telefon
//            'headersRowRange' => "A1:U1"
//            ],
//        'name' => [
//            'path' => 'credentials.json',
//            'spreadsheetId' => '1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s',
//            'sheetName' => 'Odpovědi formuláře 2',
//            'range' => 'J:J', // sloupec příjmení
//            'headersRowRange' => "A1:U1"
//            ],
//        ];

    // varianta:
    //
    // Ukrajinci - kurzy/ukrajinci registrace k veletrhu - s importem
    // https://docs.google.com/spreadsheets/d/1xn_qqmrG2Gb5E-5srfvR5qNRN7RFT10FPNcGzuX074w/edit#gid=1708155836&range=J1
    $config = [
        'phone' => [
            'path' => 'credentials.json',
            'spreadsheetId' => '1xn_qqmrG2Gb5E-5srfvR5qNRN7RFT10FPNcGzuX074w',
            'sheetName' => 'import odpovědí',
            'range' => 'M:M', // sloupec
            'headersRowRange' => "A1:U1"
            ],
        'name' => [
            'path' => 'credentials.json',
            'spreadsheetId' => '1xn_qqmrG2Gb5E-5srfvR5qNRN7RFT10FPNcGzuX074w',
            'sheetName' => 'import odpovědí',
            'range' => 'J:J', // sloupec
            'headersRowRange' => "A1:U1"
            ],
        'email' => [
            'path' => 'credentials.json',
            'spreadsheetId' => '1xn_qqmrG2Gb5E-5srfvR5qNRN7RFT10FPNcGzuX074w',
            'sheetName' => 'import odpovědí',
            'range' => 'N:N', // sloupec příjmení
            'headersRowRange' => "A1:U1"
            ],
        ];


    if (isset($_REQUEST["phone"])) {
        $type = 'phone';
        $needle = $_REQUEST["phone"];
    } elseif (isset($_REQUEST["name"])) {
        $type = 'name';
        $needle = $_REQUEST["name"];
    } elseif (isset($_REQUEST["email"])) {
        $type = 'email';
        $needle = $_REQUEST["email"];
    } else {
        throw new UnexpectedValueException("Chybný parametr hledání osoby.");
    }
    $googlesheetHelper = new GoogleSheetsHelper(new Googlesheets($config[$type]['path']));
    $headers = $googlesheetHelper->getRangeFirstRowValues($config[$type]['spreadsheetId'], $config[$type]['sheetName'], $config[$type]['headersRowRange']);  // první řádek rozsahu - řádek titulků

    $row = $googlesheetHelper->findNeedleRowIndexInColumn($config[$type]['spreadsheetId'], $config[$type]['sheetName'], $config[$type]['range'], $needle);
    if($row!==false) {
        $targetRowRange = "A$row:U$row";
        $rowValues = $googlesheetHelper->getRangeFirstRowValues($config[$type]['spreadsheetId'], $config[$type]['sheetName'], $targetRowRange); // první řádek rozsahu - řádek s

        $personHydrator = new PersonHydrator();
        $personViewmodel = new Person($personHydrator);
        $personViewmodel->setHeaders($headers);
        $personViewmodel->setResponseValues($rowValues);
        $json = $personViewmodel->getPersonJson();
    } else {
        $json = json_encode([["header"=>"No result", "value"=>"Nenalezena hodnota $needle v Google Sheet."]], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);  // JSON_UNESCAPED_UNICODE pro zobrazení v html;
    }
    echo $json;
} catch (\Exception $e) {
    $json = json_encode([["header"=>"ERROR", "value"=> $e->getMessage()]], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);  // JSON_UNESCAPED_UNICODE pro zobrazení v html;
    echo $json;
}