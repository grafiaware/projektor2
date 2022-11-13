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

        foreach ($this->context["registrace"] as $registation) {
            $uploadsBlock[] = $this->renderUploadBlock($registation, $prefixCizinec, $poleCizinec);
        }
        return $uploadsBlock;
    }

    private function renderUploadBlock($registation, $prefixCizinec, $poleCizinec) {
        /** @var Projektor2_Model_Db_ZaUploadType $zaUploadType */
        $zaUploadType = $registation['zaUploadType'];            /** @var Projektor2_Model_Db_ZaUpload $zaUpload */
        $zaUpload = $registation['zaUpload'];
        if (isset($zaUpload)) {
            $fileBaseHref = Projektor2_AppContext::getHttpFileBasePath();
            $fileSubpath = $zaUpload->filename;
            $displayedFilename = substr($fileSubpath, strpos($fileSubpath, 'upload/')-strlen($fileSubpath)+7);  // od 'upload/ doprava
            $aDownload =
                    Html::tag('a', ['href'=>$fileBaseHref.$fileSubpath, 'download'=>$displayedFilename],
                            Html::tag('button', [ 'type'=>"button"],   // POZOR 'type'=>"button" je nezbytné, jinak se chová jako dubmit button
                                    "Download: $displayedFilename"
                                    )
                    );
        } else {
            $aDownload = '';
        }
        $inputDatum = Html::input($prefixCizinec.$registation['datum_reg_name'], $registation['datum_reg_text'], $poleCizinec, ["type"=>"date", "size"=>"8", "maxlength"=>"10"]);
        $inputUpload = (new Projektor2_View_HTML_UploadFile($this->sessionStatus, ['type'=>$zaUploadType->type]))->render();

        return
            Html::tag("div", [],
                $inputDatum,
                $aDownload,
                $inputUpload
            );
    }
}
