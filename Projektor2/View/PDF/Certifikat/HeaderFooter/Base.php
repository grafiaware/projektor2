<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Base
 *
 * @author pes2704
 */
abstract class Projektor2_View_PDF_Certifikat_HeaderFooter_BaseAbstract {
    protected static function completeHeader($logoFileName=NULL, $x, $y, $sirka, $vyska, $zarovnani='C' ) {
        $pdfhlavicka = Projektor2_PDF_Factory::getHlavicka();
        $pdfhlavicka->zarovnani($zarovnani);
        $pdfhlavicka->vyskaPisma(14);
        if (isset($logoFileName)) {
            if (is_readable($logoFileName)) {
                $pdfhlavicka->obrazek($logoFileName, $x, $y, $sirka, $vyska);
            } else {
                throw new UnexpectedValueException('Zadán neexistující soubor s obrázkem do hlavičky dokumentu: '.$logoFileName.'.');
            }
        }
    }
    
    protected static function completeFooter( $textPaticky=NULL, $cislovani=TRUE) {
        $pdfpaticka = Projektor2_PDF_Factory::getPaticka();
        if ($textPaticky) {
            $pdfpaticka->Odstavec($textPaticky);
        }
        $pdfpaticka->zarovnani("C");
        $pdfpaticka->vyskaPisma(6);
        $pdfpaticka->cislovani = $cislovani;
        $pdfpaticka->OdsazeniDole(13);
    }}
