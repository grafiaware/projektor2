<?php
/**
* Description of
*
* @author pes2704
*/
class Projektor2_View_PDF_KurzOsvedceniPms extends Projektor2_View_PDF_Common {

    const MODEL_PLAN     = "plan";
    const MODEL_DOTAZNIK = "dotaznik";

    public function createPDFObject() {  //Projektor2_Model_Db_Projekt $projekt
        $this->setHeaderFooterPms($this->context['text_paticky'], FALSE);
        $this->initialize();
        //*****************************************************
        $odsazeniPozadiShora = 0;
        $vyskaObrazku = 297;
        $sirkaObrazku = 210;
        $vyska = 297-$odsazeniPozadiShora;
        $pomer = $vyska/$vyskaObrazku;
        $sirka = $sirkaObrazku*$pomer;
        $odsazeniZleva = ($sirkaObrazku-$sirka)/2;
        $this->pdf->Image(Projektor2_AppContext::getCertificatePmsBackgroundImageFilepath($this->sessionStatus), $odsazeniZleva, $odsazeniPozadiShora, $sirka, $vyska);

        Projektor2_View_PDF_Helper_KurzOsvedceniPMS::createContent($this->pdf, $this->context, $this);
        //##################################################################################################
        $datumCertif = Projektor2_Date::createFromSqlDate($this->context['certifikat']->date)->getCzechStringDate();
        $this->tiskniMistoDatumPms(self::MODEL_DOTAZNIK, $datumCertif);
        $this->pdf->Ln(20);
//        $this->tiskniPodpisCertifikat();

    }
}
