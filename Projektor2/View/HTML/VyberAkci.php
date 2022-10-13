<?php
class Projektor2_View_HTML_VyberAkci extends Framework_View_Abstract {

    public function render() {

        $this->parts[] = '<div class="">';
        $this->parts[] = '<form id="akce" method="post" >';
        $this->parts[] = '<button type="submit" class="" formaction="index.php?akce=osoby" >OSOBY</button>';
        $this->parts[] = '<button type="submit" class="" formaction="index.php?akce=kurzy" >KURZY</button>';
        $this->parts[] = '</form>';

        $this->parts[] = '</div>';

        return $this;
    }
}

