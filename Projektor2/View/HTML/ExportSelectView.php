<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_ExportSelectView extends Framework_View_Abstract {

    const HREF_ZPET = 'href_zpet';
    const FORM_ACTION = 'form_action';
    const SELECT_MODELS = 'select_model';

    public function render() {
        $this->parts[] = '<h3>Export tabulkových přehledů</h3>';
        $this->parts[] = '<div class"grid-container">';
            $this->parts[] = '<div class="left">
                                <ul id="menu">
                                    <hr>
                                    <li><a href="'.$this->context[self::HREF_ZPET].'">Zpět na zobrazení registrací</a></li>';
            $this->parts[] = '  </ul>
                              </div>';
            $this->parts[] = '<div class="content">';
                $this->parts[] = '<form method="POST" action="'.$this->context[self::FORM_ACTION].'" name="vyber_tabulky">';
                $this->parts[] = '<h4>Výběr typu exportu: </h4>';
                foreach ($this->context[self::SELECT_MODELS] as $selectModel) {
                    $viewSelect = new Projektor2_View_HTML_Element_Select($this->sessionStatus);
                    $viewSelect->assign('viewModel', $selectModel); ;
                    $this->parts[] = $viewSelect->render();
                }
                $this->parts[] = '<input type="submit" value="Export">';
                $this->parts[] = '</form>';
            $this->parts[] = '</div>';
        $this->parts[] = '</div>';
        return $this;
    }
}

?>
