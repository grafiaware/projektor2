<?php
/**
 * Description of Projektor2_Controller_Ap_ExportCertifikat
 *
 * @author pes2704
 */
class Projektor2_Controller_Certifikat_Projekt extends Projektor2_Controller_Certifikat_Abstract {

    /**
     * Metoda ověří existenci certifikátu, pokud neexistuje vytvoří ho a jako html obsah vrací js kód pro otevření pdf v novém okně prohlížeče.
     * @return string
     * @throws LogicException
     */
    public function getResult() {
        $serviceCertifikat = new Projektor2_Service_CertifikatProjekt();
        $datumCertifikatu = $this->params['datumCertif'];
        $certifikat = $serviceCertifikat->create(
                $this->sessionStatus, $this->sessionStatus->getUserStatus()->getKancelar(),
                $this->sessionStatus->getUserStatus()->getZajemce(), $datumCertifikatu, $this->sessionStatus->getUserStatus()->getUser()->username, __CLASS__);
        if (!$certifikat) {
            throw new LogicException('Nepodařilo se vytvořit certifikát pro zajemce id: '.$this->sessionStatus->getUserStatus()->getZajemce()->id. '.');
        }
        $viewPdf = new Projektor2_View_HTML_Script_NewWindowOpener($this->sessionStatus);
        $viewPdf->assign('fullFileName', Config_AppContext::getHttpFileBasePath().$certifikat->dbCertifikatProjekt->filename);

        return $viewPdf->render();
    }
}
