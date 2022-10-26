<?php
require __DIR__ . '/../vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;
use Pes\Debug\Table;

use Gogo\Service\Googlesheets;
use Gogo\Service\GoogleSheetsHelper;

function hintPhone(string $q, $haystackColumnValues) {
    $hint = "";
    if ($q !== "") {

        $q = strtolower($q);
        $len=strlen($q);

        $cnt = 0;
        foreach($haystackColumnValues as $rowArray) {
            if (isset($rowArray[0])) {  // není prázdná buňka
                $phone = $rowArray[0];
                $phone = trim($phone, "\n\r\t\v\x00");
                $phone = trim($phone, "+");
                $phone = trim($phone, "0");
                // chování datalist:
                // zdá se, že Firefox napovídá hodnoty, které substring obsahují, zatímco Chrome, Opera, a další zobrazují jen hodnoty, které substringem začínají
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

    return $hint;
}

function hintName(string $q, $haystackColumnValues) {
    $hint = "";
    if ($q !== "") {

        $q = strtolower($q);
        $len=strlen($q);

        $cnt = 0;
        foreach($haystackColumnValues as $rowArray) {
            if (isset($rowArray[0])) {  // není prázdná buňka
                // porovnává převedené na malá písmena
                $name = strtolower($rowArray[0]);
                $name = trim($name, "\n\r\t\v\x00");

                // chování datalist:
                // zdá se, že Firefox napovídá hodnoty, které substring obsahují, zatímco Chrome, Opera, a další zobrazují jen hodnoty, které substringem začínají
                // - pokud použiji variantu "začíná" - datalist se aktualizuje a i Firefox pak zobrazuje jen položky, kde začíná
                // - pokud použiji variantu "obsahuje" chová se v módu obsahuje jen Firefox (ostatní v datalistu stejně hledají jen položky. které začínají)
                // !! navíc pro variantu "obsahuje" stačí Firefoxu poslat datalist jen jednou (celý) při prvním znaku - pak už si FF vybírá sám
                // začíná
                if (stristr($q, substr($name, 0, $len))) {
                //obsahuje
    //            if (strpos($phone, $q) != false) {
                    // do hintu dává s prvním velkým písmenem
                    if ($hint === "") {
                        $hint = ucwords($name);
                    } else {
                        $hint .= ",".ucwords($name);
                    }
                    $cnt++;
                }
            }
        }
    }

    return $hint;
}

try {
    // credentials.json is the key file we downloaded while setting up our Google Sheets API
    $path = 'credentials.json';

    // Google disk Jana Nováková - Přihlášky na kurzy/Ukrajinci - Zájem o práci - v ukrajinštině (Odpovědi)
    //https://docs.google.com/spreadsheets/d/1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s/edit?usp=sharing
    $spreadsheetId = '1MdLN_bZz3Loa5vMsq7NqkzBlbfxFbrSuEzmK39yh99s';

    $googlesheetHelper = new GoogleSheetsHelper(new Googlesheets($path));

    // get
    $type = $_REQUEST["type"];
    $q = $_REQUEST["q"];

    $hint = "";

    // lookup all hints from array if $q is different from ""
    switch ($type) {
        case "phone":
            $range = 'Odpovědi formuláře 2!M:M'; // sloupec telefon
            $haystackColumnValues = $googlesheetHelper->getRangeValues($spreadsheetId, $range);
            $hint = hintPhone($q, $haystackColumnValues);
            break;
        case "name":
            $range = 'Odpovědi formuláře 2!J:J'; // sloupec příjmení
            $haystackColumnValues = $googlesheetHelper->getRangeValues($spreadsheetId, $range);
            $hint = hintName($q, $haystackColumnValues);
            break;
        default:
            break;
    }

    // Output "no suggestion" if no hint was found or output correct values
    echo $hint === "" ? "no suggestion" : $hint;
} catch (\Exception $e) {
    echo $e->getMessage();
}