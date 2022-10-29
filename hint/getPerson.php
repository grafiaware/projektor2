<?php
require __DIR__ . '/../vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;
use Pes\Debug\Table;

use Gogo\Service\Googlesheets;
use Gogo\Service\GoogleSheetsHelper;

function findPersons($googlesheetHelper, $needle, $spreadsheetId, $range) {
    $headersRowRange = "Odpovědi formuláře 2!A1:U1";
    $headers = $googlesheetHelper->getRangeFirstRowValues($spreadsheetId, $headersRowRange);  // první řádek rozsahu
    $haystackColumnValues = $googlesheetHelper->getRangeValues($spreadsheetId, $range);

    $arrayPerson = [];
    foreach($haystackColumnValues as $index => $rowArray) {
        if (isset($rowArray[0])) {  // není prázdná buňka
            $value = $rowArray[0];
            if ($value==$needle) {
                $row = $index+1;
                $targetRowRange = "Odpovědi formuláře 2!A$row:U$row";
                $rowValues = $googlesheetHelper->getRangeFirstRowValues($spreadsheetId, $targetRowRange);  // první řádek rozsahu
                foreach ($headers as $col => $header) {
                    if (array_key_exists($col, $rowValues)) {
                        $arrayPerson[] = ["header"=>$header, "value"=>$rowValues[$col]];
                    } else {
                        $arrayPerson[] = ["header"=>$header, "value"=>"-----"];
                    }
                }
            }
        }
    }
    return $arrayPerson;
}

try {
    // credentials.json is the key file we downloaded while setting up our Google Sheets API
    $path = 'credentials.json';  // relativní k tomuto skriptu
    $spreadsheetId = '1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s';

    $googlesheetHelper = new GoogleSheetsHelper(new Googlesheets($path));

    $requestedPhone = isset($_REQUEST["phone"]) ? $_REQUEST["phone"] : '';
    $requestedName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
    if ($requestedPhone) {
        $transform = function(&$phone) {  // musí předávat referencí
            $phone = trim($phone, "+");
            $phone = trim($phone, "0");
            $phone = trim($phone, " \n\r\t\v\x00");
        };
        $googlesheetHelper = new GoogleSheetsHelper(new Googlesheets($path), $transform);
        $range = 'Odpovědi formuláře 2!M:M'; // sloupec telefon
        $arrayPerson = findPersons($googlesheetHelper, $requestedPhone, $spreadsheetId, $range);
    } elseif ($requestedName) {
        $transform = function(&$name) {  // musí předávat referencí
            $name = trim($name, " \n\r\t\v\x00");
        };
        $googlesheetHelper = new GoogleSheetsHelper(new Googlesheets($path), $transform);
        $range = 'Odpovědi formuláře 2!J:J'; // sloupec příjmení
        $arrayPerson = findPersons($googlesheetHelper, $requestedName, $spreadsheetId, $range);
    } else {
        throw new UnexpectedValueException("Chybný parametr hledání osoby.");
    }


    $jsonPerson = json_encode($arrayPerson, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);  // JSON_UNESCAPED_UNICODE pro zobrazení v html
    echo $jsonPerson;
} catch (\Exception $e) {
    $json = json_encode([["header"=>"ERROR", "value"=> $e->getMessage()]], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);  // JSON_UNESCAPED_UNICODE pro zobrazení v html;
    echo $json;
}