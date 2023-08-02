<?php
class Projektor2_Controller_Export_Excel extends Projektor2_Controller_Abstract {

    const SELECT_NAME = 'export';
    /**
     * Prefix jména vytvářených view v databázi
     */
    const CREATED_VIEW_PREFIX = 'export_excel_';

    public function getResult() {
        if ($this->request->isPost()) {
            $parts = $this->performPost();
        } else {
            $kodProjektu = $this->sessionStatus->getUserStatus()->getProjekt()->kod;
            $exportType = $this->params['export_type'] ?? null;

            $exportSelectView = new Projektor2_View_HTML_ExportSelectView($this->sessionStatus);

            switch ($exportType) {
                case 'kurzy':
                    $selectModel = new Projektor2_Viewmodel_Element_Select(
                        self::SELECT_NAME,
                        [
                            ''=>'',
                            'kurzy v projektu'=>'template|kurzy projekt',
                            'kurzy v kanceláři'=>'template|kurzy kancelar',
                            'certifikáty v projektu'=>'template|certifikaty projekt',
                            'aktivity v projektu'=>'template|aktivity projekt',
                        ]
                    );
                    $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::FORM_ACTION, "index.php?akce=kurzy&kurzy=excel");
                    $menuArray[] = ['href'=>'index.php?akce=kurzy&kurzy=seznam', 'text'=>'Zpět na seznam kurzů'];
                    break;
                case 'kurz':
                    $selectModel = new Projektor2_Viewmodel_Element_Select(
                        self::SELECT_NAME,
                        [
                            ''=>'',
                            'účastníci kurzu'=>'template|ucastnici',
                            'certifikáty v kurzu'=>'template|certifikaty kurz'
                        ]
                    );
                    $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::FORM_ACTION, "index.php?akce=kurzy&kurzy=kurz&kurz=excel");
                    $menuArray[] = ['href'=>'index.php?akce=kurzy&kurzy=kurz&kurz=ucastnici_kurzu', 'text'=>'Zpět na seznam účastníků'];
                    break;
                case 'osoby':
                    switch ($kodProjektu) {
                        case 'CJC':
                            $selectModel = new Projektor2_Viewmodel_Element_Select(
                                self::SELECT_NAME,
                                [
                                    ''=>'',
                                    'cizinci v projektu'=>'template|cizinci projekt'
                                ]
                            );
                            $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::FORM_ACTION, "index.php?akce=osoby&osoby=excel");
                            $menuArray[] = ['href'=>'index.php?akce=osoby&osoby=seznam', 'text'=>'Zpět na seznam osob'];
                            break;
                        default:
                            $selectModel = new Projektor2_Viewmodel_Element_Select(
                                self::SELECT_NAME,
                                [
                                    ''=>'',
                                    'osoby v projektu'=>'template|osoby projekt',
                                    'osoby v kanceláři'=>'template|osoby kancelar',
                                    'zaměstnaní v projektu'=>'template|zamstnani projekt',
                                ]
                            );
                            $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::FORM_ACTION, "index.php?akce=osoby&osoby=excel");
                            $menuArray[] = ['href'=>'index.php?akce=osoby&osoby=seznam', 'text'=>'Zpět na seznam osob'];
                            break;
                    }
            }
            $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::SELECT_MODEL, $selectModel);
            $parts[] = $exportSelectView;

            $subgridColumn[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$menuArray]);
            $subgridColumn[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$parts, 'class'=>'content']);
            return new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$subgridColumn, 'class'=>'grid-container']);
        }
    }

    private function performPost() {
        if($this->request->post(self::SELECT_NAME)) {
            list($type, $name) = explode('|', $this->request->post(self::SELECT_NAME));
            if ($type) {
                switch ($type) {
                    case 'table':
                        $parts[] = $this->exportFromView($name);
                        break;
                    case 'template':
                        $parts[] = $this->exportByTemplate($name);
                        break;
                    default:
                        throw new UnexpectedValueException("Neznámá hodnota typu exportu v post datech.");
                }
            }
        }

        return $parts ?? [];
    }

    private function templateParams($exportTemplateName) {

//            'jméno parametrů' => [
//                    'sqlFilename' => 'jméno souboru sql template.sql',
//                    'createdViewPostfix' => 'přípona názvu view vytvářeného v databázi',
//                    'xlsSheetName' => "jméno souboru excel bez přípony"],
//                    'params' => "další parametry do template"
        $templateParams = [
                'osoby projekt' => [
                    'sqlFilename' => __DIR__."/Templates/Osoby_projekt.sql",
                    'createdViewPostfix' => 'osoby_projekt',
                    'xlsSheetName' => "Osoby {$this->sessionStatus->getUserStatus()->getProjekt()->kod}"
                    ],
                'osoby kancelar' => [
                    'sqlFilename' => __DIR__."/Templates/Osoby_kancelar.sql",
                    'createdViewPostfix' => 'osoby_kancelar',
                    'xlsSheetName' => "Osoby {$this->sessionStatus->getUserStatus()->getKancelar()->kod}"
                    ],
                'cizinci projekt'=> [
                    'sqlFilename' => __DIR__."/Templates/Cizinci_projekt.sql",
                    'createdViewPostfix' => 'cizinci_projekt',
                    'xlsSheetName' => 'CJC osoby'
                    ],
                'ucastnici'=> [
                    'sqlFilename' => __DIR__."/Templates/Ucastnici_kurzu.sql",
                    'createdViewPostfix' => 'ucastnici',
                    'xlsSheetName' => 'Účastníci kurzu'
                    ],
                'kurzy projekt' => [
                    'sqlFilename' => __DIR__."/Templates/Kurzy_projekt.sql",
                    'createdViewPostfix' => 'kurzy_projekt',
                    'xlsSheetName' => "Kurzy {$this->sessionStatus->getUserStatus()->getProjekt()->kod}",
                    'params' => ['projektKod'=>$this->sessionStatus->getUserStatus()->getProjekt()->kod]  // v s_kurz je projekt_kod (ne id)
                    ],
                'kurzy kancelar' => [
                    'sqlFilename' => __DIR__."/Templates/Kurzy_kancelar.sql",
                    'createdViewPostfix' => 'kurzy_kancelar',
                    'xlsSheetName' => "Kurzy {$this->sessionStatus->getUserStatus()->getKancelar()->kod}",
                    'params' => ['kancelarKod'=>$this->sessionStatus->getUserStatus()->getKancelar()->kod]  // v s_kurz je kancelar_kod (ne id)
                    ],
                'certifikaty projekt' => [
                    'sqlFilename' => __DIR__."/Templates/Certifikaty_projekt.sql",
                    'createdViewPostfix' => 'certifikaty_projekt',
                    'xlsSheetName' => "Certifikaty {$this->sessionStatus->getUserStatus()->getProjekt()->kod}"
                    ],
                'certifikaty kurz' => [
                    'sqlFilename' => __DIR__."/Templates/Certifikaty_kurz.sql",
                    'createdViewPostfix' => 'certifikaty_kurz',
                    'xlsSheetName' => "Certifikaty {$this->sessionStatus->getUserStatus()->getSKurz()->kurz_druh}"
                    ],
                'aktivity projekt' => [
                    'sqlFilename' => __DIR__."/Templates/Aktivity_projekt.sql",
                    'createdViewPostfix' => 'aktivity_projekt',
                    'xlsSheetName' => "Aktivity {$this->sessionStatus->getUserStatus()->getProjekt()->kod}"
                    ],
                'zamstnani projekt' => [
                    'sqlFilename' => __DIR__."/Templates/Zamestnani_projekt.sql",
                    'createdViewPostfix' => 'zamestnani_projekt',
                    'xlsSheetName' => "Zaměstnaní {$this->sessionStatus->getUserStatus()->getProjekt()->kod}"
                    ],
                ];
        if (!array_key_exists($exportTemplateName, $templateParams)) {
                throw new UnexpectedValueException("Neznámá hodnota parametru 'template' $exportTemplateName");
        }
        return $templateParams[$exportTemplateName];
    }

    private function exportFromView($sqlView) {
        $modelExcel = Projektor2_Model_File_ExcelMapper::createFromView($sqlView);
        if (Projektor2_Model_File_ExcelMapper::save($modelExcel, $this->sessionStatus)) {
            $downloadController = new Projektor2_Controller_ForcedDownload();
            // Projektor2_Controller_ForcedDownload->download končí příkazem exit, ukončí běh skriptu
            $downloadController->download($modelExcel->documentFileName);
        } else {
            return new Projektor2_View_HTML_ErrorExportExcel($this->sessionStatus);
        }
    }

    private function exportByTemplate($exportTemplateName) {

        $templateObject = new Projektor2_Controller_Export_SqlTemplate_SqlTemplate($this->sessionStatus, $this->request);
        $tplParams = $this->templateParams($exportTemplateName);
        $sql = $templateObject->getTemplate($tplParams['sqlFilename'], $tplParams['params'] ?? []);
        if ($sql) {
            $sqlView = Projektor2_Model_File_ExcelMapper::createViewFromSql(self::CREATED_VIEW_PREFIX.$tplParams['createdViewPostfix'], $sql);
            $modelExcel = Projektor2_Model_File_ExcelMapper::createFromView($sqlView, $tplParams['xlsSheetName'], $templateObject->getUsedParams());
            return $this->saveAsExcelAndForceDownload($modelExcel);  // vynutí download nebo vrací chybové HTML view
        }
    }

    /**
     * Odešle response vynucující download, pokud nastane chaby vrací HTML view s hlášením.
     *
     * @param Projektor2_Model_File_Excel $modelExcel
     * @return \Projektor2_View_HTML_ErrorExportExcel
     */
    private function saveAsExcelAndForceDownload(Projektor2_Model_File_Excel $modelExcel) {
        if (Projektor2_Model_File_ExcelMapper::save($modelExcel, $this->sessionStatus)) {
            $downloadController = new Projektor2_Controller_ForcedDownload();
            // Projektor2_Controller_ForcedDownload->download končí příkazem exit, ukončí běh skriptu
            $downloadController->download($modelExcel->documentFileName);
        } else {;;
            return new Projektor2_View_HTML_ErrorExportExcel($this->sessionStatus);
        }
    }

    private function getLeftMenuArray() {
        $menuArray[] = ['href'=>'index.php?kurzy=kurz&kurz=ucastnici_kurzu', 'text'=>'Zpět na seznam účastníků'];
        return $menuArray;
    }
}

