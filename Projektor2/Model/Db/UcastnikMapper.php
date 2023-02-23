<?php
class Projektor2_Model_Db_UcastnikMapper {
    
    public static function find_by_id($id) {
        $dbh = Config_AppContext::getDb();
        $query = "SELECT ucastnik.id_ucastnik,
                        ucastnik.cislo_ucastnika,
                        ucastnik.identifikator,
                        ucastnik.id_s_beh_projektu_FK as beh_id,
                        c_kancelar.id_c_kancelar,
                        c_kancelar.kod as kancelar_kod,
                        c_kancelar.text as kancelar_text,
                        c_kancelar.plny_text as kancelar_plny_text,
                        c_projekt.id_c_projekt,
                        c_projekt.text as projekt_text,
                        c_projekt.kod as projekt_kod,
                        c_projekt.plny_text as projekt_plny_text
                        FROM
                        ucastnik ,
                        c_kancelar ,
                        c_projekt
                        WHERE
                        ucastnik.id_c_projekt_FK = c_projekt.id_c_projekt AND
                        ucastnik.id_c_kancelar_FK = c_kancelar.id_c_kancelar AND
                        ucastnik.id_ucastnik = :id_ucastnik  AND ucastnik.valid = 1";
        
        $bindParams = array(id_ucastnik=>$id);;
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        //print_r($data);
        $Projekt = new Projektor2_Model_Db_Projekt($data['id_c_projekt'],$data['projekt_kod'],$data['projekt_text'],$data['projekt_plny_text']);
        $Kancelar = new Projektor2_Model_Db_Kancelar($data['id_c_kancelar'],$data['kancelar_kod'],$data['kancelar_text'],$data['kancelar_plny_text']);
        $Beh = Projektor2_Model_Db_BehMapper::findById($data['beh_id']);
        return new Projektor2_Model_Db_Ucastnik($Projekt,$Kancelar,$Beh,$data['id_ucastnik'],$data['cislo_ucastnika'],$data['identifikator']);
    }
    
    public static function insert(Projektor2_Model_Db_Ucastnik $Ucastnik) {
        if(!$Ucastnik->getUserStatus()->getKancelar()->id && !$Ucastnik->getUserStatus()->getProjekt()->id && !$Ucastnik->getUserStatus()->getBeh()->id) {
            throw new Exception ("Cannot create new ucastnik - kancelar,projekt,beh - one or more are not setted or setted improperly");
        }
        
        $dbh = Config_AppContext::getDb();
        
        //$query="call new_ucastnik(:1,:2,:3)";
        //$dbh->prepare($query)->execute($Ucastnik->getUserStatus()->getProjekt()->id,$Ucastnik->getUserStatus()->getKancelar()->id,$Ucastnik->getUserStatus()->getBeh()->id);
        
         //-----------------------novy ucastnik - nahrada za uloz proceduru-----------------
        $query = "DELETE from ucastnik where identifikator=0"; 
        $dbh->prepare($query)->execute();
        
        
        $query = "SELECT Max(ucastnik.cislo_ucastnika)as maxU  FROM ucastnik 
                  WHERE ( (ucastnik.id_c_projekt_FK = " . $Ucastnik->getUserStatus()->getProjekt()->id  . ") " .
                          " and  (ucastnik.id_c_kancelar_FK = " . $Ucastnik->getUserStatus()->getKancelar()->id . ") )";
        $data = $dbh->prepare($query)->execute()->fetch();
        if ($data['maxU']) {
            $nove_cislo_ucastnika= $data['maxU'] + 1 ;
        }
        else {
            $nove_cislo_ucastnika = 1;
        }
        
             // echo "* nove cislo ucastnika * "  . $nove_cislo_ucastnika;
       
        $query = "INSERT INTO  ucastnik (cislo_ucastnika, id_c_projekt_FK, id_c_kancelar_FK,id_s_beh_projektu_FK )
                  VALUES ( :1, :2, :3, :4 )"; 
        $dbh->prepare($query)->execute(array($nove_cislo_ucastnika ,$Ucastnik->getUserStatus()->getProjekt()->id,$Ucastnik->getUserStatus()->getKancelar()->id,$Ucastnik->getUserStatus()->getBeh()->id));             
        
        // exit;
        //-----------------------novy ucastnik - nahrada za uloz proceduru - konec----------------- 
        
        
        
        $query="SELECT id_ucastnik,cislo_ucastnika
                    FROM ucastnik
                    WHERE id_ucastnik = last_insert_id();";
        
        list($Ucastnik->id,$Ucastnik->cislo)=$dbh->prepare($query)->execute()->fetch_row();
        
        
        $Identifikator = new Projektor2_ItemID($Ucastnik->getUserStatus()->getProjekt()->id,$Ucastnik->getUserStatus()->getKancelar()->id,1);
       
        
        $Identifikator->u_cislo_polozky = $Ucastnik->cislo;
        $Identifikator->c_cislo_behu = $Ucastnik->getUserStatus()->getBeh()->beh_cislo;                              /*ss*/
        $Identifikator->c_oznaceni_turnusu = $Ucastnik->getUserStatus()->getBeh()->oznaceni_turnusu;                                                                                         
//echo $Identifikator->c_cislo_behu;
        $Ucastnik->identifikator=$Identifikator->generuj_cislo();
        $query="UPDATE ucastnik
                SET identifikator = :1
                WHERE id_ucastnik = :2;";
        $dbh->prepare($query)->execute(array($Ucastnik->identifikator,$Ucastnik->id));
        return $Ucastnik;
    }
}

?>