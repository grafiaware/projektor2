<?php
/**
 * Description of Projektor2_Controller_VyberKontext
 *
 * @author pes2704
 */
class Projektor2_Controller_VyberKontext extends Projektor2_Controller_Abstract {

    private function performPostActions() {
        if ($this->request->isPost() AND null!==$this->request->get("kontext")) {
            if ($this->request->post('id_kancelar')) {
                switch ($this->request->post('id_kancelar')) {
                    case 'ß':
                            $this->sessionStatus->setKancelar();
                        break;
                    default:
                            $kancelar = Projektor2_Model_Db_KancelarMapper::findById($this->request->post('id_kancelar'));
                            $this->sessionStatus->setKancelar($kancelar);
                            $selectedKancelar = TRUE;
                        break;
                }
            }
            if ($this->request->post('id_beh')) {
                switch ($this->request->post('id_beh')) {
                    case 'ß':
                            $this->sessionStatus->setBeh();
                        break;
                    default:
                            $beh = Projektor2_Model_Db_BehMapper::findById($this->request->post('id_beh'));
                            $this->sessionStatus->setBeh($beh);
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
        if ($this->request->param('akce')) {
            $this->sessionStatus->akce = $this->request->param('akce');
        }
    }

    public function getResult() {
        if ($this->request->isPost()) {  // proměnná z query v form action
            $this->performPostActions();
            $this->performAnyRequestActions();
        } else {
            $this->performAnyRequestActions();
            // odkaz z tlačítka Formular menu nové id_zajemce -> změna zájemce v session
            if ($this->request->get('id_zajemce')) {
                $zajemce = Projektor2_Model_Db_ZajemceMapper::get($this->request->get('id_zajemce'));
                $this->sessionStatus->setZajemce($zajemce);
                $beh = Projektor2_Model_Db_BehMapper::findById($zajemce->id_s_beh_projektu_FK);
                $this->sessionStatus->setBeh($beh);
            }
            // odkaz z left menu Nová osoba - smazání zájemce ze session
            if ($this->request->get('novy_zajemce')==="") {  // hodnota je prázdný string
                $this->sessionStatus->setZajemce();
            }
            // odkaz z tlačítka kurz menu nové id_s_kurz -> změna kurzu v session
            if ($this->request->get('id_s_kurz')) {
                $sKurz = Projektor2_Model_Db_SKurzMapper::get($this->request->get('id_s_kurz'));
                $this->sessionStatus->setSKurz($sKurz);
            }
            // odkaz z left menu Nový kurz - smazání kurzu ze session
            if ($this->request->get('novy_kurz')==="") {  // hodnota je prázdný string
                $this->sessionStatus->setSKurz();
            }
        }
        // obsah zobrazený vždy
        $idKancelari = Projektor2_Model_Db_SysAccUsrKancelarMapper::getIndexArray('id_c_kancelar', 'id_sys_users='.$this->sessionStatus->user->id);
        if (isset($idKancelari)) {
            $kancelare = Projektor2_Model_Db_KancelarMapper::find(
                    'id_c_projekt_FK='.$this->sessionStatus->projekt->id.' AND id_c_kancelar IN ('.implode(', ', $idKancelari).')', 'razeni ASC'
                    );
        } else {
            $kancelare = array();
        }

        $parts[] = new Projektor2_View_HTML_KontextKancelarAkce($this->sessionStatus,
                array('kancelare'=>$kancelare,
                    'id_kancelar'=>isset($this->sessionStatus->kancelar->id) ? $this->sessionStatus->kancelar->id : NULL,
                    'id_beh'=>isset($this->sessionStatus->beh->id) ? $this->sessionStatus->beh->id : NULL)
                );
        If ($this->sessionStatus->akce == 'osoby') {
//            $parts[] = new Projektor2_View_HTML_KontextBeh($this->sessionStatus,
//                array('behy'=>$behy,
//                    'id_beh'=>isset($this->sessionStatus->beh->id) ? $this->sessionStatus->beh->id : NULL)
//                );
        }
        // podmínka pro pokračování - obsah zobrazený při úplném kontextu
        if (isset($this->sessionStatus->kancelar) AND $this->sessionStatus->akce) {
//            if ($this->sessionStatus->akce!='osoby' OR isset($this->sessionStatus->beh)) {
                $parts[] = (new Projektor2_Router_Akce($this->sessionStatus, $this->request, $this->response))->getController()->getResult();
//            }

        }


        $viewVybery = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$parts));
        return $viewVybery;
    }
}

