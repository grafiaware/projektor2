<?php
/**
 * Description of Base
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Abstract implements Projektor2_Controller_ControllerParamsInterface {

    /**
     * @var Projektor2_Model_Status
     */
    protected $sessionStatus;
    /**
     * @var Projektor2_Request
     */
    protected $request;
    /**
     * @var Projektor2_Response
     */
    protected $response;
    protected $params;

    public function __construct(Projektor2_Model_Status $sessionStatus, Projektor2_Request $request, Projektor2_Response $response, $params=null) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
        $this->response = $response;
        $this->params = $params;
    }

}
