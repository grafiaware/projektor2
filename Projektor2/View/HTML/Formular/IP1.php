<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Formular_IP1 extends Framework_View_Abstract {

    public function render() {
        $this->parts[] = '<div>';
        $this->parts[] = '<H3>'.$this->context['nadpis'].'</H3>';
        $this->parts[] = '<span>'.$this->sessionStatus->zajemce->id.'</span>';
        $this->parts[] = '<H4>Plán aktivit</H4>';
        $this->parts[] = '<form method="POST" action="index.php?osoby=form&form=plan">';

        foreach (array_keys($this->context['aktivityTypuKurz']) as $aktivita) {  // používám jen klíče - pole aktivit je v context
                $view = new Projektor2_View_HTML_Element_Kurz_Fieldset($this->sessionStatus, $this->context);
                $view
                    ->assign('aktivita', $aktivita)
                    ->assign('readonly', FALSE)
                        // Projektor2_Viewmodel_Kurz
                    ->assign('returnedModelProperty', 'id');
                $this->parts[] = $view;
        }

        $this->parts[] = '<br>';
        $this->parts[] = '<p>Datum vytvoření:';
        $dvName = Projektor2_Controller_Formular_FlatTable::PLAN_FT.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.'datum_upravy_dok_plan';
        $dvValue = $this->context[Projektor2_Controller_Formular_FlatTable::PLAN_FT][$dvName] ? $this->context[Projektor2_Controller_Formular_FlatTable::PLAN_FT][$dvName] : date("Y-m-d");
        $this->parts[] =   '<input type="date" id="datum_vytvor_dok" size="8" maxlength="10" name="'.$dvName.'" value="'.$dvValue.'" required >';
        $this->parts[] = '</p>';

        $this->parts[] = '<p>';
        $this->parts[] = '<input type="submit" value="'.$this->context['submitUloz']['value'].'" name="'.$this->context['submitUloz']['name'];
        $this->parts[] = '&nbsp;&nbsp;&nbsp;</p> ';
        $this->parts[] =   '<input type="reset" name="reset" value="Zruš provedené změny" >';
        $this->parts[] = '</p>';
        //TISK
        if ($this->context[Projektor2_Controller_Formular_FlatTable::PLAN_FT][Projektor2_Controller_Formular_FlatTable::PLAN_FT.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.'id_zajemce']){
            $this->parts[] = '<p><input type="submit" value="'.$this->context['submitTiskIP1']['value'].'" name="'.$this->context['submitTiskIP1']['name'].'">&nbsp;&nbsp;&nbsp;</p> ';
        }
        $this->parts[] = '</form>';
        $this->parts[] = '</div>';
        return $this;
    }
}

