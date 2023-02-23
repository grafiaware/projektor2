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

    private $mainObjectMapperClassName = Projektor2_Model_Db_ZajemceMapper::class;

    private $statusMainObject;

    public function __construct(Projektor2_Model_Status $sessionStatus, Projektor2_Request $request, Projektor2_Response $response, array $params = []) {
        parent::__construct($sessionStatus, $request, $response, $params);
        if($this->sessionStatus->getUserStatus()->getZajemce()) {
            $this->setStatusMainObject($this->sessionStatus->getUserStatus()->getZajemce());
        }
    }

    public function getResult() {
        $htmlResult = '';

        if ($this->request->isPost()) {
            $fileBaseFolder = Config_AppContext::getFileBaseFolder();
            $uploadedFolderPath =
                    Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod)
                    .'filesUpload/';
            $this->saveUploadedFiles($fileBaseFolder, $uploadedFolderPath);
            // ukládání dat modelů flat table
            $this->createFormModels();  // pokud není $this->sessionStatus->getUserStatus()->getZajemce() vytvoří při volání flat table->save() nový zájemce
            $this->setModelsFromPost($this->request->postArray());
            $this->saveFlatTableModels();
        } else { // request == GET
            $this->createFormModels();  // pokud není $this->sessionStatus->getUserStatus()->getZajemce() vytvoří při volání flat table->save() nový zájemce
        }

        // formulář
        $htmlResult .= $this->getResultFormular();
        // javascript pro stažení pdf
        if ($this->request->isPost() AND ($this->request->post('T1') OR $this->request->post('pdf'))) {
            $htmlResult .= $this->getResultPdf();
        }
        return $htmlResult;
    }

#### abstract methods #####################################

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

#### protected methods #####################################

    protected function setStatusMainObject(Framework_Model_DbItemAbstract $mainObject) {
        $this->statusMainObject = $mainObject;
    }

    /**
     *
     * @return Framework_Model_DbItemAbstract|null
     */
    protected function getStatusMainObject() {
        return $this->statusMainObject;
    }

    protected function createStatusMainObject() {
        $mapperClassName = $this->mainObjectMapperClassName;
        $mainObject = $mapperClassName::create();
        $this->setStatusMainObject($mainObject);
        return $mainObject;
    }

    protected function saveFlatTableModels() {
        if ($this->sessionStatus->getUserStatus()->getUser()->povolen_zapis) {
            if ($this->getStatusMainObject()===null) {
                $mainObject = $this->createStatusMainObject();  // proběhne insert do databáze do tabulky hlavního objektu
                $this->sessionStatus->getUserStatus()->setZajemce($mainObject);
                foreach ($this->models as $model) {
                    if ($model instanceof Framework_Model_CollectionFlatTable OR $model instanceof Framework_Model_ItemFlatTable) {
                        // zde se nastaví hlavní objekt (např. zajemce) k flat table (např. za_flat_table), ktera nema hlavní objekt
                        // v případě, že model flat table toto chování umožňuje - nastaveno pro ten formulář, který má mít funkci založení nového hlavního objektu
                        // (to je nastaveno v konstruktoru konkrétní flat table)
                        $model->setMainObject($mainObject);
                    }
                }
            }
            foreach ($this->models as $model) {
                if ($model instanceof Framework_Model_CollectionFlatTable) {
                    // zde se vytvoří hlavní objekt (např. zajemce) k flat table (např. za_flat_table), ktera nema hlavní objekt
                    // v případě, že model flat table toto chování umožňuje - nastaveno pro ten formulář, který má mít funkci založení nového hlavního objektu
                    // (to je nastaveno v konstruktoru konkrétní flat table)
                    $model->save();
                    if ($model->isCreatedNewMainObject()) {
                        $zajemce = $model->getMainObject();
                        $this->sessionStatus->getUserStatus()->setZajemce($zajemce);
                    }
                } elseif ($model instanceof Framework_Model_ItemFlatTable) {
                    // zde se vytvoří hlavní objekt (např. zajemce) k flat table (např. za_flat_table), ktera nema hlavní objekt
                    // v případě, že model flat table toto chování umožňuje - nastaveno pro ten formulář, který má mít funkci založení nového hlavního objektu
                    // (to je nastaveno v konstruktoru konkrétní flat table)
                    $model->save();
                    if ($model->isCreatedNewMainObject()) {
                        $zajemce = $model->getMainObject();
                        $this->sessionStatus->getUserStatus()->setZajemce($zajemce);
                    }
                }
            }
        }
    }


}

