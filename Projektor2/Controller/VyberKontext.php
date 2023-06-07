<?php
/**
 * Description of Projektor2_Controller_VyberKontext
 *
 * @author pes2704
 */
class Projektor2_Controller_VyberKontext extends Projektor2_Controller_Abstract {

    private function performPostActions() {
        if ($this->request->isPost()) {
            if ($this->request->post('id_kancelar')) {
                $kancelar = Projektor2_Model_Db_KancelarMapper::getValid($this->request->post('id_kancelar'));
                $this->sessionStatus->getUserStatus()->setKancelar($kancelar);
            }
            if ($this->request->post('id_beh')) {
                switch ($this->request->post('id_beh')) {
                    case 'ß':
                            $this->sessionStatus->getUserStatus()->setBeh();
                        break;
                    default:
                            $beh = Projektor2_Model_Db_BehMapper::findById($this->request->post('id_beh'));
                            $this->sessionStatus->getUserStatus()->setBeh($beh);
                            $selectedBeh = TRUE;
                        break;
                }
            }

        }
    }

    /**
     * Kontext akce přepne GET i POST parametr
     */
    private function performAnyRequestActions() {
        // odkaz z tlačítka Formular menu nové id_zajemce -> změna zájemce v session
        if ($this->request->get('id_zajemce')) {
            $zajemce = Projektor2_Model_Db_ZajemceMapper::get($this->request->get('id_zajemce'));
            $this->sessionStatus->getUserStatus()->setZajemce($zajemce);
            $beh = Projektor2_Model_Db_BehMapper::findById($zajemce->id_s_beh_projektu_FK);
            $this->sessionStatus->getUserStatus()->setBeh($beh);
        }
        // odkaz z left menu Nová osoba - smazání zájemce ze session
        if ($this->request->get('form')===Projektor2_Router_Form::CTRL_NOVA_OSOBA) {  // hodnota je prázdný string
            $this->sessionStatus->getUserStatus()->setZajemce();
        }
        // odkaz z tlačítka kurz menu nové id_s_kurz -> změna kurzu v session
        if ($this->request->get('id_s_kurz')) {
            $sKurz = Projektor2_Model_Db_SKurzMapper::get($this->request->get('id_s_kurz'));
            $this->sessionStatus->getUserStatus()->setSKurz($sKurz);
        }
        // odkaz z left menu Nový kurz - smazání kurzu ze session
//            if ($this->request->get('novy_kurz')==="") {  // hodnota je prázdný string
//                $this->sessionStatus->getUserStatus()->setSKurz();
//            }
        // odkaz z formaction buttonu výběr akce
        if ($this->request->get('akce')) {
            $this->sessionStatus->getUserStatus()->setAkce($this->request->get('akce'));
        }
    }
    
    public function getResult() {
        if ($this->request->isPost()) {  // proměnná z query v form action
            $this->performPostActions();
        }
        $this->performAnyRequestActions();
        
        // obsah zobrazený vždy
        $idKancelari = Projektor2_Model_Db_SysAccUsrKancelarMapper::getIndexArray('id_c_kancelar', 'id_sys_users='.$this->sessionStatus->getUserStatus()->getUser()->id);
        if (isset($idKancelari)) {
            $kancelare = Projektor2_Model_Db_KancelarMapper::findValid(
                    'id_c_projekt_FK='.$this->sessionStatus->getUserStatus()->getProjekt()->id.' AND id_c_kancelar IN ('.implode(', ', $idKancelari).')', 'razeni ASC'
                    );
        } else {
            $kancelare = array();
        }

        $parts[] = new Projektor2_View_HTML_KontextKancelarAkce($this->sessionStatus,
                array(
                    'kancelare'=>$kancelare,
                    'id_kancelar'=>isset($this->sessionStatus->getUserStatus()->getKancelar()->id) ? $this->sessionStatus->getUserStatus()->getKancelar()->id : NULL
                    )
                );

        // podmínka pro pokračování - obsah zobrazený při úplném kontextu
        if ($this->sessionStatus->getUserStatus()->getKancelar() ) {
//            if ($this->sessionStatus->akce!='osoby' OR isset($this->sessionStatus->getUserStatus()->getBeh())) {
                $parts[] = (new Projektor2_Router_Akce($this->sessionStatus, $this->request, $this->response))->getController()->getResult();
//            }

        }


        $viewVybery = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$parts));
        return $viewVybery;
    }
}

