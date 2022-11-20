<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_ExportSelectView extends Framework_View_Abstract {

    const HREF_ZPET = 'href_zpet';
    const FORM_ACTION = 'form_action';
    const SELECT_MODEL = 'select_model';

    public function render() {
        $this->parts[] = '<h3>Export tabulkových přehledů</h3>';

                $this->parts[] = '<form method="POST" action="'.$this->context[self::FORM_ACTION].'">';
                $this->parts[] = '<h4>Výběr typu exportu: </h4>';
                    $viewSelect = new Projektor2_View_HTML_Element_Select($this->sessionStatus);
                    $viewSelect->assign('viewModel', $this->context[self::SELECT_MODEL]); ;
                    $this->parts[] = $viewSelect->render();
                $this->parts[] = '<input type="submit" value="Export">';
                $this->parts[] = '</form>';

        return $this;
    }
}

?>
