<?php
/**
 * Description of Projektor2_Router_Akce
 *
 * @author pes2704
 */
class Projektor2_Router_Osoby {

    protected $sessionStatus;
    protected $request;
    protected $response;

    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request, Projektor2_Response $response) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
    }

    public function getController() {

        // Udělátko pro spuštění testů. Každý test musí být kontroler.
        if ($this->request->get('akce') == 'test') {
            $testClassName = $this->request->get('testclass');
            return new $testClassName($this->sessionStatus, $this->request, $this->response);
        }
        //Volba akce
        switch($this->request->param('osoby')) {
            case "excel":
                return new Projektor2_Controller_Export_Excel($this->sessionStatus, $this->request, $this->response, ['export_type'=>'osoby']);
                break;
            case "export_certifikaty_projekt":
                return new Projektor2_Controller_Export_CertifikatyProjekt($this->sessionStatus, $this->request, $this->response);
                break;
            case "form":
                return new Projektor2_Controller_Formular($this->sessionStatus, $this->request, $this->response);
                break;
            case "zobraz_reg":
            default:
                return new Projektor2_Controller_SeznamOsob($this->sessionStatus, $this->request, $this->response);
                break;
        }
    }
}

