<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author pes2704
 */
interface Projektor2_Controller_ControllerParamsInterface extends Projektor2_Controller_ControllerInterface {
    public function __construct(Projektor2_Model_Status $sessionStatus, Projektor2_Request $request, Projektor2_Response $response, array $params=array());
}

