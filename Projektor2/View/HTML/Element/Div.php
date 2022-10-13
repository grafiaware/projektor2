<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Div extends Framework_View_Abstract {

    const CSS_CLASS = 'class';
    const HTML_PARTS = 'htmlParts';

    public function render() {
        if (isset($this->context[self::CSS_CLASS])) {
            $this->parts[] = '<div class='.$this->context[self::CSS_CLASS].'>';
        } else {
            $this->parts[] = '<div>';
        }
        if (isset($this->context[self::HTML_PARTS]) AND $this->context[self::HTML_PARTS]) {
            $innerParts = $this->context[self::HTML_PARTS];
            if (is_array($innerParts)) {
                foreach ($this->context[self::HTML_PARTS] as $part) {
                    $this->parts[] = $part;
                }
            } else {
                $this->parts[] = $innerParts;
            }
        }
        $this->parts[] = '</div>';
        return $this;
    }
}
