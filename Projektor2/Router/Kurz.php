<?php
/**
 * Description of Projektor2_Router_Akce
 *
 * @author pes2704
 */
class Projektor2_Router_Kurz {

    protected $sessionStatus;
    protected $request;
    protected $response;

    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getController() {
        switch($this->request->param('kurz')) {
            case "detail_kurzu":
                return new Projektor2_Controller_FormularKurz($this->sessionStatus, $this->request, $this->response);
                break;
            case "ucastnici_kurzu":
                return new Projektor2_Controller_SeznamUcastnikuKurzu($this->sessionStatus, $this->request, $this->response);
                break;
            case "excel":
                return new Projektor2_Controller_Export_Excel($this->sessionStatus, $this->request, $this->response, ['export_type'=>'kurz']);
                break;
            case "export_certifikaty_kurz":
                return new Projektor2_Controller_Export_CertifikatyKurz($this->sessionStatus, $this->request, $this->response);
                break;
        }
    }
}
