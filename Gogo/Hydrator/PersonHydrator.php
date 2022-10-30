<?php
namespace Gogo\Hydrator;

use Gogo\Hydrator\HydratorInterface;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of HintHydrator
 *
 * @author pes2704
 */
class PersonHydrator implements HydratorInterface {
    /**
     * Pro zobrazení - generuje hodnoty pro zobrazení person
     * @param type $personModel
     * @param type $personData
     */
    public function hydrate(&$personModel, &$personData) {
        ;
    }

    /**
     * Pro práci s daty - generuje hodnoty pro vyhledávání v datech
     * @param type $personModel
     * @param type $personData
     */
    public function extract(&$personModel, &$personData) {
        ;
    }
}
