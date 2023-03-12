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
     *
     * Jako hint se zobrazují původní data (z sheet) - jen pro zarovnané zobrazení trim
     *
     * @param type $phoneModel
     * @param type $phoneData
     */
    public function hydrate(&$phoneModel, &$phoneData) {
        $phoneModel = trim($phoneData, " \n\r\t\v\x00");
    }

    /**
     * Pro práci s daty - generuje hodnoty pro vyhledávání v datech - pro porovnávání
     *
     * Porovnávají se hodnoty (telefonní čísla) složené jen z číslic - jiné znaky mažu
     *
     * @param type $phoneModel
     * @param type $phoneData
     */
    public function extract(&$phoneModel, &$phoneData) {
        $phoneData = preg_replace('~\D~', '', $phoneModel);
    }
}
