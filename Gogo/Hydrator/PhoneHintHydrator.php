<?php
namespace Gogo\Hydrator;

use Gogo\Hydrator\HydratorInterface;

/**
 * Description of HintHydrator
 *
 * @author pes2704
 */
class PhoneHintHydrator implements HydratorInterface {
    /**
     * Pro zobrazení - generuje hodnoty phone hintů
     * @param type $phoneModel
     * @param type $phoneData
     */
    public function hydrate(&$phoneModel, &$phoneData) {
        $phoneModel = trim($phoneData, " \n\r\t\v\x00");
    }

    /**
     * Pro práci s daty - generuje hodnoty pro vyhledávání v datech
     * @param type $phoneModel
     * @param type $phoneData
     */
    public function extract(&$phoneModel, &$phoneData) {
        $phoneData = $phoneModel;
    }
}
