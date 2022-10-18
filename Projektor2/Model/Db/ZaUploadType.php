<?php
class Projektor2_Model_Db_ZaUploadType implements Framework_Model_AttributeModelInterface {

    public $type;
    public $popis;

    public function __construct($type, $popis) {
        $this->type = $type;
        $this->popis = $popis;
    }

}

