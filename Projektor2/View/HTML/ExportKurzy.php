<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_ExportKurzy extends Framework_View_Abstract {

    public function render() {
        $this->parts[] = '<h3>Export tabulkových přehledů</h3>';
        $this->parts[] = '<div class="left">
                                <ul id="menu">
                                    <hr>
                                    <li><a href="index.php?akce=osobyosoby=seznam">Zpět na zobrazení registrací</a></li>';
        $this->parts[] = '        </ul>
                        </div>';
        $this->parts[] = '<div class="content">';
            $this->parts[] = '<form method="POST" action="index.php?osoby=export" name="vyber_tabulky">';
            $this->parts[] = '<h4>Databázové tabulky: </h4>';

        $modelSelect = new Projektor2_Viewmodel_Element_Select(
                'dbtabulka',
                ['------------', 'excel_cjc_zajemci', 'excel_cjc_kurzy', 'excel_cjc_certifikaty']
                );
        $viewSelect = new Projektor2_View_HTML_Element_Select($this->sessionStatus);
        $viewSelect->assign('viewModel', $modelSelect); ;
            $this->parts[] = $viewSelect->render();
            $this->parts[] = '<input type="submit" value="Export" name="E1">';
            $this->parts[] = '</form>';
        $this->parts[] = '</div>';
        return $this;
    }
//                                <option value=v_mb_zajemci>Monitoring - všichni zájemci v projektu</option>
//                                <option value=v_mb_kurzy>Monitoring - všechny kurzy v projektu</option>
//                                <option value=v_mi_vstoupily>Monitoring - vstoupili do zadaného data monitoringu</option>
//                                <option value=v_mi_vstoupily_souhrn_kancelare>Monitoring - vstoupili do zadaného data monitoringu souhrn za kanceláře</option>
//                                <option value=v_mi_vstoupily_souhrn_celkem>Monitoring - vstoupili do zadaného data monitoringu - souhrn celkem</option>
}

?>
