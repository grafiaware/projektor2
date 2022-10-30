<?php
namespace Gogo\Hydrator;
use Gogo\Hydrator\HydratorInterface;

/**
 * Description of HintHydrator
 *
 * @author pes2704
 */
class NameHintHydrator implements HydratorInterface {
    /**
     * Pro zobrazení - generuje hodnoty name hintů
     * @param type $nameModel
     * @param type $nameData
     */
    public function hydrate(&$nameModel, &$nameData) {
        $nameModel = ucwords(trim($nameData, " \n\r\t\v\x00"));
    }

    /**
     * Pro práci s daty - generuje hodnoty pro vyhledávání v datech
     * @param type $nameModel
     * @param type $nameData
     */
    public function extract(&$nameModel, &$nameData) {
        $nameData = strtolower($nameModel);
    }
}
