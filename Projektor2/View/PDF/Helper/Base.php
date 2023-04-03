<?php
/**
 * Description of Base
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Helper_Base {
    // formát řetězce obsahujícího datum pro MySQL, shodný s formátem dle RFC3339
    const SQL_FORMAT = "Y-m-d";
    const CS_FORMAT = "d.m.Y";
    const CS_FORMAT_BEZ_NUL = "j. n. Y";

    protected static function celeJmeno(Projektor2_Model_Db_Flat_ZaFlatTable $modelSmlouva) {   //--vs
        $celeJmeno = $modelSmlouva->titul." ".$modelSmlouva->jmeno." ".$modelSmlouva->prijmeni;
        if ($modelSmlouva->titul_za) {
            $celeJmeno = $celeJmeno.", ".$modelSmlouva->titul_za;
        }
        return $celeJmeno;
    }

    protected static function celaAdresa($ulice='', $mesto='', $psc='') {
        if ($ulice) {
            $celaAdresa .= $ulice;
            if  ($mesto) {
                $celaAdresa .=  ", ".$mesto;
            }
            if  ($psc) {
                $celaAdresa .= ", ".$psc;
            }
        } else {
            if  ($mesto)  {
                $celaAdresa .= $mesto;
                if  ($psc) {
                    $celaAdresa .= ", " .$psc;
                }
            } else {
                if  ($psc) {
                    $celaAdresa .= $psc;
                }
            }
        }
        return $celaAdresa;
    }

    protected static function datumBezNul($datum) {
        $datum = DateTime::createFromFormat(self::SQL_FORMAT, $datum);
        if($datum==false) {
            $datum = DateTime::createFromFormat(self::CS_FORMAT, $datum);
        }
        return $datum->format(self::CS_FORMAT_BEZ_NUL);
    }

}
