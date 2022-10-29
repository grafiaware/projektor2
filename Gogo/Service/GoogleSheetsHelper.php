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

    private $valueTransform;

    public function __construct(Googlesheets $googlesheetsService, \Closure $valueTransform=null) {
        $this->googlesheetsService = $googlesheetsService;
        $this->valueTransform = $valueTransform;
    }

    /**
     *
     * @param array $values Předává referencí
     */
    private function transformValues(array $values) {
        if (isset($this->valueTransform)) {
            array_walk_recursive($values, $this->valueTransform);
        }
        return $values;
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
        return $this->transformValues($response->getValues()); // array of arrays - dvourozměrné
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
        return $this->transformValues($response->getValues()[0]);
    }
}
