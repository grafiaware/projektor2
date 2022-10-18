<?php

/**
 * Description of SKurz
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_SKurz extends Projektor2_Controller_Formular_Base {

    const S_KURZ = 'sKurz';

    protected function createFormModels() {
        $this->models[self::S_KURZ] = $this->sessionStatus->sKurz->id_s_kurz
                ? Projektor2_Model_Db_SKurzMapper::get($this->sessionStatus->sKurz->id_s_kurz)
                : Projektor2_Model_Db_SKurzMapper::create($this->sessionStatus->projekt, $this->sessionStatus->kancelar);
    }

    public function getResult() {
        $this->createFormModels();
        if ($this->request->isPost()) {
            $this->setModelsFromPost($this->request->postArray());
            // nový sKurz vytvořen v createFormModels() pomocí Projektor2_Model_Db_SKurzMapper::create => proběhl INSERT před první zobrazením formuláře a sKurz má vždy id
            Projektor2_Model_Db_SKurzMapper::update($this->models[self::S_KURZ]);
        }
        $context = $this->createContextFromModels(true);
        return (new Projektor2_View_HTML_Formular_SKurz($this->sessionStatus, $context))->render();
    }
}
