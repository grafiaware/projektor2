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

    public function __construct(Projektor2_Model_Status $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getController() {
            // přijímá get parametry i z formuláže odesílaného metodou post (např VyberKontext)
            switch ($this->request->param('akce')) {
                case 'kurzy':
                    $routerKurzy = new Projektor2_Router_Kurzy($this->sessionStatus, $this->request, $this->response);
                    $ctrl = $routerKurzy->getController();
                    break;
                case 'osoby':
                    $routerOsoby = new Projektor2_Router_Osoby($this->sessionStatus, $this->request, $this->response);
                    $ctrl = $routerOsoby->getController();
                    break;
                default:
                    $ctrl = new Projektor2_Controller_NoContent($this->sessionStatus, $this->request, $this->response);
                    break;
            }
            return $ctrl;
    }
}
