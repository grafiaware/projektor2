<?php

/**
 * Funkční, ale nepoužité - pouze pro inspiraci pro transformaci db
 * 
 * Potomek Framework_Model_DbItemAbstract. Provádí transformaci datumů mezi databází a objektem.
 * Sloupce obsahující datum poznává pomocí metody jeToProjektoroveDatum().
 * 
 * Při hydrataci obsah sloupců obsahujících projektorové datum transformuje z formátu českého data do RFC (YYYY-MM-DD).
 * Při save vlasnoti objektu flattable transformuje z RFC na české datum.
 *
 * @author pes2704
 */
class Projektor2_Model_Db_Flat_TransformItemFlatTable extends Framework_Model_ItemFlatTable {
    
    
    
    protected function hydrate() {
        if (!$this->isHydrated) {   // hydrate se volá opakovaně pro stejný objekt - pak by metoda toCzech vyhazovala výjimky - datumy v atributech už jsou RFC
            parent::hydrate();
            $this->transformAttributeslToRfc();
        }
    }
    
    public function save() {
        $this->transformChangedToCzech();
        parent::save();
    }
    
    protected function transformChangedToCzech() {
        foreach ($this->changed as $key => $value) {
            // nezkouší měnit hodnotu primárního klíče
            if ($key != $this->primaryKeyColumnName AND $this->jeToProjektoroveDatum($key) AND $value) {      
                $newValue = $this->toCzech($value);
                if ($newValue != $value) {      // mění vlastnost modelu jen pokud nová hodnota je odlišná od staré
                    $this->changed[$key] = $newValue;
                }
            }           
        }
    }
    
    protected function transformAttributeslToRfc() {
        foreach ($this->attributes as $key => $value) {
            // nezkouší měnit hodnotu primárního klíče
            if ($key != $this->primaryKeyColumnName AND $this->jeToProjektoroveDatum($key) AND $value) {      
                $newValue = $this->toRfc($value);
                if ($newValue != $value) {      // mění vlastnost modelu jen pokud nová hodnota je odlišná od staré
                    $this->attributes[$key] = $newValue;
                }
            }          
        }
    } 
    
    /**
     * Název sloupce obsahuje substring datum_
     * @param type $columnName
     * @return type
     */
    private function jeToProjektoroveDatum($columnName) {
        return strpos($columnName, 'datum_')!==FALSE ? TRUE : FALSE;
    }
    
    private function toCzech($value) {
        $datetime = DateTime::createFromFormat('Y-m-d', $value);
        if ($datetime) {
            return $datetime->format('j.n.Y');
        } else {
            throw new UnexpectedValueException('Chybný vstupní formát datumu RFC: '.$value);
        } 
    }
    
    private function toRfc($value) {
        // opraví chyby v datech projektoru - vynechá mezery mezi čísly vzniklé v době před používáním datepickeru
        $value = preg_replace('/\s+/', '', $value);
        $datetime = DateTime::createFromFormat('j.n.Y', $value);
        if ($datetime) {
            return $datetime->format('Y-m-d');
        } else {
            throw new UnexpectedValueException('Chybný vstupní formát českého datumu: '.$value.'. Objekt '.get_called_class().', id '.$this->id);
        }        
    }
}
