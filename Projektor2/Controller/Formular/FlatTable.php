<?php

use Pes\Utils\Directory;

/**
 * Description of Projektor2_Controller_Formular_Base
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_FlatTable extends Projektor2_Controller_Formular_Base {

    const PLAN_FT = 'planFT';
    const DOTAZNIK_FT = 'dotaznikFT';
    const PLAN_KURZ = 'planKurz';
    const UKONC_FT = 'ukoncFT';
    const ZAM_FT = 'zamFT';
    const CIZINEC_FT = 'cizinecFT';

    /**
     * Potomkovské třídy musí implementovat matodu getResultFormular, která vrací html kód vlastního formuláře
     */
    abstract protected function getResultFormular();

    /**
     * Potomkovské třídy musí implementovat metodu getResultPdf, která vytvoří pdf dokument a vrátí kód
     * pro zobrazení pdf dokumentu v novém panelu prohlížeče.
     * Pokud k formuláři není přisružen pdf dokument, bude taková metoda prázdná.
     */
    abstract protected function getResultPdf();  // TODO - viz tot v kontroleru - všechna vytváření pdf so service, zbytek z getResultPdf do getResultFormular a ten přejmenovat na getResult

    public function getResult() {
        $htmlResult = '';

        if ($this->request->isPost()) {
            $uploadedFolderPath = "filesUploadFromProjektor/";
            $this->saveUploadedFiles($uploadedFolderPath);
            // ukládání dat modelů flat table
            $this->createFormModels();  // pokud není $this->sessionStatus->zajemce vytvoří při volání flat table->save() nový zájemce
            $this->setModelsFromPost($this->request->postArray());
            $this->saveFlatTableModels();
        } else { // request == GET
            $this->createFormModels();  // pokud není $this->sessionStatus->zajemce vytvoří při volání flat table->save() nový zájemce
        }

        // formulář
        $htmlResult .= $this->getResultFormular();
        // javascript pro stažení pdf
        if ($this->request->isPost() AND ($this->request->post('T1') OR $this->request->post('pdf'))) {
            $htmlResult .= $this->getResultPdf();
        }
        return $htmlResult;
    }

    protected function saveFlatTableModels() {
        if ($this->sessionStatus->user->povolen_zapis) {
            foreach ($this->models as $model) {
                if ($model instanceof Framework_Model_CollectionFlatTable) {
                    // zde se vytvoří hlavní objekt (např. zajemce) k flat table (např. za_flat_table), ktera nema hlavní objekt
                    // v případě, že model flat table toto chování umožňuje - nastaveno pro ten formulář, který má mít funkci založení nového hlavního objektu
                    // (to je nastaveno v konstruktoru konkrétní flat table)
                    $model->save();
                    if ($model->isCreatedNewMainObject()) {
                        $zajemce = $model->getMainObject();
                        $this->sessionStatus->setZajemce($zajemce);
                    }
                } elseif ($model instanceof Framework_Model_ItemFlatTable) {
                    // zde se vytvoří hlavní objekt (např. zajemce) k flat table (např. za_flat_table), ktera nema hlavní objekt
                    // v případě, že model flat table toto chování umožňuje - nastaveno pro ten formulář, který má mít funkci založení nového hlavního objektu
                    // (to je nastaveno v konstruktoru konkrétní flat table)
                    $model->save();
                    if ($model->isCreatedNewMainObject()) {
                        $zajemce = $model->getMainObject();
                        $this->sessionStatus->setZajemce($zajemce);
                    }
                }
            }
        }
    }


}
