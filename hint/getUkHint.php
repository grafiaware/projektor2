<?php
require __DIR__ . '/../vendor/autoload.php';

use Gogo\Service\Googlesheets;
use Gogo\Service\GoogleSheetsHelper;
use Gogo\Viewmodel\Hint;
use Gogo\Hydrator\PhoneHintHydrator;
use Gogo\Hydrator\NameHintHydrator;
use Gogo\Hydrator\EmailHintHydrator;

try {
    // credentials.json is the key file we downloaded while setting up our Google Sheets API

    // Google disk Jana Nováková - Přihlášky na kurzy/Ukrajinci - Zájem o práci - v ukrajinštině (Odpovědi)
    //https://docs.google.com/spreadsheets/d/1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s/edit?usp=sharing
//    $config = [
//        'phone' => [
//            'path' => 'credentials.json',
//            'spreadsheetId' => '1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s',
//            'sheetName' => 'Odpovědi formuláře 2',
//            'range' => '!M:M', // sloupec telefon
//            ],
//        'name' => [
//            'path' => 'credentials.json',
//            'spreadsheetId' => '1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s',
//            'sheetName' => 'Odpovědi formuláře 2',
//            'range' => 'J:J', // sloupec příjmení
//            ],
//        ];

    // varianta:
    //
    // Ukrajinci - kurzy/ukrajinci registrace k veletrhu - s importem
    // https://docs.google.com/spreadsheets/d/1xn_qqmrG2Gb5E-5srfvR5qNRN7RFT10FPNcGzuX074w/edit#gid=1708155836&range=J1
//    $config = [
//        'range' => 'Odpovědi formuláře 2!M:M', // sloupec telefon
//    ];
    $config = [
        'phone' => [
            'path' => 'credentials.json',
            'spreadsheetId' => '1xn_qqmrG2Gb5E-5srfvR5qNRN7RFT10FPNcGzuX074w',
            'sheetName' => 'import odpovědí',
            'range' => 'M:M', // sloupec
            ],
        'name' => [
            'path' => 'credentials.json',
            'spreadsheetId' => '1xn_qqmrG2Gb5E-5srfvR5qNRN7RFT10FPNcGzuX074w',
            'sheetName' => 'import odpovědí',
            'range' => 'J:J', // sloupec
            ],
        'email' => [
            'path' => 'credentials.json',
            'spreadsheetId' => '1xn_qqmrG2Gb5E-5srfvR5qNRN7RFT10FPNcGzuX074w',
            'sheetName' => 'import odpovědí',
            'range' => 'N:N', // sloupec
            ],
        ];

    // get
    $type = $_REQUEST["type"];
    $q = $_REQUEST["q"];

//    $hint = "";

    // lookup all hints from array if $q is different from ""
    $googlesheetHelper = new GoogleSheetsHelper(new Googlesheets($config[$type]['path']));
    $haystackColumnValues = $googlesheetHelper->getRangeFirstColumnValues($config[$type]['spreadsheetId'], $config[$type]['sheetName'], $config[$type]['range']);
    switch ($type) {
        case 'phone':
            $hintHydrator = new PhoneHintHydrator();
            break;
        case 'name':
            $hintHydrator = new NameHintHydrator();
            break;
        case 'email':
            $hintHydrator = new EmailHintHydrator();
            break;
        default:
            break;
    }

    $hintViewmodel = new Hint($hintHydrator);
    $hintViewmodel->setResponseValues($haystackColumnValues);
    $csvHints = $hintViewmodel->getHintAsCsv($q);

    // Output "no suggestion" if no hint was found or output correct values
    echo $csvHints === "" ? "no suggestion" : $csvHints;
} catch (\Exception $e) {
    echo $e->getMessage();
}