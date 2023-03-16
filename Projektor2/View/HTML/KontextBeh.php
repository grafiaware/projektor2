<?php
class Projektor2_View_HTML_KontextBeh extends Framework_View_Abstract {

    public function render() {
        $behy = $this->context['behy'];
//        $subparts = $this->context['subparts'];

        $this->parts[] = '<div id="vyberkontext" class="bordered">';
        $this->parts[] = '<form name="Kancelar" id="Kancelar" action="index.php?akce=osoby&osoby=seznam" method="post">';
            $this->parts[] = '<fieldset id="vyber_context">';
                $this->parts[] = '<legend>Výběr běhu</legend>';

                $this->parts[] = '<label for="beh" >Vyberte běh:</label>';
                $this->parts[] = '<select id="beh" size="1" name="id_beh"  onchange="submitForm(this);">';
                    $this->parts[] = "<option value=\"ß\"> </option>\n";
                    foreach ($behy as $beh) {
                        $option = "<option ";
                        if (isset($this->context['id_beh']) AND $beh->id==$this->context['id_beh']) {
                            $option .= 'selected="selected" ';
                        }
                        $option .= "value=\"".$beh->id."\">".$beh->text."</option>\n";
                        $this->parts[] = $option;
                    }
                $this->parts[] = '</select>';
            $this->parts[] = '</fieldset>';
        $this->parts[] = '</form>';
        $this->parts[] = '</div>';

        return $this;
    }
}

?>
