<?php
class Projektor2_Model_Db_UploadType {
    //tabulka zajemce
    CONST TABLE = "upload_type";

    public $type;
    public $popis;

    public function __construct($popis, $type=null) {
        $this->type = $type;
        $this->popis = $popis;
    }

}

