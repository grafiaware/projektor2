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
     * @param type $range
     * @return array - array of arrays - dvourozměrné číselné pole, první index řádky, druhý index sloupce
     */
    public function getRangeValues($spreadsheetId, $range) {
        $sheets = $this->googlesheetsService->getSheets();
        $response =
                $sheets->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues(); // array of arrays - dvourozměrné
    }

    /**
     *
     * @param type $spreadsheetId
     * @param type $range
     * @return array číselné pole hodnot prvního řádku rozsahu
     */
    public function getRangeFirstRowValues($spreadsheetId, $range) {
        $sheets = $this->googlesheetsService->getSheets();
        $response =
                $sheets->spreadsheets_values->get($spreadsheetId, $range);
        // $response->getValues() vrací array of arrays - dvourozměrné, první prvek je první řádek
        return $response->getValues()[0];
    }
}
