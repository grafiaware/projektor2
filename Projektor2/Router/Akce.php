<?php
/**
 * Description of Projektor2_Router_Akce
 *
 * @author pes2704
 */
class Projektor2_Router_Akce {

    protected $sessionStatus;
    protected $request;
    protected $response;

    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getController() {

            switch ($this->sessionStatus->akce) {
                case 'kurzy':
                    $routerKurzy = new Projektor2_Router_Kurzy($this->sessionStatus, $this->request, $this->response);
                    $ctrl = $routerKurzy->getController();
                    break;
                case 'osoby':
                default:
                    $routerOsoby = new Projektor2_Router_Osoby($this->sessionStatus, $this->request, $this->response);
                    $ctrl = $routerOsoby->getController();
                    break;
            }
            return $ctrl;
    }
}
