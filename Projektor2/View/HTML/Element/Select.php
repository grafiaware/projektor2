<?php
/**
 * Description of Projektor2_View_HTML_Element_Select
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Select extends Framework_View_Abstract {

    /**
     * @var Projektor2_Model_Element_Select
     */
    private $viewModel;


    /**
     * Metoda generuje html kód elementu select.
     * Parametry očekává jako prvky pole context.
     * 'selectId' string id atribut prvku select
     * 'selectName' string name atribut prvku select (jméno proměnné formuláře)
     * 'valuesArray' array pole návratových hodnot, jde o pole skalárů nebo objektů, slouží také pro generování jednotlivých elementů option
     * 'returnedObjectProperty' string jméno vlastnosti objektu použité pro návratovou hodnotu, pokud valuesArray je pole objektů
     * 'actualValue' string současná hodnota proměnné formuláře - slouží pro výběr příslušné option jako selected
     * 'innerTextCallable' callable je volán pro vygenerování zobrazovaných textů jednotlivých option vytvožených z položek valuesArray (např. array($this,'text_retezec_kurz'))
     * 'onChangeJsCode' string javascriptový kód volaný při změně hodnoty selectu (např, 'submitForm(this);' provede submit formuláře po ksždé změně hodnoty
     * 'readonly' mixed pokud je TRUE je select je pouze pro čtení
     * 'required' mixed pokud je TRUE je select requird, toto je funkční je pokud hodnoty "nevybraného" slectu (tedy první option) je vyhodnocována jako FALSE (napž. prázdný řetězec)
     * @return \Projektor2_View_HTML_Element_Select HTML kód select
     */
    public function render() {
        $this->viewModel = $this->context['viewModel'];
        $disabledAttribute = ($this->viewModel->getReadonly() OR $this->viewModel->getDisabled()) ? ' disabled="disabled" ' : ' ';
        $requiredAttribute = ($this->viewModel->getRequired()) ? ' required="required" ' : ' ';
        $onChangeCode = ($this->viewModel->getOnChangeJsCode()) ? ' onChange="'.$this->viewModel->getOnChangeJsCode().'"':' ';
        $style = ($this->viewModel->getDisplay()) ? 'style=display:'.$this->viewModel->getDisplay() : ' ';

        $this->parts[] = '<select '
                . 'id="'.$this->viewModel->getSelectId().'" '
                . 'size="1" '
                . 'name="'.$this->viewModel->getSelectName().'" '
                .$disabledAttribute
                .$requiredAttribute
                .$style
                .$onChangeCode
                . ' >';
        foreach ($this->viewModel->getValues() as $value) {
            $this->parts[] = $this->optionCode($value);
        }
        $this->parts[] = '</select>';
        return $this;
    }

    private function optionCode($value) {
        $option = '<option ';
        $contextValue = $this->viewModel->getActualValue();
        if (is_object($value)) {
            $prop = $this->viewModel->getReturnedObjectProperty();
            $valueObjectProperty = $value->$prop;
            if (isset($contextValue) AND $contextValue == $valueObjectProperty) {
                $option .= 'selected="selected"';
            }
            $option .= ' value="'.$valueObjectProperty.'">'.call_user_func($this->viewModel->getInnerTextCallable(), $value).'</option>';
        } else {
            if (isset($contextValue) AND $contextValue == $value) {
                $option .= 'selected="selected"';
            }
            if ($this->viewModel->getInnerTextCallable())
           {
                $option .= ' value='.$value.'>'.call_user_func($this->viewModel->getInnerTextCallable(), $value).'</option>';
            } else {
                $option .= ' value="'.$value.'">'.$value.'</option>';
            }
        }
        return $option;
    }
}
