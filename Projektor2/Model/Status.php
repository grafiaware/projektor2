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
     * @var Projektor2_Model_SessionStatus
     */
    protected static $status;

    /**
     * @var Projektor2_Model_Db_Kancelar
     */
    public $kancelar;

    /**
     * @var Projektor2_Model_Db_Projekt
     */
    public $projekt;

    /**
     * @var Projektor2_Model_Db_Beh
     */
    public $beh;

    /**
     * @var string
     */
    public $akce;

    /**
     * @var Projektor2_Model_Db_SysUser
     */
    public $user;

    /**
     * @var Projektor2_Model_Db_Zajemce
     */
    public $zajemce;

    /**
     * @var Projektor2_Model_Db_SKurz
     */
    public $sKurz;

    /**
     *
     * @var Projektor2_Model_Navigation
     */
    public $navigation;

    /**
     * 
     * @var Projektor2_Request
     */
    public $lastGet;
    
    
    /**
     * @var Framework_Logger_File
     */
    public $logger;

    public function setUser(Projektor2_Model_Db_SysUser $user=NULL) {
        $this->user = $user;
        return $this;
    }

    public function setKancelar(Projektor2_Model_Db_Kancelar $kancelar=NULL) {
        $this->kancelar = $kancelar;
        return $this;
    }

    public function setProjekt(Projektor2_Model_Db_Projekt $projekt=NULL) {
        $this->projekt = $projekt;
        return $this;
    }

    public function setBeh(Projektor2_Model_Db_Beh $beh=NULL) {
        $this->beh = $beh;
        return $this;
    }

    public function setAkce($akce=NULL) {
        $this->akce = $akce;
        return $this;
    }

    public function setZajemce(Projektor2_Model_Db_Zajemce $zajemce=NULL) {
        $this->zajemce = $zajemce;
        return $this;
    }

    public function setSKurz(Projektor2_Model_Db_SKurz $sKurz=NULL) {
        $this->sKurz = $sKurz;
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
#######################    
########################    
    /**
     * Metoda vytvoří session status z cookies nastavených login procesem
     * @return Projektor2_Model_SessionStatus
     * @throws Exception
     */
    public static function createSessionStatus(Projektor2_Request $request, Projektor2_Response $response, Framework_Logger_File $logger=NULL) {
        if (!self::$status) {   //sigleton
            self::$status = new Projektor2_Model_Status();
            try {
                self::$status->logger = $logger;
                $authCookie = new Projektor2_Auth_Cookie($request, $response);  // injekt response, Projektor2_Auth_Cookie sama nastaví cookie v responsu
                session_start();
                if(!$user) {
                    throw new Exception("Neexistuje uživatel s nastavenou identitou.");
                }
                self::$status->setUser($user);
                // projekt z cookie
                self::$status->setProjekt(Projektor2_Model_Db_ProjektMapper::findById($request->cookie('projektId')));
                // kancelar z cookie
                self::$status->setKancelar(Projektor2_Model_Db_KancelarMapper::getValid($request->cookie('kancelarId')));
                // beh z cookie
                self::$status->setBeh(Projektor2_Model_Db_BehMapper::findById($request->cookie('behId')));
                // akce z cookie
                self::$status->setAkce($request->cookie('akce'));
                // zajemce z cookie
                $zajemce = Projektor2_Model_Db_ZajemceMapper::get($request->cookie('zajemceId'));
                self::$status->setZajemce($zajemce);
                // sKurz z cookie
                $sKurz = Projektor2_Model_Db_SKurzMapper::get($request->cookie('sKurzId'));
                self::$status->setSKurz($sKurz);
                // last GET
                self::$status->setLastGet($request);
                $navigation = new Projektor2_Model_Navigation();
                $navigationLevel = new Projektor2_Model_NavigationLevel();
                $navigation->push($navigationLevel);
                if (self::$status->logger) {
                    $part[] = date('Y-m-d H:i:s');
                    $part[] = self::$status->user->username;
                    $part[] = self::$status->projekt->kod;
                    $part[] = self::$status->kancelar->kod;
                    $part[] = self::$status->beh->beh_cislo;
                    $part[] = self::$status->zajemce->id;
                    $part[] = self::$status->zajemce->identifikator;
                    $part[] = self::$status->sKurz->id_s_kurz;
                    $part[] = $request->isGet() ? 'GET' : ($request->isPost() ? 'POST' : 'METHOD NOT RECOGNIZED');
                    $part[] = preg_replace("/\s+/u", " : ", print_r($request->getArray(), true));
//                    $part[] = preg_replace("/\s+/u", " : ", print_r($request->postArray(), true));
                    self::$status->logger->log(implode(' | ', $part));
                }

            } catch (Projektor2_Auth_Exception $exception) {
                self::$status->setAuthCookie();
                self::$status->setProjekt();
                self::$status->setKancelar();
                self::$status->setBeh();
                self::$status->setUser();
                self::$status->setZajemce();
                self::$status->setSKurz();
            }
        }
        return self::$status;
    }

    public function persistSessionStatus(Projektor2_Request $request, Projektor2_Response $response) {
        //buď nastaví nebo vymaže cookie, pokud proměnná je FALSE, všechny cookie jsou expirovány na konci sesion (doba expirace není zadána)
        if (isset($this->authCookie)) {
            $this->authCookie->set();
        } else {
            $response->setCookie('userId', NULL);
        }
        if (isset($this->user)) {
            $response->setCookie('userId', $this->user->id);
        } else {
            $response->setCookie('userId', NULL);
        }
        if (isset($this->projekt)) {
            $response->setCookie('projektId', $this->projekt->id);
        } else {
            $response->setCookie('projektId', NULL);
        }
        if (isset($this->kancelar)) {
            $response->setCookie('kancelarId', $this->kancelar->id);
        } else {
            $response->setCookie('kancelarId', NULL);
        }
        if (isset($this->beh)) {
            $response->setCookie('behId', $this->beh->id);
        } else {
            $response->setCookie('behId', NULL);
        }
        if (isset($this->akce)) {
            $response->setCookie('akce', $this->akce);
        } else {
            $response->setCookie('akce', NULL);
        }
        if (isset($this->zajemce)) {
            $response->setCookie('zajemceId', $this->zajemce->id);
        } else {
            $response->setCookie('zajemceId', NULL);
        }
        if (isset($this->sKurz)) {
            $response->setCookie('sKurzId', $this->sKurz->id_s_kurz);
        } else {
            $response->setCookie('sKurzId', NULL);
        }
    }

    /**
     *
     * @return Projektor2_Model_SessionStatus
     */
    public static function getSessionStatus() {
        return self::$status;
    }
}

