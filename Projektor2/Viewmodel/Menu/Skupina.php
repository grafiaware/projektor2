<?php
/**
 * Description
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_Skupina {
    public $menuTlacitka = array();
    public $menuSignaly = array();

    public function setMenuTlacitko($name, Projektor2_Viewmodel_Menu_TlacitkoInterface $tlacitko) {
        $this->menuTlacitka[$name] = $tlacitko;
    }

    /**
     *
     * @param string $name
     * @return Projektor2_Viewmodel_Menu_TlacitkoOsoba
     */
    public function getMenuTlacitko($name) {
        return $this->menuTlacitka[$name];
    }

    /**
     *
     * @return Projektor2_Viewmodel_Menu_TlacitkoOsoba[]
     */
    public function getMenuTlacitkaAssoc() {
        return $this->menuTlacitka;
    }

    public function setMenuSignal($name, Projektor2_Viewmodel_Menu_Signal $signal) {
        $this->menuSignaly[$name] = $signal;
    }

    /**
     *
     * @param string $name
     * @return Projektor2_Viewmodel_Menu_Signal
     */
    public function getMenuSignal($name) {
        return $this->menuSignaly[$name];
    }

    /**
     *
     * @return Projektor2_Viewmodel_Menu_Signal[]
     */
    public function getMenuSignalyAssoc() {
        return $this->menuSignaly;
    }

 }
