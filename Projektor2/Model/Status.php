<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppStatus
 *
 * @author pes2704
 */
class Projektor2_Model_Status {

    /**
     * Poslední načtený stav
     * @var Projektor2_Model_Status
     */
    private static $status;

    /**
     * @var Projektor2_Model_UserStatus
     */
    private $userStatus;

    /**
     *
     * @var Projektor2_Model_Navigation
     */
    private $navigation;

    /**
     *
     * @var Projektor2_Request
     */
    private $lastGet;

    /**
     * @var Framework_Logger_File
     */
    private $logger;

    public function setUserStatus(Projektor2_Model_UserStatus $userStatus=null) {
        $this->userStatus = $userStatus;
        return $this;
    }

    public function setNavigation(Projektor2_Model_Navigation $navigation) {
        $this->navigation = $navigation;
        return $this;
    }

    public function setLastGet(Projektor2_Request $request) {
        if ($request->isGet()) {
            $this->lastGet = $request;
        }
    }

    public function getUserStatus(): ?Projektor2_Model_UserStatus {
        return $this->userStatus;
    }

    public function getNavigation(): ?Projektor2_Model_Navigation {
        return $this->navigation;
    }

    public function getLastGet(): ?Projektor2_Request {
        return $this->lastGet;
    }


########################

    private function __construct() {}

    /**
     * Metoda obnoví status ze session nebo vytvoří nový.
     *
     * @return Projektor2_Model_Status
     * @throws Exception
     */
    public static function create(Projektor2_Session $session): Projektor2_Model_Status {
        if (!self::$status) {   //sigleton
            self::$status = $session->get('status');
            if (!self::$status) {
                self::$status = new self;
            }
        }
        return self::$status;
    }

    public static function getSessionStatus(): ?Projektor2_Model_Status {
        return self::$status;
    }

    public function save(Projektor2_Session $session) {
        $session->set('status', self::$status);
    }
}
