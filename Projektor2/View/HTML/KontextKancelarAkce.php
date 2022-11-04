<?php
class Projektor2_View_HTML_KontextKancelarAkce extends Framework_View_Abstract {

    public function render() {
        $kancelare = $this->context['kancelare'];
        $subparts = $this->context['subparts'];

        $this->parts[] = '<div id="vyberkontext" class="bordered">';
        $this->parts[] = '<form name="Kancelar" id="Kancelar" action="index.php?kontext" method="post">';
            $this->parts[] = '<fieldset id="vyber_context">';
                $this->parts[] = '<legend>Výběr kanceláře, akce a běhu</legend>';
                $this->parts[] = '<label for="kancelar" >Vyberte kancelář:</label>';
                $this->parts[] = '<select id="kancelar" size="1" name="id_kancelar" onchange="submitForm(this);">';
                    $this->parts[] = "<option value=\"ß\"> </option>\n";
                    foreach ($kancelare as $kancelar) {
                        $option = "<option ";
                        if (isset($this->context['id_kancelar']) AND $kancelar->id==$this->context['id_kancelar']) {
                            $option .= 'selected="selected" ';
                        }
                        $option .= "value=\"".$kancelar->id."\">".$kancelar->text."</option>\n";
                        $this->parts[] = $option;
                    }
                $this->parts[] = '</select>';

                $this->parts[] = '<span >Vyberte akci:</span>';
                $this->parts[] = '<button type="submit" class="" formaction="index.php?kontext" name="akce" value="osoby" >OSOBY</button>';
                $this->parts[] = '<button type="submit" class="" formaction="index.php?kontext" name="akce" value="kurzy" >KURZY</button>';

            $this->parts[] = '</fieldset>';
        $this->parts[] = '</form>';
        $this->parts[] = '</div>';

        return $this;
    }
}

?>
