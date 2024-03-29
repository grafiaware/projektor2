<?php
/**
 * Description
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Zajemce_TdTlacitko extends Framework_View_Abstract {
    /**
     * Vrací elemet td
     * @return \Projektor2_View_HTML_Element_Zajemce_TdTlacitko
     */
    public function render() {
        $model = $this->context['model'];
        $href = 'index.php?akce=osoby&osoby=form&form='.urlencode($model->osoba).'&id_zajemce='.urlencode($this->context['zajemceRegistrace']->id);
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
