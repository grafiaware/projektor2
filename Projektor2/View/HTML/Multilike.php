<?php
class Projektor2_View_HTML_Multilike extends Framework_View_Abstract {

    public function render() {
        $multilikeText = $this->context['multilike_text'] ?? '';
        $multilikeDate = $this->context['multilike_date'] ?? '';
        $titleText = $this->context['title_text'] ?? '';
        $titleDate = $this->context['title_date'] ?? '';
        $resetJs = 'function resetMultilike() {
            tt = document.getElementById(\'multilike_input_text\');
            tt.defaultValue=\'\';
            dd = document.getElementById(\'multilike_input_date\');
            dd.defaultValue=\'\';
            submitForm(tt);
            }';

        $this->parts[] = '<script>'.$resetJs.'</script>';
        $this->parts[] = '<div id="" class="">';
        $this->parts[] = '<form method="post">';
            $this->parts[] = '<fieldset id="vyber_multilike">';
                $this->parts[] = '<legend>Vyhledávání</legend>';

                $this->parts[] = '<label for="multilike_input" >Zadejte co hledáte:</label>';
                $this->parts[] = '<input id="multilike_input_text" type="text" name="multiliketext" value="'.$multilikeText.'" placeholder="Obsahuje..." title="'.$titleText.'" onEnter="submitForm(this);"/>';
                $this->parts[] = '<input id="multilike_input_date" type="date" name="multilikedate" value="'.$multilikeDate.'" title="'.$titleDate.'" onEnter="submitForm(this);"/>';
//
                $this->parts[] = '<button type="reset" value="Reset" onClick="resetMultilike()">Reset</button>';
        $this->parts[] = '</fieldset>';
        $this->parts[] = '</form>';
        $this->parts[] = '</div>';

        return $this;
    }
}

