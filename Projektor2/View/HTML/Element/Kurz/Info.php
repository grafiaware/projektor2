<?php
/**
 * Description
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Kurz_Info extends Framework_View_Abstract {

    const VIEWMODEL_KURZ = 'viewmodel_kurz';
    const HTML_SKUPINY = 'htmlSkupiny';

    /**
     * Vrací element tr
     * @return \Projektor2_View_HTML_Element_Zajemce_Registrace
     */
    public function render() {
        /** @var Projektor2_Viewmodel_Kurz $viewmodelKurz */
        $viewmodelKurz = $this->context[self::VIEWMODEL_KURZ];

        $this->parts[]= '<tr>';
        $this->parts[]= '<td class=identifikator>' . $viewmodelKurz->id . '</td>';
        $this->parts[]= '<td class=identifikator>' . $viewmodelKurz->kurz_text . '</td>';
        $this->parts[]= '<td class=identifikator>' . $viewmodelKurz->kurz_lokace.'</td>';
        $this->parts[]= $this->context[self::HTML_SKUPINY];
        $this->parts[]= '</tr>';
        return $this;
    }
}
