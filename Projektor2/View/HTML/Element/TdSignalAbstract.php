<?php
/**
 * Description
 *
 * @author pes2704
 */
abstract class Projektor2_View_HTML_Element_TdSignalAbstract extends Framework_View_Abstract {
    protected function renderTd($title, $class, $text) {
        $this->parts[] = '<td title="'.$title.'" class="'.$class.'">'
                .$text
                .'</td>';
        return $this;
    }
}
