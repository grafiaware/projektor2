<?php
/**
 * Description of Projektor2_Controller_Ap_ExportCertifikat
 *
 * @author pes2704
 */
class Projektor2_Controller_Certifikat_Kurz extends Projektor2_Controller_Certifikat_Abstract {

    /**
     * Metoda ověří existenci certifikátu, pokud neexistuje vytvoří ho a jako html obsah vrací js kód pro otevření pdf v novém okně prohlížeče.
     * @return string
     * @throws LogicException
     */
    public function getResult() {
        /** @var Projektor2_Model_CertifikatKurz $certifikat */
        $certifikat = $this->params['certifikat'];
        $viewPdf = new Projektor2_View_HTML_Script_NewWindowOpener($this->sessionStatus);
        $viewPdf->assign('fullFileName', Config_AppContext::getHttpFileBasePath().$certifikat->documentCertifikatKurz->relativeDocumentPath);
        return $viewPdf->render();
    }
}
