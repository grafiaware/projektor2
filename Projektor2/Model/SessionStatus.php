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
class Projektor2_Model_SessionStatus {
    protected static $userId;
    protected static $behId;
    protected static $ucastnikId;
    protected static $zajemceId;

    /**
     * Poslední načtený stav
     * @var Projektor2_Model_SessionStatus
     */
    protected static $sessionStatus;

    /**
     * @var Projektor2_Auth_Cookie
     */
    public $authCookie;

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
     * @var Framework_Logger_File
     */
    public $logger;


    public function __get($name) {
        return $this->$name;   //TODO: nekontroluje existenci vlastnosti
    }

    public function __set($name, $value) {
        return FALSE; //TODO: nehlasi zadnym způsobem chybné volání
    }

    public function setAuthCookie(Projektor2_Auth_Cookie $authCookie=NULL) {
        $this->authCookie = $authCookie;
        return $this;
    }

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

    /**
     * Metoda vytvoří session status z cookies nastavených login procesem
     * @return Projektor2_Model_SessionStatus
     * @throws Exception
     */
    public static function createSessionStatus(Projektor2_Request $request, Projektor2_Response $response, Framework_Logger_File $logger=NULL) {
        if (!self::$sessionStatus) {   //sigleton
            self::$sessionStatus = new Projektor2_Model_SessionStatus();
            try {
                self::$sessionStatus->logger = $logger;
                $authCookie = new Projektor2_Auth_Cookie($request, $response);  // injekt response, Projektor2_Auth_Cookie sama nastaví cookie v responsu
                $authCookie->validate();  // při neúspěšné validaci vyhazuje výjimku
                self::$sessionStatus->setAuthCookie($authCookie);
                // user z auth cookie
                $user = Projektor2_Model_Db_SysUserMapper::findById($authCookie->get_userid());
                if(!$user) {
                    throw new Exception("Neexistuje uživatel s nastavenou identitou.");
                }
                self::$sessionStatus->setUser($user);
                // projekt z cookie
                self::$sessionStatus->setProjekt(Projektor2_Model_Db_ProjektMapper::findById($request->cookie('projektId')));
                // kancelar z cookie
                self::$sessionStatus->setKancelar(Projektor2_Model_Db_KancelarMapper::getValid($request->cookie('kancelarId')));
                // beh z cookie
                self::$sessionStatus->setBeh(Projektor2_Model_Db_BehMapper::findById($request->cookie('behId')));
                // akce z cookie
                self::$sessionStatus->setAkce($request->cookie('akce'));
                // zajemce z cookie
                $zajemce = Projektor2_Model_Db_ZajemceMapper::get($request->cookie('zajemceId'));
                self::$sessionStatus->setZajemce($zajemce);
                // sKurz z cookie
                $sKurz = Projektor2_Model_Db_SKurzMapper::get($request->cookie('sKurzId'));
                self::$sessionStatus->setSKurz($sKurz);
                $navigation = new Projektor2_Model_Navigation();
                $navigationLevel = new Projektor2_Model_NavigationLevel();
                $navigation->push($navigationLevel);
                if (self::$sessionStatus->logger) {
                    $part[] = date('Y-m-d H:i:s');
                    $part[] = self::$sessionStatus->user->username;
                    $part[] = self::$sessionStatus->projekt->kod;
                    $part[] = self::$sessionStatus->kancelar->kod;
                    $part[] = self::$sessionStatus->beh->beh_cislo;
                    $part[] = self::$sessionStatus->zajemce->id;
                    $part[] = self::$sessionStatus->zajemce->identifikator;
                    $part[] = self::$sessionStatus->sKurz->id_s_kurz;
                    $part[] = $request->isGet() ? 'GET' : ($request->isPost() ? 'POST' : 'METHOD NOT RECOGNIZED');
                    $part[] = preg_replace("/\s+/u", " : ", print_r($request->getArray(), true));
//                    $part[] = preg_replace("/\s+/u", " : ", print_r($request->postArray(), true));
                    self::$sessionStatus->logger->log(implode(' | ', $part));
                }

            } catch (Projektor2_Auth_Exception $exception) {
                self::$sessionStatus->setAuthCookie();
                self::$sessionStatus->setProjekt();
                self::$sessionStatus->setKancelar();
                self::$sessionStatus->setBeh();
                self::$sessionStatus->setUser();
                self::$sessionStatus->setZajemce();
                self::$sessionStatus->setSKurz();
            }
        }
        return self::$sessionStatus;
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
        return self::$sessionStatus;
    }
}

?>
