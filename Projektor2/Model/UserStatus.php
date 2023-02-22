<?php

/**
 * Description of AppStatus
 *
 * @author pes2704
 */
class Projektor2_Model_UserStatus {

    /**
     * @var Projektor2_Model_Db_SysUser
     */
    private $user;

    /**
     * @var Projektor2_Model_Db_Kancelar
     */
    private $kancelar;

    /**
     * @var Projektor2_Model_Db_Projekt
     */
    private $projekt;

    /**
     * @var Projektor2_Model_Db_Beh
     */
    private $beh;

    /**
     * @var string
     */
    private $akce;

    /**
     * @var Projektor2_Model_Db_Zajemce
     */
    private $zajemce;

    /**
     * @var Projektor2_Model_Db_SKurz
     */
    private $sKurz;

    public function __construct(Projektor2_Model_Db_SysUser $user) {
        $this->user = $user;
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


#######################

    public function getUser(): ?Projektor2_Model_Db_SysUser {
        return $this->user;
    }

    public function getKancelar(): ?Projektor2_Model_Db_Kancelar {
        return $this->kancelar;
    }

    public function getProjekt(): ?Projektor2_Model_Db_Projekt {
        return $this->projekt;
    }

    public function getBeh(): ?Projektor2_Model_Db_Beh {
        return $this->beh;
    }

    public function getAkce(): string {
        return $this->akce;
    }

    public function getZajemce(): ?Projektor2_Model_Db_Zajemce {
        return $this->zajemce;
    }

    public function getSKurz(): ?Projektor2_Model_Db_SKurz {
        return $this->sKurz;
    }
}
