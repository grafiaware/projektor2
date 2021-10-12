<?php
/**
 * Description of TransformingClosureContainer
 *
 * @author pes2704
 */
class Transformer_TransformingClosureContainer {
    /**
     * Vrací closure, která transformuje datum ve formátu RFC s pomlčkami (RRRR-MM-DD) na české datumy (DD.MM.RRRR)
     * Closure přijímá jen jeden paranetr, string k transformaci a vrací transformovaný string.
     * @return Closure
     */
    public static function DatumRfcToCzech() {
        return function($value) {
            $datetime = DateTime::createFromFormat('Y-m-d', $value);
            if ($datetime) {
                return $datetime->format('j.n.Y');
            } else {
                throw new UnexpectedValueException('Chybný vstupní formát datumu RFC: '.$value);
            }            
        };
    }

    /**
     * Vrací closure, která transformuje datum ve formátu českého datumu (DD.MM.RRRR nebo D.M.RRRR) na RFC s pomlčkami (RRRR-MM-DD),
     * akceptuje den a měsíc s počátečními nulami i bez nich.
     * Closure přijímá jen jeden paranetr, string k transformaci a vrací transformovaný string.
     * @return Closure
     */
    public static function DatumCtechToRfc() {
        return function($value) {
            $datetime = DateTime::createFromFormat('j.n.Y', $value);
            if ($datetime) {
                return $datetime->format('Y-m-d');
            } else {
                throw new UnexpectedValueException('Chybný vstupní formát čského datumu: '.$value);
            }            
        };
    }
}

//            $patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/');
//            $replace = array ('\4.\3.\1\2');
//            
//            $s1 = preg_replace($patterns, $replace, $value);
//            $s2 = preg_replace('/0(\d{1})\.(19|20)(\d{2})/', '\1.\2\3', $s1);        
//            $s3 = preg_replace('/0(\d{1})\.(\d{1,2})\.(19|20)(\d{2})/', '\1.\2.\3\4', $s2);
//            return $s3;
            
            //return str_replace('.0', '.', preg_replace($patterns, $replace, $value));
