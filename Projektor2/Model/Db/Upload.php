<?php
class Projektor2_Model_Db_Upload {
    //tabulka zajemce
    CONST TABLE = "upload";

    public $id_upload;
    public $id_zajemce_FK;
    public $id_upload_typ_FK;
    public $filename;
    public $creating_time;
    public $creator;
    public $service;
    public $db_host;


    public function __construct($id_zajemce_FK, $id_upload_typ_FK, $filename, $creator, $service, $db_host, $creating_time=null, $id_upload=null) {
        // autoincrement
        $this->id_upload = $id_upload;
        $this->id_zajemce_FK = $id_zajemce_FK;
        $this->id_upload_typ_FK = $id_upload_typ_FK;
        $this->filename = $filename;
        // cuurent timestamp
        $this->creating_time = $creating_time;
        $this->creator = $creator;
        $this->service = $service;
        $this->db_host = $db_host;
    }

}

