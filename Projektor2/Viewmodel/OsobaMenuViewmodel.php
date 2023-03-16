<?php
class Projektor2_Viewmodel_OsobaMenuViewmodel {

    public $id;
    public $jmeno_cele;
    public $identifikator;
    public $znacka;

    private  $groups = array();

    public function __construct(Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        $this->id = $zajemceDbReadOsobniUdaje->id;
        $this->jmeno_cele = $this->jmenoCele($zajemceDbReadOsobniUdaje);
        $this->identifikator = $zajemceDbReadOsobniUdaje->identifikator;
        $this->znacka = $zajemceDbReadOsobniUdaje->znacka;
    }

    /**
     * Vrací celé jméno složené zleva z příjmení, křestního jména, titulu před, titulu za jménem. Tento formát je vhodný pro abecední řazení
     * podle celého jména.
     * @return string
     */
    private function jmenoCele(Projektor2_Model_Db_Read_ZajemceOsobniUdaje $zajemceDbReadOsobniUdaje) {
        return implode(' ', array($zajemceDbReadOsobniUdaje->prijmeni, $zajemceDbReadOsobniUdaje->jmeno, $zajemceDbReadOsobniUdaje->titul, $zajemceDbReadOsobniUdaje->titul_za)); //začíná příjmením
    }

    public function addGroup(Projektor2_Viewmodel_Menu_Group $group) {
        $this->groups[] = $group;
    }

    public function getGroups() {
        return $this->groups;
    }
}
