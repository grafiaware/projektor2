<?php
/**
 * Description
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Kurz_TdTlacitko extends Framework_View_Abstract {

    const VIEWMODEL_TLACITKO = 'viewmodel_tlacitko';
    const ID_KURZ = 'id_kurz';

    /**
     * Vrací elemet td
     * @return \Projektor2_View_HTML_Element_Zajemce_TdTlacitko
     */
    public function render() {
        $model = $this->context[self::VIEWMODEL_TLACITKO];
        $href = 'index.php?akce=kurzy&kurzy=kurz&kurz='.urlencode($model->kurz).'&id_s_kurz='.urlencode($this->context[self::ID_KURZ]);
        switch ($model->status) {
            case 'edit':
                $class = 'edit';
                break;
            case 'new':
                $class = 'new';
                break;
            case 'print':
                $class = 'print';
                break;
            case 'disabled':
                $class = 'disabled';
                $href = '#';
                break;
            default:
                break;
        }

        $this->parts[] = '<td class="'.$class.'">'
                . '<a title="'.$model->title.'" '
                . 'href="'.$href.'">'
                .$model->text
                .'</a></td>';
        return $this;
    }
}
