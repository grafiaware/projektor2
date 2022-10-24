<?php
/**
 * Description
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_Skupina {
    public $menuTlacitka = array();
    public $menuSignaly = array();

    public function setMenuTlacitko(Projektor2_Viewmodel_Menu_TlacitkoInterface $tlacitko) {
        $this->menuTlacitka[] = $tlacitko;
    }

    /**
     *
     * @return Projektor2_Viewmodel_Menu_TlacitkoOsoba[]
     */
    public function getMenuTlacitka() {
        return $this->menuTlacitka;
    }

    public function setMenuSignal(Projektor2_Viewmodel_Menu_Signal $signal) {
        $this->menuSignaly[] = $signal;
    }

    /**
     *
     * @return Projektor2_Viewmodel_Menu_Signal[]
     */
    public function getMenuSignaly() {
        return $this->menuSignaly;
    }

 }
