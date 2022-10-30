<?php
namespace Gogo\Service;

use Gogo\Service\Googlesheets;


/**
 * Description of GoogleSheetHelper
 *
 * @author pes2704
 */
class GoogleSheetsHelper {

    private $googlesheetsService;

    public function __construct(Googlesheets $googlesheetsService) {
        $this->googlesheetsService = $googlesheetsService;
    }

    /**
     *
     * @param type $spreadsheetId
     * @param type $sheetName
     * @param type $cellRange
     * @return array - array of arrays - dvourozměrné číselné pole, první index řádky, druhý index sloupce
     */
    public function getRangeValues($spreadsheetId, $sheetName, $cellRange) {
        $sheets = $this->googlesheetsService->getSheets();
        $response = $sheets->spreadsheets_values->get($spreadsheetId, $this->range($sheetName, $cellRange));
        return $response->getValues(); // array of arrays - dvourozměrné
    }

    /**
     *
     * @param type $spreadsheetId
     * @param type $range
     * @return array číselné pole hodnot prvního řádku rozsahu
     */
    public function getRangeFirstRowValues($spreadsheetId, $sheetName, $cellRange) {
        $sheets = $this->googlesheetsService->getSheets();
        $response = $sheets->spreadsheets_values->get($spreadsheetId, $this->range($sheetName, $cellRange));
        // $response->getValues() vrací array of arrays - dvourozměrné, první prvek je první řádek
        return $response->getValues()[0];
    }

    public function getRangeFirstColumnValues($spreadsheetId, $sheetName, $cellRange) {
        $sheets = $this->googlesheetsService->getSheets();
        $response = $sheets->spreadsheets_values->get($spreadsheetId, $this->range($sheetName, $cellRange));
        // $response->getValues() vrací array of arrays - dvourozměrné, první index je řádek
        foreach ($response->getValues() as $row) {
            $ret[] = $row[0];
        }
        return $ret;
    }

    public function findNeedleRowIndexInColumn($spreadsheetId, $sheetName, $cellRange, $needle) {
        $haystackColumnValues = $this->getRangeFirstColumnValues($spreadsheetId, $sheetName, $cellRange);
        return array_search($needle, $haystackColumnValues)+1;
    }

    private function range($sheetName, $cellRange) {
        return $sheetName.'!'.$cellRange;
    }
}
