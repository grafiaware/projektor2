<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of KurzOsvedceni
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Certifikat_HeaderFooter_KurzOsvedceniMonitoring extends Projektor2_View_PDF_Certifikat_HeaderFooter_BaseAbstract {
    public static function createHeaderFooterOsvedceniKurzMonitoring(
            Projektor2_Model_Db_Projekt $projekt, 
            Projektor2_Model_Db_SKurz $sKurz, 
            $textPaticky=NULL, 
            $cislovani=TRUE
        ) {
        switch ($projekt->kod) {

            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CKP':
            case 'PKP':
                self::completeHeader("./img/loga/loga_OP_Z&UP_PMS_BW.jpg", 5, 15, 110, 16, 'L');
                self::completeFooter( $textPaticky, $cislovani);
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - nanastaveno HeaderFooter pro projekt.');
                break;
        }
    }

}
