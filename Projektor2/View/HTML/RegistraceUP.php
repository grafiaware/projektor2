<?php

use Pes\Text\Html;


/**
 * Description of HintView
 *
 * @author pes2704
 */
class Projektor2_View_HTML_RegistraceUP extends Framework_View_Abstract {
    public function render() {

        $signCizinec = Projektor2_Controller_Formular_FlatTable::CIZINEC_FT;
        $prefixCizinec = $signCizinec.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        $poleCizinec = $this->context[$signCizinec];


//            'Žádost na ÚP - registrace zájemce' => ['zaUpload'=>$this->upladCollection['registrace zájemce'], 'faze_date_text'=>'Datum žádost na ÚP - registrace zájemce'],

        foreach ($this->context["data_registrace"] as $registation) {
            /** @var Projektor2_Model_Db_ZaUploadType $zaUploadType */
            $zaUploadType = $registation['zaUploadType'];
            /** @var Projektor2_Model_Db_ZaUpload $zaUpload */
            $zaUpload = $registation['zaUpload'];
            if (isset($zaUpload)) {
                $fileBaseFolder = Projektor2_AppContext::getFileBaseFolder();
                $href = $zaUpload->filename;
                $href = '/'.substr($href, strpos($href, $fileBaseFolder)-strlen($href));  // levé lomítko + od base folder doprava - relativní adresa k root
                $filename = substr($href, strpos($href, 'upload/')-strlen($href));  // od 'upload/ doprava
                $aDownload = Html::tag('a', ['href'=>$href, 'download'=>$filename], "Download: $filename");
            } else {
                $aDownload = '';
            }
            $inputDatum = Html::input($prefixCizinec.$registation['datum_reg_name'], $registation['datum_reg_text'], $poleCizinec, ["type"=>"date", "size"=>"8", "maxlength"=>"10"]);
            $inputUpload = (new Projektor2_View_HTML_UploadFile($this->sessionStatus, ['type'=>$zaUploadType->type]))->render();

            $uploadsBlock[] =
                Html::tag("div", [],
                    $inputDatum,
                    $aDownload,
                    $inputUpload
                );
        }
        return $uploadsBlock;
    }
}
