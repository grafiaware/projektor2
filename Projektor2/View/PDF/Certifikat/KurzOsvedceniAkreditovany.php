<?php

use Config\Certificates;

/**
* Description of
*
* @author pes2704
*/
class Projektor2_View_PDF_Certifikat_KurzOsvedceniAkreditovany extends Projektor2_View_PDF_Common {

    const MODEL_PLAN     = "plan";
    const MODEL_DOTAZNIK = "dotaznik";

    public function createPDFObject() {
        /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
        $aktivitaPlan = $this->context['aktivitaPlanViewModel'];
        /** @var Projektor2_Model_Db_SKurz $sKurz */
        $sKurz = $aktivitaPlan->sKurz;
        /** @var Projektor2_Model_Db_CertifikatKurz $certifikat */
        $certifikat = $this->context['certifikat'];

        Projektor2_View_PDF_Certifikat_Content_KurzOsvedceniAkreditovany::prepareHeaderFooter(
                $this->sessionStatus, 
                $aktivitaPlan, 
                $certifikat, 
                $this->context, 
                false);  
        $this->initialize();
        Projektor2_View_PDF_Certifikat_Content_KurzOsvedceniAkreditovany::createContent(
                $this->pdfRenderer, 
                $this->sessionStatus, 
                $aktivitaPlan, 
                $certifikat, 
                $this->context, 
                $this, 
                0.6);
        //##################################################################################################
        $datumCertif = Projektor2_Date::createFromSqlDate($certifikat->date)->getCzechStringDate();        
        $this->tiskniMistoDatum($datumCertif);
        $this->pdfRenderer->Ln(1);
        
        //TODO: SV - dočasné řešení - přepínám podle existence garanta lurzu v s_kurz
        if ($aktivitaPlan->sKurz->kurz_garant) {
            Projektor2_View_PDF_Certifikat_Content_KurzOsvedceniAkreditovany::createSigns(
                $this->pdfRenderer, 
                $aktivitaPlan,
                Config_Certificates::getCertificateStatutoryRepresentative($this->sessionStatus)
                );
        } else {
            $this->tiskniPodpisCertifikat();
        }

    }
}
