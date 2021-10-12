<?php
/**
 * Description of Layout
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Header extends Framework_View_Abstract {
    public function render() {    
        $this->parts[] = '<div class="header">';
            $this->parts[] = $this->context['logoControllerResult'];
        $this->parts[] = '</div>';
        return $this;
    }
}
