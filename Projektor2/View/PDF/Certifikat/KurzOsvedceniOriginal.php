<?php
/**
* Description of
*
* @author pes2704
*/
class Projektor2_View_PDF_Certifikat_KurzOsvedceniOriginal extends Projektor2_View_PDF_Common {
    
    const MODEL_PLAN     = "plan";
    const MODEL_DOTAZNIK = "dotaznik";

    public function createPDFObject() {
        /** @var Projektor2_Model_Db_SKurz $sKurz */
        $sKurz = $this->context['sKurz'];
        /** @var Projektor2_Model_Db_CertifikatKurz $certifikat */
        $certifikat = $this->context['certifikat'];

        Projektor2_View_PDF_Certifikat_Content_KurzOsvedceni::prepareHeaderFooter(
                $this->sessionStatus, 
                $sKurz, 
                $certifikat, 
                $this->context['text_paticky'], 
                false);  
        $this->initialize();
        Projektor2_View_PDF_Certifikat_Content_KurzOsvedceni::createContent(
                $this->pdfRenderer, 
                $this->sessionStatus, 
                $sKurz, 
                $certifikat, 
                $this->context, 
                $this);
        //##################################################################################################
        $datumCertif = Projektor2_Date::createFromSqlDate($certifikat->date)->getCzechStringDate();        
        $this->tiskniMistoDatum($datumCertif);
        $this->pdfRenderer->Ln(20);
        $this->tiskniPodpisCertifikat();

    }
}
