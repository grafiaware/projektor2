<?php
/**
 * Trasformátor hodnot ve flat tabulkách projektoru.
 * 
 * @author pes2704
 */
class Transformer_Controller {   
    
    private $saveValues = FALSE;
    
    /**
     * 
     * Transformuje hodnoty ve flat tabulkách přidružených k zájemcům z jednoho projektu. 
     * 
     * Zájemce načte z databáze s použitím zadaného id projektu, databázi použije tu, kterou vrací metoda Projektor2_AppContext::getDbh(). 
     * 
     * Pro transformaci hodnot použije closure zadané jako parametr. Transformer volá zadanou closure pro transformaci vždy se dvěma parametry. 
     * Prvním parametrem je vždy hodnota k transformaci (t.j. hodnota vlastnosti modelu) a druhým parametrem je název vlastnosti modelu. 
     * Transformační closure pro transformaci může přijímat žádný, jeden nebo dva parametry. 
     * 
     * Volání closure bez parametru se hodí, pokud chcete vkládat do všech vlastností (a tedy ukládat do všech sloupců flat tabulek) 
     * hodnotu nezávislou na předchozím obsahu. 
     * Volání s jedním parametrem se hodí, pokud chcete transformovat hodnotu všech sloupců a řídit se přotom jen hodnotou vlastnosti.
     * Volání se dvěma parametry se hodí, pokud chcete transformovat hodnotu jen některých sloupců, můžete se řídit hodnotou vlastnosti i jménem vlastnoti 
     * (ta odpovídá jménu sloupce db tabulky).
     * 
     * Transformátor transformované hodnoty skutečně ukládá do databáze pouze v případě, že před metodou run() je zavolána metoda 
     * setSaveTransformedValuesToDatabase(TRUE) s parametrem TRUE. To je jen malá ochrana. Pokud tedy nebude zavolána setSaveTransformedValuesToDatabase(TRUE), 
     * pak metoda pouze provádí transformaci a pokud je zadán logger, loguje.
     * 
     * Metodu lze volat s parametrem logger a pak provádí logování změněných (trasformovaných) hodnot (metodou loggeru info()) a pokud je spuštěno skutečné ukládání
     * do databáze, provádí logování ukládaných hodnot (metodou loggeru debug()).
     * 
     * @param type $idProjektu
     * @param Closure $valueTransformingClosure
     * @param LoggerInterface $logger Nepovinný logger
     */
    public function run($idProjektu, Closure $valueTransformingClosure, Psr\Log\LoggerInterface $logger=NULL) {
        assert(FALSE, 'Není otestováno! Změnil jsem transformační closures - používají DateTime místo regulárních výrazů a jsou obousměrné - testovat.');
        $newFilter = ' id_c_projekt_FK = :id_c_projekt_FK';           // filtr dle projektu    
        $newFilterBindParams = array('id_c_projekt_FK'=>$idProjektu);          // id projektu                      
        $zajemci =  Projektor2_Model_Db_ZajemceMapper::find($newFilter, $newFilterBindParams, NULL, TRUE, FALSE);   
        
        foreach ($zajemci as $zajemce) {
            $models = $this->createModels($zajemce);
           
            $logger->info( PHP_EOL . '**************** Pro zajemce ' . $zajemce->identifikator . ' *************************');
            foreach ($models as $model) {
                $this->transformModel($model, $valueTransformingClosure);                

                if ($logger AND $model->getChanged()) {
                    
                    $logger->info('Transformovány hodnoty:'.PHP_EOL.
                            'zajemce: id '.$zajemce->id.' identifikator '.$zajemce->identifikator.PHP_EOL.
                            'Tabulka: '.$model->getTableName().PHP_EOL.
                            'Model: '.get_class($model).PHP_EOL.
                            print_r($model->getChanged(), TRUE));
                }
                if ($this->saveValues) {
                    $model->save();
                    if ($logger) {
                        $logger->debug('Uložen záznam:'.PHP_EOL.
                            'zajemce: id '.$zajemce->id.' identifikator '.$zajemce->identifikator.PHP_EOL.
                            'Tabulka: '.$model->getTableName().PHP_EOL.
                            'Model: '.get_class($model).PHP_EOL.
                            print_r($model->getValuesAssoc(), TRUE));
                    }
                }
            }
            
            
        }
    }
    
    /**
     * Zavoláním této metody s parametrem=TRUE se spustí skutečné ukládání transformovaných hodnot do databáze. Metoda run() potom skutečně ukládá
     * výsledné hodnoty do databáze.
     * @param type $saveValues
     */
    public function setSaveTransformedValuesToDatabase($saveValues=FALSE) {
        $this->saveValues = $saveValues;
        return $this;
    }
    
    /**
     * Vytvoří modely
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Framework_Model_ItemFlatTable array of
     */
    protected function createModels(Projektor2_Model_Db_Zajemce $zajemce) {
         $models['dotaznik']= new Projektor2_Model_Db_Flat_ZaOsobniFlatTable($zajemce);
         $models['plan'] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce); 
         $models['ukonceni'] = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce); 
         $models['zamestnani'] = new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce); 
         return $models;
    }
    
    /**
     * Ve vlastnostech modelu nahrazuje hodnoty pomocí zadané closure.
     * @param Framework_Model_ItemFlatTable $model
     * @param Closure $valueTransformingClosure
     * @return \Framework_Model_ItemFlatTable
     */
    protected function transformModel(Framework_Model_DbItemFlatTable $model, Closure $valueTransformingClosure) {
        $idName = $model->getIdName();
        foreach ($model as $key => $value) {
            if ($key != $idName) {      // nezkouší měnit hodnotu primárního klíče - to by vyvolalo chybu
                $newValue = $valueTransformingClosure($value, $key);
                if ($newValue != $value) {      // mění vlastnost modelu jen pokud nová hodnota je odlišná od staré
                    $model->$key = $newValue;
                }             
            }           
        }
        return $model;
    }
}
