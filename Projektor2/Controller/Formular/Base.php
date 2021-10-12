<?php
/**
 * Description of Projektor2_Controller_Formular_Base
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_Base extends Projektor2_Controller_Abstract {

    const  MODEL_SEPARATOR = '->';
    
    /**
     * Další modely formuláře, které budou naplňovány daty a ukládány po odeslání fotmuláře-
     * @var type 
     */
    protected $models;
    
    /**
     * Potomkovské třídy musí implementovat matodu getFlatTable, která vrací vlastní flat table
     */
    abstract protected function createFormModels($zajemce);
    
    /**
     * Potomkovské třídy musí implementovat matodu getResultFormular, která vrací html kód vlastního formuláře
     */
    abstract protected function getResultFormular();
    
    /**
     * Potomkovské třídy musí implementovat metodu getResultPdf, která vytvoří pdf dokument a vrátí kód 
     * pro zobrazení pdf dokumentu v novém panelu prohlížeče.
     * Pokud k formuláři není přisružen pdf dokument, bude taková metoda prázdná.
     */
    abstract protected function getResultPdf();  // TODO - viz tot v kontroleru - všechna vytváření pdf so service, zbytek z getResultPdf do getResultFormular a ten přejmenovat na getResult
    
    public function getResult() {
        $htmlResult = '';

        if ($this->request->isPost()) {
            // ukládání dat modelů flat table
            $this->createFormModels($this->sessionStatus->zajemce);  // pokud není $this->sessionStatus->zajemce vytvoří při volání flat table->save() nový zájemce
            $this->setModelsFromPost($this->request->postArray());   // ->postObject());????   //
            $this->saveModels();

        } else { // request == GET
            // odkaz z tlačítka Formular menu
            // nové id_zajemce -> změna zájemce
            if ($this->request->get('id_zajemce')) {
                $zajemce = Projektor2_Model_Db_ZajemceMapper::get($this->request->get('id_zajemce'));
                $this->sessionStatus->setZajemce($zajemce);
            }
            if ($this->sessionStatus->zajemce) {
                $this->createFormModels($this->sessionStatus->zajemce);
            }            
        }
        
        // formulář
        $htmlResult .= $this->getResultFormular();
        // javascript pro stažení pdf
        if ($this->request->isPost() AND ($this->request->post('T1') OR $this->request->post('pdf'))) {
            $htmlResult .= $this->getResultPdf();
        }
        return $htmlResult;        
    }
    
    protected function createContextFromModels($transformValuesForHtml=FALSE) {
        if ($this->models) {
            foreach ($this->models as $modelSign => $model) {
                $assoc = $model->getValuesAssoc();
                foreach ($assoc as $key => $value) {
                    if ($transformValuesForHtml) {
                        $value = $this->transformDatumToRfc($key, $value);
                    }
                    $context[$modelSign.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$key] = $value;                        
                }
            }        
            return $context;
        }
    } 
    
    /**
     * Nastaví vlastnosti modelů ve poli $this->models podle proměnných v POST poli
     * @param type $post
     * @throws LogicException
     * @throws UnexpectedValueException
     */
    protected function setModelsFromPost($post) {
        foreach ($post as $key => $value) {
                     
            $keys = explode(Projektor2_Controller_Formular_Base::MODEL_SEPARATOR, $key);
            $cnt = count($keys);
            switch ($cnt) {
                case 1:
//                    loguj('V názvu post proměnné '.$key. 'není ani jeden separátor ->.');
                    break;
                case 2:
                    if (array_key_exists($keys[0], $this->models)) {
                        $modelSignature = $keys[0];
                        $model = $this->models[$modelSignature];
                        $model->{$keys[1]} = $this->transformDateToCzech($keys[1], $value);
                    } else {
                        throw new LogicException('Název post proměnné '.$key.' neodpovídá žádnému nastavenému modelu formulářového kontroleru '.get_called_class().'.');
                    }
                    break;
                case 3:
                    $multiselectPrefix = Projektor2_View_HTML_Element_PlanFieldset::MULTI_SELECTED_VARIABLE_PREFIX;
                    if (array_key_exists($keys[0], $this->models) AND strpos($keys[2], $multiselectPrefix)==0) {
                        $index = substr($keys[2], strlen($multiselectPrefix));
                        $modelSignature = $keys[0];
                        $model = $this->models[$modelSignature][$index];
                        $model->{$keys[1]} = $this->transformDateToCzech($keys[1], $value);                       
                    } else {
                        throw new LogicException('Název post proměnné '.$key.' neodpovídá žádnému nastavenému modelu formulářového kontroleru '.get_called_class().' nebo má chybnou syntaxi.');
                    }                    
                    break;
                default:
                    throw new UnexpectedValueException('V názvu post proměnné '.$key. 'je více než jeden separátor ->.');
            }
        }
    }

    protected function saveModels() {
        if ($this->sessionStatus->user->povolen_zapis) {
            if ($this->models) {
                foreach ($this->models as $model) {
                    // zde se vytvoří hlavní objekt (např. zajemce) k flat table (např. za_flat_table), ktera nema hlavní objekt 
                    // v případě, že model flat table toto chování umožňuje - nastaveno pro ten formulář, který má mít funkci založení nového hlavního objektu
                    // (to je nastaveno v konstruktoru konkrétní flat table)
                    $model->save();   
                    if ($model->isCreatedNewMainObject()) {
                        $zajemce = $model->getMainObject();
                        $this->sessionStatus->setZajemce($zajemce);  
                    }
                }
            }
        }        
    }
    
    ######### DATUMY ################
    private function transformDatumToRfc($key, $value) {
        if ($this->jeToProjektoroveDatum($key) AND $value) {      
            $value = $this->toRfc($value);
        }
        return $value;
    }
    
    private function transformDateToCzech($key, $value) {
        if ($this->jeToProjektoroveDatum($key) AND $value) {      
            $value = $this->toCzech($value);
        }
        return $value;
    }

    /**
     * Název sloupce obsahuje substring datum_
     * @param type $columnName
     * @return type
     */
    private function jeToProjektoroveDatum($columnName) {
        return strpos($columnName, 'datum_')!==FALSE ? TRUE : FALSE;
    }
    
    private function toCzech($value) {
        $datetime = DateTime::createFromFormat('Y-m-d', $value);
        if ($datetime) {
            return $datetime->format('j.n.Y');
        } else {
            throw new UnexpectedValueException('Chybný vstupní formát datumu RFC: '.$value);
        } 
    }
    
    private function toRfc($value) {
        // opraví chyby v datech projektoru - vynechá mezery mezi čísly vzniklé v době před používáním datepickeru
        $value = preg_replace('/\s+/', '', $value);
        $datetime = DateTime::createFromFormat('j.n.Y', $value);
        if ($datetime) {
            return $datetime->format('Y-m-d');
        } else {
            throw new UnexpectedValueException('Chybný vstupní formát českého datumu: '.$value.'. Objekt '.get_called_class().', id '.$this->id);
        }        
    }    
}

