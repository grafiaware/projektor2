<?php
class Projektor2_View_HTML_KontextKancelarAkce extends Framework_View_Abstract {

    public function render() {
        $kancelare = $this->context['kancelare'];

        $this->parts[] = '<div id="vyberkontext" class="bordered fieldsetcontainer c1c1">';
        $this->parts[] = '<form id="Kancelar" action="index.php?kontext" method="post">';
            $this->parts[] = '<fieldset id="vyber_context" class"leftcolumn">';
                $this->parts[] = '<legend>Výběr kanceláře</legend>';
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
            $this->parts[] = '</fieldset>';
        $this->parts[] = '</form>';

        $this->parts[] = '<form method="post">';  // metoda musí být POST (GET neodesílá query uvedené v action (nebo formaction) - router Akce příjímá parametry i z POST requestu
            $this->parts[] = '<fieldset id="vyber_akci" class"rightcolumn">';
                $this->parts[] = '<legend>Výběr akce</legend>';
                $this->parts[] = '<button type="submit" class="" formaction="index.php?akce=osoby&osoby=seznam">OSOBY</button>';
                $this->parts[] = '<button type="submit" class="" formaction="index.php?akce=kurzy&kurzy=seznam">KURZY</button>';
            $this->parts[] = '</fieldset>';
        $this->parts[] = '</form>';
        $this->parts[] = '</div>';

        return $this;
    }
}

?>
