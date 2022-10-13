<?php
/**
 * Description of Projektor2_Router_Akce
 *
 * @author pes2704
 */
class Projektor2_Router_Kurzy {

    protected $sessionStatus;
    protected $request;
    protected $response;

    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getController() {
        switch($this->request->param('kurzy')) {
            case "kurz":
                return (new Projektor2_Router_Kurz($this->sessionStatus, $this->request, $this->response))->getController();
            case "seznam":
            default:
                return new Projektor2_Controller_SeznamKurzu($this->sessionStatus, $this->request, $this->response);
                break;
        }
    }
}
