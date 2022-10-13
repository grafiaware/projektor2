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
            return new $testClassName();
        }

        //Volba akce
        switch ($this->sessionStatus->projekt->kod) {
            case "AGP":
            case "HELP":
            case "SJZP":
            case "VZP":
            case "ZPM":
            case "SPP":
            case "RP":
            case "SJPK":
            case "SJPO":
            case "SJLP":
            case "VDTP":
            case "PDU":
            case "MB":
                switch($this->request->param('osoby')) {
                    case "export":
                        return new Projektor2_Controller_Export_Excel($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "form":
                        return new Projektor2_Controller_Formular($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zobraz_reg":
                    default:
                        return new Projektor2_Controller_SeznamRegistraci($this->sessionStatus, $this->request, $this->response);
                        break;
                    }
                break;
            case "AP":
                switch($this->request->param('osoby')) {
                    case "export":
                        return new Projektor2_Controller_Export_Excel($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ap_ip_certifikaty_export":
                        return new Projektor2_Controller_Export_CertifikatyKurz($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "ap_projekt_certifikaty_export":
                        return new Projektor2_Controller_Export_CertifikatyProjekt($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "form":
                        return new Projektor2_Controller_Formular($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zobraz_reg":
                    default:
                        return new Projektor2_Controller_SeznamRegistraci($this->sessionStatus, $this->request, $this->response);
                        break;
                }
            break;
            case "CJC":
                switch($this->request->param('osoby')) {
                    case "export":
                        return new Projektor2_Controller_Export_Excel($this->sessionStatus, $this->request, $this->response, ['export_type'=>'osoby']);
                        break;
                    case "cjc_ip_certifikaty_export":
                        return new Projektor2_Controller_Export_CertifikatyKurz($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "form":
                        return new Projektor2_Controller_Formular($this->sessionStatus, $this->request, $this->response);
                        break;
                    case "zobraz_reg":
                    default:
                        return new Projektor2_Controller_SeznamRegistraci($this->sessionStatus, $this->request, $this->response);
                        break;
                    }
                break;
            default:
                throw new UnexpectedValueException('neznámý kód projektu: '.$this->sessionStatus->projekt->kod);

        }
    }
}

?>
