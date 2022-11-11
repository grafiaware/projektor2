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
        $this->models[self::ZA_UPLOAD] = Projektor2_Model_Db_ZaUploadMapper::findByZajemce($this->sessionStatus->zajemce->id);
        $this->models[self::ZA_UPLOAD_TYPE] = Projektor2_Model_Db_ZaUploadTypeMapper::findAll();

    }

    public function getResult() {
        $htmlResult = '';
        $idZajemce = $this->sessionStatus->zajemce->id;
        // modely
        $this->createFormModels();  // pokud není $this->sessionStatus->zajemce vytvoří při volání flat table->save() nový zájemce
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
            $uploadedFolderPath =
                    Projektor2_AppContext::getFileBaseFolder()
                    .Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod)
                    .'upload/';
            $osobaFolder =
                    $this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT]->prijmeni
                    .' '.$this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT]->jmeno
                    .' - '.$this->models[Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT]->id_zajemce;
            $saved = $this->saveUploadedFiles($uploadedFolderPath.$osobaFolder.'/', true);  // expanduj do podadresářů podle tyou uploadu

            // update & create
            foreach ($saved as $uploadType => $fileName) {
                if (array_key_exists($uploadType, $this->typeCollection)) {
                    $persistedUpload = $this->uploadCollection[$idZajemce.'-'.$uploadType];
                    if (isset($persistedUpload)) {
                        $persistedUpload->filename = $fileName;
//                                    ?? updated
//                                    - při update smazat soubor?
                        Projektor2_Model_Db_ZaUploadMapper::update($persistedUpload);
                    } else {
                        // nový model do kolekce (nep
                        $this->uploadCollection[$uploadType] = Projektor2_Model_Db_ZaUploadMapper::create(
                                $this->sessionStatus->zajemce->id, $uploadType,
                                $fileName,
                                $this->sessionStatus->user->name, __CLASS__, Projektor2_AppContext::getDb()->getDbHost()
                            );
                    }
                }
            }
        }

        // formulář
        $htmlResult .= $this->getResultFormular();
        // javascript pro stažení pdf
        if ($this->request->isPost() AND ($this->request->post('T1') OR $this->request->post('pdf'))) {
            $htmlResult .= $this->getResultPdf();
        }
        return $htmlResult;
    }

    protected function getResultFormular() {
        $context = $this->createContextFromModels(true);
        $idZajemce = $this->sessionStatus->zajemce->id;
        $context['faze'] =
            [
                "Žádost na ÚP - registrace zájemce"=>"Žádost na ÚP - registrace zájemce",
                "Zájemce o zaměstnání"=>"Zájemce o zaměstnání",
                "Žádost na ÚP - registrace uchazeč"=>"Žádost na ÚP - registrace uchazeč",
                "Uchazeč o zaměstnání"=>"Uchazeč o zaměstnání",
            ];
        $contextRegistrace = [
                [
                    'zaUploadType'=>$this->typeCollection['registrace zájemce'], 'zaUpload'=>$this->uploadCollection[$idZajemce.'-'.'registrace zájemce'],
                    'datum_reg_name'=>'datum_reg_zadost_zajemce', 'datum_reg_text'=>'Datum žádosti o registraci zájemce na ÚP'
                ],
                [
                    'datum_reg_name'=>'datum_reg_zajemce', 'datum_reg_text'=>'Datum registrace zájemce na ÚP'
                ],
                [
                    'zaUploadType'=>$this->typeCollection['registrace uchazeč'], 'zaUpload'=>$this->uploadCollection[$idZajemce.'-'.'registrace uchazeč'],
                    'datum_reg_name'=>'datum_reg_zadost_uchazec', 'datum_reg_text'=>'Datum žádosti o registraci uchazeče na ÚP'
                ],
                [
                    'datum_reg_name'=>'datum_reg_uchazec', 'datum_reg_text'=>'Datum registrace uchazeče na ÚP'
                ]
            ];
        $contextRekvalifikace = [
                [
                    'zaUploadType'=>$this->typeCollection['rekvalifikace zájemce'], 'zaUpload'=>$this->uploadCollection[$idZajemce.'-'.'rekvalifikace zájemce'],
                    'datum_reg_name'=>'datum_rk_zadost_1', 'datum_reg_text'=>'Datum zájmu o rekvalifikaci na ÚP'
                ],
                [
                    'zaUploadType'=>$this->typeCollection['rekvalifikace uchazeč'], 'zaUpload'=>$this->uploadCollection[$idZajemce.'-'.'rekvalifikace uchazeč'],
                    'datum_reg_name'=>'datum_rk_zadost_2', 'datum_reg_text'=>'Datum zájmu o rekvalifikaci na ÚP'
                ],
            ];

        $view = new Projektor2_View_HTML_Formular_Cizinec($this->sessionStatus, $context);
        $ukHintHtml = (new Projektor2_View_HTML_Cjc_HintView($this->sessionStatus, $context))->render();
        $view->assign("uk_hint_fieldset", $ukHintHtml);
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

        $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text);
        $view->assign('user_name', $this->sessionStatus->user->name);
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);

        $fileName = $this->sessionStatus->projekt->kod.'_'.'smlouva'.' '.$this->sessionStatus->zajemce->identifikator.'.pdf';
        $view->assign('file', $fileName);

        $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult = $view->getNewWindowOpenerCode();

        return $htmlResult;
    }

}

