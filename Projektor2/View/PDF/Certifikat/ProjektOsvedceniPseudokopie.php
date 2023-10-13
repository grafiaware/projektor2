<?php
/**
* Description of
*
* @author pes2704
*/
class Projektor2_View_PDF_Certifikat_ProjektOsvedceniPseudokopie extends Projektor2_View_PDF_Common {
    const MODEL_DOTAZNIK = "dotaznik";
    const MODEL_UKONCENI = "ukonceni";

    public function createPDFObject() {
        $this->createHeaderFooter($this->sessionStatus->getUserStatus()->getProjekt(), $this->context, FALSE);
        $this->initialize();
        Projektor2_View_PDF_Certifikat_Content_ProjektOsvedceni::createContent($this->pdfRenderer, $this->sessionStatus, $this->context, $this);
        //##################################################################################################
        /** @var Projektor2_Model_Db_CertifikatProjekt $certifikat */
        $certifikat = $this->context['certifikat'];
        $datumCertif = Projektor2_Date::createFromSqlDate($certifikat->date)->getCzechStringDate(); 
        $this->tiskniMistoDatum($datumCertif);
        $this->pdfRenderer->Ln(20);
        $this->tiskniPodpisCertifikat();
    }
}
?>
