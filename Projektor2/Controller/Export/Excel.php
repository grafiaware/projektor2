<?php
class Projektor2_Controller_Export_Excel extends Projektor2_Controller_Abstract {

    /**
     * Prefix jména vytvářených view v databázi
     */
    const VIEW_PREFIX = 'export_excel_';


    private function performPost() {
        if($this->request->post('dbtabulka') AND substr($this->request->post('dbtabulka'),0,3)<>"---") {
            $sqlView = $this->request->post('dbtabulka');
            $modelExcel = Projektor2_Model_File_ExcelMapper::createFromView($sqlView);
            if (Projektor2_Model_File_ExcelMapper::save($modelExcel, $this->sessionStatus)) {
                $downloadController = new Projektor2_Controller_ForcedDownload();
                // Projektor2_Controller_ForcedDownload->download končí příkazem exit, ukončí běh skriptu
                $downloadController->download($modelExcel->documentFileName);
            } else {;;
                $parts[] = new Projektor2_View_HTML_ErrorExportExcel($this->sessionStatus);
            }
        }
        if($this->request->post('export_template') AND substr($this->request->post('export_template'),0,3)<>"---") {
            $templateObject = new Projektor2_Controller_Export_SqlTemplate_SqlTemplate($this->sessionStatus, $this->request);
            $exportTemplateName = $this->request->post('export_template');
            switch ($exportTemplateName) {
                case 'zajemci':
                    $sqlFilename = 'Zajemci.sql';
                    $viewNamePostfix = 'zajemci';
                    $xlsSheetName = 'zajemci';
                    break;
                case 'cizinci projekt':
                    $sqlFilename = 'Cizinci_projekt.sql';
                    $viewNamePostfix = 'cizinci_projekt';
                    $xlsSheetName = 'CJC osoby celý projekt';
                    break;
                case 'ucastnici':
                    $sqlFilename = 'Ucastnici_projekt.sql';
                    $viewNamePostfix = 'ucastnici';
                    $xlsSheetName = 'CJC ucastnici cely projekt';
                    break;
                default:
                    throw new UnexpectedValueException("Neznámá hodnota parametru 'export_template' $exportTemplateName");
            }

            $sql = $templateObject->getTemplate($sqlFilename, $templateParams ?? []);
            if ($sql) {
                $sqlView = Projektor2_Model_File_ExcelMapper::createViewFromSql(self::VIEW_PREFIX.$viewNamePostfix, $sql);
                $modelExcel = Projektor2_Model_File_ExcelMapper::createFromView($sqlView, $xlsSheetName, $templateObject->getUsedParams());
                if (Projektor2_Model_File_ExcelMapper::save($modelExcel, $this->sessionStatus)) {
                    $downloadController = new Projektor2_Controller_ForcedDownload();
                    // Projektor2_Controller_ForcedDownload->download končí příkazem exit, ukončí běh skriptu
                    $downloadController->download($modelExcel->documentFileName);
                } else {;;
                    $parts[] = new Projektor2_View_HTML_ErrorExportExcel($this->sessionStatus);
                }
            }
        }

        return $parts ?? [];
    }

    private function getLeftMenuArray() {
        $menuArray[] = ['href'=>'index.php?akce=kurzy&kurzy=kurz&kurz=ucastnici_kurzu', 'text'=>'Zpět na seznam účastníků'];
        return $menuArray;
    }

