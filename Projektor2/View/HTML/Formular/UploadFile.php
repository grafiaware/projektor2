<?php

use Pes\Text\Html;


/**
 * Description of HintView
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Formular_UploadFile extends Framework_View_Abstract {
    public function render() {
        return $this->getInputFile(".pdf, .doc, .docx, image/*");
    }


    /**
     *
     * @param string $formAction url pro action atribut formuláře
     * @param string $accept retězec přípon oddělených čárkou; default "", dialog akceptuje všechny přípony,
     * @param boolean $multiple default false, dialog uploaduje jeden soubor
     * @return type
     */
    private function getInputFile($accept="", $multiple=false) {
        if (isset($this->context['type']) AND $this->context['type']) {
            // normální formát jména proměnné v input type='file' pro upload multiple files - jméné proměnné zakončené [] - PHP zjevně dělá přiřazení, t.j. jmeno[] = xxxx
            // všechny položky pole $_FILES (name, type, tmp_name, error a size) budou číselná pole
            // $name = Projektor2_Controller_Formular_Base::UPLOADED_KEY."[]";
            //
            // tento tvar jména pro inputy typu 'file' způsobí, že všechny položky pole $_FILES (name, type, tmp_name, error a size) budou dvouúrovňová pole,
            // v první úrovní bude jako index zadaný typ (context['type']) a teprve ve druhé úrovni položky pro jednotlivé uploadované soubory
            if ($multiple) {
                $name = Projektor2_Controller_Formular_Base::UPLOADED_KEY."['{$this->context['type']}'][]";
            } else {
            // - varianta pro multipe=false (jen jeden soubor od každého typu v jednom formuláři)
            // - tento tvar jména pro inputy typu 'file' způsobí, že všechny položky pole $_FILES (name, type, tmp_name, error a size) budou pole,
            // ve všech těchto polích bude jako index zadaný typ (context['type'])
                $name = Projektor2_Controller_Formular_Base::UPLOADED_KEY."[{$this->context['type']}]";
            }

            return
                Html::tag("input", ["type" => "file", "name" => $name, "accept" => $accept, "multiple" => $multiple])
    //            .Html::tag("button", ["formenctype"=>"multipart/form-data", "formmethod"=>"post"], "Upload")    // bez "formenctype"=>"multipart/form-data" není obsah ve $_FILES
            ;
        }
    }
}
