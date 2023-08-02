<?php
/**
 * Description
 *
 * @author pes2704
 */
class Projektor2_Viewmodel_Menu_Group {
    private $menuTlacitka = [];
    private $menuSignaly = [];

    public function addButton(Projektor2_Viewmodel_Menu_TlacitkoInterface $tlacitko) {
        $this->menuTlacitka[] = $tlacitko;
    }

    /**
     *
     * @return Projektor2_Viewmodel_Menu_TlacitkoInterface[]
     */
    public function getButtons() {
        return $this->menuTlacitka;
    }

    public function addSignal(Projektor2_Viewmodel_Menu_Signal $signal) {
        $this->menuSignaly[] = $signal;
    }

    /**
     *
     * @return Projektor2_Viewmodel_Menu_Signal[]
     */
    public function getSignals() {
        return $this->menuSignaly;
    }

 }
