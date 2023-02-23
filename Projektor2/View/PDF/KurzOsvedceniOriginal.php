<?php
/**
* Description of
*
* @author pes2704
*/
class Projektor2_View_PDF_KurzOsvedceniOriginal extends Projektor2_View_PDF_Common {
    
    const MODEL_PLAN     = "plan";
    const MODEL_DOTAZNIK = "dotaznik";

    public function createPDFObject() {  //Projektor2_Model_Db_Projekt $projekt
        $this->setHeaderFooter($this->context['text_paticky'], FALSE);
        $this->initialize();
        //*****************************************************
        $odsazeniPozadiShora = 28;
        $vyskaObrazku = 287;
        $sirkaObrazku = 210;
        $vyska = 297-$odsazeniPozadiShora;
        $pomer = $vyska/$vyskaObrazku;
        $sirka = $sirkaObrazku*$pomer;
        $odsazeniZleva = ($sirkaObrazku-$sirka)/2;
        $this->pdf->Image(Config_Certificates::getCertificateoriginalBackgroundImageFilepath($this->sessionStatus), $odsazeniZleva, $odsazeniPozadiShora, $sirka, $vyska);

        Projektor2_View_PDF_Helper_KurzOsvedceni::createContent($this->pdf, $this->context, $this);
        //##################################################################################################
        $datumCertif = Projektor2_Date::createFromSqlDate($this->context['certifikat']->date)->getCzechStringDate();
        $this->tiskniMistoDatum(self::MODEL_DOTAZNIK, $datumCertif);
        $this->pdf->Ln(20);
        $this->tiskniPodpisCertifikat();

    }
}
