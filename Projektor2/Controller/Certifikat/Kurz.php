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
        /** @var Projektor2_Viewmodel_AktivitaPlan $aktivitaPlan */
        $aktivitaPlan = $this->params['aktivitaPlan'];
        $certifikatVerze = $this->params['certifikatVerze'];
        // projekt ze session, kancelar a zajemce - zde pro individuální certifikát právě editovaného zájemce (plán) -
        $certifikat = (new Projektor2_Service_CertifikatKurz())->create(
                $certifikatVerze,
                $this->sessionStatus,
                $this->sessionStatus->kancelar,
                $this->sessionStatus->zajemce,
                $aktivitaPlan->sKurz,
                $aktivitaPlan->datumCertif,
                $this->sessionStatus->user->name,
                __CLASS__
                );
        if (!$certifikat) {
            throw new LogicException('Nepodařilo se vytvořit verzi certifikátu: '.$certifikatVerze.' pro zajemce id: '.$this->sessionStatus->zajemce->id. ', kurz id: '.$sKurz->id_s_kurz);
        } else {
            $viewPdf = new Projektor2_View_HTML_Script_NewWindowOpener($this->sessionStatus);
            $viewPdf->assign('fullFileName', Projektor2_AppContext::getHttpFileBasePath().$certifikat->documentCertifikatKurz->relativeDocumentPath);
            return $viewPdf->render();
        }
    }
}
