<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Cizinec extends Projektor2_Controller_Formular_FlatTable {

    private $typeCollection;
    private $uploadCollection;


    const ZA_UPLOAD = 'za_upload';
    const ZA_UPLOAD_TYPE = 'za_upload_type';

    protected function createFormModels() {
        $flatTablesMainObject = $this->getStatusMainObject();
        $this->models[Projektor2_Controller_Formular_FlatTable::CIZINEC_FT] = new Projektor2_Model_Db_Flat_ZaCizinecFlatTable($flatTablesMainObject);
        $this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT] = new Projektor2_Model_Db_Flat_ZaFlatTable($flatTablesMainObject);
        $this->models[self::ZA_UPLOAD] = Projektor2_Model_Db_ZaUploadMapper::findByZajemce($this->sessionStatus->getUserStatus()->getZajemce()->id);
        $this->models[self::ZA_UPLOAD_TYPE] = Projektor2_Model_Db_ZaUploadTypeMapper::findAll();

    }

    public function getResult() {
        $htmlResult = '';
        $idZajemce = $this->sessionStatus->getUserStatus()->getZajemce()->id;
        // modely
        $this->createFormModels();  // pokud není $this->sessionStatus->getUserStatus()->getZajemce() vytvoří při volání flat table->save() nový zájemce
        // kolekce
        // indexované podle typu uploadu
        foreach ($this->models[self::ZA_UPLOAD_TYPE] as $zaUploadType) {
            $this->typeCollection[$zaUploadType->type] = $zaUploadType;
        }
        foreach ($this->models[self::ZA_UPLOAD] as $zaUpload) {
            $this->uploadCollection[$idZajemce.'-'.$zaUpload->id_upload_type_FK] = $zaUpload;
        }

        // POST
        if ($this->request->isPost()) {
            $this->setModelsFromPost($this->request->postArray());
            // ukládání dat modelů flat table
            $this->saveFlatTableModels();

            // ukládání uploadu
            $fileBaseFolder = Config_AppContext::getFileBaseFolder();
            $uploadedFolderPath =
                    Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod)
                    .'upload/';
            $osobaFolder =
                    $this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT]->prijmeni
                    .' '.$this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT]->jmeno
                    .' - '.$this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT]->id_zajemce;

            $saved = $this->saveUploadedFiles($fileBaseFolder, $uploadedFolderPath.$osobaFolder.'/', true);  // true = expanduj do podadresářů podle typu uploadu

            // update & create
            foreach ($saved as $uploadType => $uploadedFilefullFilepath) {
                if (array_key_exists($uploadType, $this->typeCollection)) {
                    $persistedUpload = $this->uploadCollection[$idZajemce.'-'.$uploadType];
                    if (isset($persistedUpload)) {
                       $persistedUpload->filename = $uploadedFilefullFilepath;
            //
//                                    ?? updated
//                                    - při update smazat soubor?
                        Projektor2_Model_Db_ZaUploadMapper::update($persistedUpload);
                    } else {
                        // nový model do kolekce (nep
                        $this->uploadCollection[$uploadType] = Projektor2_Model_Db_ZaUploadMapper::create(
                                $this->sessionStatus->getUserStatus()->getZajemce()->id, $uploadType,
                                $uploadedFilefullFilepath,
                                $this->sessionStatus->getUserStatus()->getUser()->name, __CLASS__, Config_AppContext::getDb()->getDbHost()
                            );
                    }
                }
            }
        }

        // formulář
        $htmlResult .= $this->formular();
        // javascript pro stažení pdf
        if ($this->request->isPost() AND ($this->request->post('T1') OR $this->request->post('pdf'))) {
            $htmlResult .= $this->getResultPdf();
        }
        return $htmlResult;
    }

    protected function formular() {
        $context = $this->createContextFromModels(true);
        $idZajemce = $this->sessionStatus->getUserStatus()->getZajemce()->id;
        $context['faze'] =
            [
                "Žádost na ÚP - registrace zájemce"=>"Žádost na ÚP - registrace zájemce",
                "Zájemce o zaměstnání"=>"Zájemce o zaměstnání",
                "Žádost na ÚP - registrace uchazeč"=>"Žádost na ÚP - registrace uchazeč",
                "Uchazeč o zaměstnání"=>"Uchazeč o zaměstnání",
            ];
        $contextRegistrace = [
                [
                    'zaUploadType'=>$this->typeCollection['registrace zájemce'],
                    'zaUpload'=>$this->uploadCollection[$idZajemce.'-'.'registrace zájemce'],
                    'datum_reg_name'=>'datum_reg_zadost_zajemce',
                    'datum_reg_text'=>'Datum žádosti o registraci zájemce na ÚP'
                ],
                [
                    'datum_reg_name'=>'datum_reg_zajemce',
                    'datum_reg_text'=>'Datum registrace zájemce na ÚP'
                ],
                [
                    'zaUploadType'=>$this->typeCollection['registrace uchazeč'],
                    'zaUpload'=>$this->uploadCollection[$idZajemce.'-'.'registrace uchazeč'],
                    'datum_reg_name'=>'datum_reg_zadost_uchazec',
                    'datum_reg_text'=>'Datum žádosti o registraci uchazeče na ÚP'
                ],
                [
                    'datum_reg_name'=>'datum_reg_uchazec',
                    'datum_reg_text'=>'Datum registrace uchazeče na ÚP'
                ]
            ];
        $contextRekvalifikace = [
                [
                    'zaUploadType'=>$this->typeCollection['rekvalifikace zájemce'],
                    'zaUpload'=>$this->uploadCollection[$idZajemce.'-'.'rekvalifikace zájemce'],
                    'datum_reg_name'=>'datum_rk_zadost_1',
                    'datum_reg_text'=>'Datum zájmu o rekvalifikaci na ÚP'
                ],
                [
                    'zaUploadType'=>$this->typeCollection['rekvalifikace uchazeč'],
                    'zaUpload'=>$this->uploadCollection[$idZajemce.'-'.'rekvalifikace uchazeč'],
                    'datum_reg_name'=>'datum_rk_zadost_2',
                    'datum_reg_text'=>'Datum zájmu o rekvalifikaci na ÚP'
                ],
            ];

        $view = new Projektor2_View_HTML_Formular_Cizinec($this->sessionStatus, $context);

        $viewRegistrace = new Projektor2_View_HTML_RegistraceUP($this->sessionStatus, $context);
        $viewRegistrace->assign("registrace", $contextRegistrace);
        $view->assign("registrace_up", $viewRegistrace->render());
        $viewRegistrace->assign("registrace", $contextRekvalifikace);
        $view->assign("rekvalifikace_up", $viewRegistrace->render());

        $htmlResult = $view->render();
        return $htmlResult;
    }

    protected function getResultPdf() {
        $view = new Projektor2_View_PDF_Cjc_Smlouva($this->sessionStatus, $this->createContextFromModels());

        $view->assign('kancelar_plny_text', $this->sessionStatus->getUserStatus()->getKancelar()->plny_text);
        $view->assign('user_name', $this->sessionStatus->getUserStatus()->getUser()->name);
        $view->assign('identifikator', $this->sessionStatus->getUserStatus()->getZajemce()->identifikator);

        $fileName = $this->sessionStatus->getUserStatus()->getProjekt()->kod.'_'.'smlouva'.' '.$this->sessionStatus->getUserStatus()->getZajemce()->identifikator.'.pdf';
        $view->assign('file', $fileName);

        $relativeFilePath = Config_AppContext::getRelativeFilePath($this->sessionStatus->getUserStatus()->getProjekt()->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult = $view->getNewWindowOpenerCode();

        return $htmlResult;
    }

}