    public function getResult() {
        if ($this->request->isPost()) {
            $parts = $this->performPost();
        } else {
            $kodProjektu = $this->sessionStatus->projekt->kod;
            $exportType = $this->params['export_type'] ?? null;

            switch ($kodProjektu) {
                case 'HELP':
                    $parts[] = new Projektor2_View_HTML_Help_Export($this->sessionStatus);
                    break;
                case 'AP':
                    $parts[] = new Projektor2_View_HTML_Ap_Export($this->sessionStatus);
                    break;
                case 'SJZP':
                    $parts[] = new Projektor2_View_HTML_Sjzp_Export($this->sessionStatus);
                    break;
                case 'SJPK':
                    $parts[] = new Projektor2_View_HTML_Sjpk_Export($this->sessionStatus);
                    break;
                case 'VZP':
                    $parts[] = new Projektor2_View_HTML_Vzp_Export($this->sessionStatus);
                    break;
                case 'ZPM':
                    $parts[] = new Projektor2_View_HTML_Zpm_Export($this->sessionStatus);
                    break;
                case 'SPP':
                    $parts[] = new Projektor2_View_HTML_Spp_Export($this->sessionStatus);
                    break;
                case 'RP':
                    $parts[] = new Projektor2_View_HTML_Rp_Export($this->sessionStatus);
                    break;
                case 'SJPO':
                    $parts[] = new Projektor2_View_HTML_Sjpo_Export($this->sessionStatus);
                    break;
                case 'SJLP':
                    $parts[] = new Projektor2_View_HTML_Sjlp_Export($this->sessionStatus);
                    break;
                case 'VDTP':
                    $parts[] = new Projektor2_View_HTML_Vdtp_Export($this->sessionStatus);
                    break;
                case 'PDU':
                    $parts[] = new Projektor2_View_HTML_Pdu_Export($this->sessionStatus);
                    break;
                case 'MB':
                    $parts[] = new Projektor2_View_HTML_Mb_Export($this->sessionStatus);
                    break;
                case 'CJC':
                    switch ($exportType) {
                        case 'ucastnici':
                            $exportSelectView = new Projektor2_View_HTML_ExportSelectView($this->sessionStatus);
                            $selectModel = new Projektor2_Model_Element_Select(
                                    'export_template',
                                    ['------------', 'ucastnici']
                                    );
                            $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::SELECT_MODELS, [$selectModel]);
                            $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::HREF_ZPET, "index.php?akce=kurzy&kurzy=seznam");
                            $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::FORM_ACTION, "index.php?akce=kurzy&kurzy=kurz&kurz=export_ucastnici");
                            $parts[] = $exportSelectView;
                            break;
                        case 'osoby':
                            $exportSelectView = new Projektor2_View_HTML_ExportSelectView($this->sessionStatus);
                            $selectModel = new Projektor2_Model_Element_Select(
                                'dbtabulka',
                                ['------------', 'excel_cjc_zajemci', 'excel_cjc_kurzy', 'excel_cjc_certifikaty']
                                );
                            $selectModel2 = new Projektor2_Model_Element_Select(
                                'export_template',
                                ['------------', 'cizinci projekt']
                                );
                            $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::SELECT_MODELS, [$selectModel, $selectModel2]);
                            $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::HREF_ZPET, "index.php?akce=osoby&osoby=seznam");
                            $exportSelectView->assign(Projektor2_View_HTML_ExportSelectView::FORM_ACTION, "index.php?akce=osoby&osoby=export");
                            $parts[] = $exportSelectView;
                            break;
                        default:
                            break;
                    }

                    break;

                default:
                    break;

//                                <option value=v_mb_zajemci>Monitoring - všichni zájemci v projektu</option>
//                                <option value=v_mb_kurzy>Monitoring - všechny kurzy v projektu</option>
//                                <option value=v_mi_vstoupily>Monitoring - vstoupili do zadaného data monitoringu</option>
//                                <option value=v_mi_vstoupily_souhrn_kancelare>Monitoring - vstoupili do zadaného data monitoringu souhrn za kanceláře</option>
//                                <option value=v_mi_vstoupily_souhrn_celkem>Monitoring - vstoupili do zadaného data monitoringu - souhrn celkem</option>
            }

            $subgridColumn[] = new Projektor2_View_HTML_LeftMenu($this->sessionStatus, ['menuArray'=>$this->getLeftMenuArray()]);
            $subgridColumn[] = new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$parts, 'class'=>'content']);
            return new Projektor2_View_HTML_Element_Div($this->sessionStatus, ['htmlParts'=>$subgridColumn, 'class'=>'grid-container']);
        }
    }
}

