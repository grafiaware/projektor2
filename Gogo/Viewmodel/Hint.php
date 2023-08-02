<?php
namespace Gogo\Viewmodel;

//use Google\Service\Sheets\ValueRange;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Hint
 *
 * @author pes2704
 */
class Hint extends ViewmodelAbstract {

    private $values;

    public function setResponseValues(array $values) {
        $this->values = $values;
    }

    public function getHintAsCsv(string $query) {
        if (!$this->values) {
            throw new LogicException("Nejsou zadány response values.");
        }
        $hint = [];
        if ($query !== "") {
            $this->viewHydrator->extract($query, $q);
            $len=strlen($q);
            foreach($this->values as $rowArray) {
                if (isset($rowArray)) {  // není prázdná buňka
                     $this->viewHydrator->extract($rowArray, $value);
                    // chování datalist:
                    // pokud pošlu datalist (options) ken při prvním znaku, pak prohlížeče při psaní dalších znaků vybírají z již zaslaného datalistu
                    // zdá se, že Firefox napovídá hodnoty, které substring obsahují, zatímco Chrome, Opera, a další zobrazují jen hodnoty, které substringem začínají
                    //
                    // javascriptem generuji vždy nový seznam options pro datalist - tím se překryje chování prohlížečů
                    // začíná
//                    if (stristr($q, substr($value, 0, $len))) {
                    //obsahuje
                    if (is_string($value) AND is_string($q) AND $q AND strpos($value, $q) !== false) {
                        $hintValue = "";
                        $this->viewHydrator->hydrate($hintValue, $rowArray);
                        $hint[] = $hintValue;
                    }
                }
            }
        }

        return implode(",", $hint);

    }
}
