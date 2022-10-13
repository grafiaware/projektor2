<?php
/**
 * Description of Projektor2_View_HTML_Zaznamy
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Table extends Framework_View_Abstract {

    const CSS_CLASS = 'class';

    public function render() {
        if (isset($this->context[self::CSS_CLASS])) {
            $this->parts[] = '<table class='.$this->context[self::CSS_CLASS].'>';
        } else {
            $this->parts[] = '<table>';
        }
        foreach ($this->context['rows'] as $row) {
            $this->parts[] = $row;
        }
        $this->parts[] = '</table>';
        return $this;
    }
}
