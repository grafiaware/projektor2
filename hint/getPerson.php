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

$spreadsheetId = '1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s';
$spreadsheet = $service->spreadsheets->get($spreadsheetId);

$range = 'Odpovědi formuláře 2!M:M'; // the column
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues(); // array of arrays - dvourozměrné

// get the q parameter from URL
$sendedPhone = $_REQUEST["phone"];
$arrayPerson = [];
$headersRowRange = "Odpovědi formuláře 2!A1:U1";
$response = $service->spreadsheets_values->get($spreadsheetId, $headersRowRange);
$headers = $response->getValues()[0]; // array of arrays - dvourozměrné
foreach($values as $index => $rowArray) {
    if (isset($rowArray[0])) {  // není prázdná buňka
        $phone = $rowArray[0];
        if ($phone==$sendedPhone) {
            $row = $index+1;
            $targetRowRange = "Odpovědi formuláře 2!A$row:U$row";
            $response = $service->spreadsheets_values->get($spreadsheetId, $targetRowRange);
            $rowValues = $response->getValues()[0]; // array of arrays - dvourozměrné
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
// Output "no suggestion" if no hint was found or output correct values
//var_dump($arrayPerson);

$jsonPerson = json_encode($arrayPerson, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);  // JSON_UNESCAPED_UNICODE pro zobrazení v html
echo $jsonPerson;