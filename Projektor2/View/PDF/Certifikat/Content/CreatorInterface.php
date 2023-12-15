<?php
use Pdf\Renderer\Renderer;


/**
 *
 * @author pes2704
 */
interface Projektor2_View_PDF_Certifikat_Content_CreatorInterface {
    
    public static function prepareHeaderFooter(
            Projektor2_Model_Status $sessionStatus,            
            Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan, 
            Projektor2_Model_Db_CertifikatKurz $certifikat,             
            $context, 
            $cislovani=TRUE
        );
    
    public static function createContent(
            Renderer $pdf, 
            Projektor2_Model_Status $sessionStatus,            
            Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan, 
            Projektor2_Model_Db_CertifikatKurz $certifikat, 
            $context, 
            $caller, 
            $radkovani=1            
            );
}
