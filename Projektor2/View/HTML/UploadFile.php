<?php

use Pes\Text\Html;


/**
 * Description of HintView
 *
 * @author pes2704
 */
class Projektor2_View_HTML_UploadFile extends Framework_View_Abstract {
    public function render() {
        $form = $this->getSelectForm();
        return $form ?? '';
    }


    /**
     *
     * @param string $formAction url pro axtion atribut formuláře
     * @param string $accept default "", dialog akceptuje všechny přípony, retězec přípon oddělených čárkou
     * @param boolean $multiple default false, dialog uploaduje jeden soubor
     * @return type
     */
    private function getSelectForm($accept="", $multiple=false) {
        $name = Projektor2_Controller_Import_ImportController::UPLOADED_KEY."[]";


        $form =
            Html::tag("input", ["type" => "file", "name" => $name, "accept" => $accept, "multiple" => $multiple])
            .Html::tag("button", ["formenctype"=>"multipart/form-data", "formmethod"=>"post"], "Upload")    // bez "formenctype"=>"multipart/form-data" není onsah ve $_FILES
        ;
        return $form;
    }
}
