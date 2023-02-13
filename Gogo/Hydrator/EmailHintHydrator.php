<?php
namespace Gogo\Hydrator;
use Gogo\Hydrator\HydratorInterface;

/**
 * Description of HintHydrator
 *
 * @author pes2704
 */
class EmailHintHydrator implements HydratorInterface {
    
    /**
     * Pro zobrazení - generuje hodnoty hintů
     * @param type $nameModel
     * @param type $nameData
     */
    public function hydrate(&$nameModel, &$nameData) {
        $nameModel = strtolower(trim($nameData, " \n\r\t\v\x00"));
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
