<?php
/**
* Description of
*
* @author pes2704
*/
class Projektor2_View_PDF_Certifikat_KurzOsvedceniPms extends Projektor2_View_PDF_Common {

    const MODEL_PLAN     = "plan";
    const MODEL_DOTAZNIK = "dotaznik";

    public function createPDFObject() {  //Projektor2_Model_Db_Projekt $projekt
        /** @var Projektor2_Model_Db_SKurz $sKurz */
        $sKurz = $this->context['sKurz'];
        /** @var Projektor2_Model_Db_CertifikatKurz $certifikat */
        $certifikat = $this->context['certifikat'];

        Projektor2_View_PDF_Certifikat_HeaderFooter_KurzOsvedceniMonitoring::createHeaderFooterOsvedceniKurzMonitoring(
                $this->pdfCreator, 
                $this->sessionStatus->getUserStatus()->getProjekt(), 
                $sKurz, 
                $certifikat, 
                $this->context['text_paticky'], 
                false);          
        $this->initialize();
        Projektor2_View_PDF_Certifikat_Content_KurzOsvedceniPMS::createContent(
                $this->pdfCreator, 
                $this->context, 
                $this);
        $datumCertif = Projektor2_Date::createFromSqlDate($certifikat->date)->getCzechStringDate();
        $this->tiskniMistoDatumPms($datumCertif);
        $this->pdfCreator->Ln(20);
//        $this->tiskniPodpisCertifikat();

    }
}
