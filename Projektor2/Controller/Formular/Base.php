<?php

use Pes\Utils\Directory;

/**
 * Description of Projektor2_Controller_Formular_Base
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_Base extends Projektor2_Controller_Abstract {

    const UPLOADED_KEY = "filesuploaded";

    const MODEL_SEPARATOR = '->';
    const ITEM_SEPARATOR = ':';

    /**
     * Další modely formuláře, které budou naplňovány daty a ukládány po odeslání fotmuláře-
     * @var type
     */
    protected $models = [];

    /**
     * Potomkovské třídy musí implementovat matodu getFlatTable, která vrací vlastní flat table
     */
    abstract protected function createFormModels();

    protected function createContextFromCollectionFlatTable($modelSign, Framework_Model_CollectionFlatTable $model, $transformValuesForHtml=FALSE) {
        foreach ($model as $collectionKey => $itemFT) {  // itemSign je primary key, itemModel je FT
            if ($itemFT instanceof Framework_Model_ItemFlatTable) {
                foreach ($itemFT as $key => $value) {
                    if ($transformValuesForHtml) {
                        $value = $this->transformForHtml($key, $value);
                    }
                    $context[$collectionKey]
                            [
                             $modelSign
                            .Projektor2_Controller_Formular_FlatTable::ITEM_SEPARATOR
                            .$collectionKey
                            .Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR
                            .$key
                            ] = $value;
                    }
            } else {
                throw new \LogicException("Položka kolekce modelů ". get_class($model)." s indexem $collectionKey je typu ".get_class($itemFT).", není Framework_Model_ItemFlatTable.");
            }
        }
        return $context;
    }

    protected function createContextFromItemFlatTable($modelSign, Framework_Model_ItemFlatTable $model, $transformValuesForHtml=FALSE) {
        foreach ($model as $key => $value) {
            if ($transformValuesForHtml) {
                $value = $this->transformForHtml($key, $value);
            }
            $context[$modelSign.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.$key] = $value;
        }
        return $context;
    }

    protected function createContextFromAttributeModel($modelSign, Framework_Model_AttributeModelInterface $model, $transformValuesForHtml=FALSE) {
        foreach ($model as $key => $value) {
            if ($transformValuesForHtml) {
                $value = $this->transformForHtml($key, $value);
            }
            $context[$modelSign.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR.$key] = $value;
        }
        return $context;
    }

    /**
     * Nastaví vlastnosti modelů ve poli $this->models podle proměnných v POST poli
     * @param type $post
     * @throws LogicException
     * @throws UnexpectedValueException
     */
    protected function setModelsFromPost($post) {
        foreach ($post as $key => $postValue) {
            list($modelSign, $attributeName) = explode(Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR, $key);
//          count($chunks) == 1      proměnná kontextu přidaná metodou assign(), tj. bez separátoru v názvu - neukládá se
            if(isset($modelSign) AND isset($attributeName)) {
                $parsedModelsign = explode(Projektor2_Controller_Formular_FlatTable::ITEM_SEPARATOR, $modelSign);
                switch (count($parsedModelsign)) {
                    case 1:
                        if (!array_key_exists($modelSign, $this->models)) {
                            throw new LogicException("První řetězec '$modelSign' v názvu post proměnné '$key' neodpovídá žádnému nastavenému modelu formulářového kontroleru ".get_called_class().".");
                        }
                        $this->models[$modelSign]->{$attributeName} = $this->transformForSql($this->models[$modelSign]->{$attributeName}, $attributeName, $postValue);
                        break;
                    case 2:
                        $collectionFT = $this->models[$parsedModelsign[0]];
                        if (isset($collectionFT)) {
                            /** @var Framework_Model_CollectionFlatTable $collectionFT */
                            $itemFT = $collectionFT->getItem($parsedModelsign[1]);
                            if (!isset($itemFT)) {
                               $itemFT = $collectionFT->addItem($parsedModelsign[1]);
                            }
                            $itemFT->{$attributeName} = $this->transformForSql($itemFT->{$attributeName}, $attributeName, $postValue);
                        }
                        break;
                    default:
                        throw new LogicException("První řetězec '$modelSign' v názvu post proměnné '$key' obsahujevíce než jeden separator '".Projektor2_Controller_Formular_FlatTable::ITEM_SEPARATOR.".");
                        break;
                }

            } else {
                // pro debug
                $nonModelValues[$key] = (string) $postValue;
            }
        }
    }

    protected function saveModels() {
        if ($this->sessionStatus->user->povolen_zapis) {
            foreach ($this->models as $model) {
                if ($model instanceof Framework_Model_CollectionFlatTable) {
                    // zde se vytvoří hlavní objekt (např. zajemce) k flat table (např. za_flat_table), ktera nema hlavní objekt
                    // v případě, že model flat table toto chování umožňuje - nastaveno pro ten formulář, který má mít funkci založení nového hlavního objektu
                    // (to je nastaveno v konstruktoru konkrétní flat table)
                    $model->save();
                    if ($model->isCreatedNewMainObject()) {
                        $zajemce = $model->getMainObject();
                        $this->sessionStatus->setZajemce($zajemce);
                    }
                } elseif ($model instanceof Framework_Model_ItemFlatTable) {
                    // zde se vytvoří hlavní objekt (např. zajemce) k flat table (např. za_flat_table), ktera nema hlavní objekt
                    // v případě, že model flat table toto chování umožňuje - nastaveno pro ten formulář, který má mít funkci založení nového hlavního objektu
                    // (to je nastaveno v konstruktoru konkrétní flat table)
                    $model->save();
                    if ($model->isCreatedNewMainObject()) {
                        $zajemce = $model->getMainObject();
                        $this->sessionStatus->setZajemce($zajemce);
                    }
                } elseif ($model instanceof Framework_Model_AttributeModelInterface) {

                }
            }
        }
    }

    protected function saveUploaded($uploadedFolderPath) {
        if ($_FILES) {
            $normalizedPath = Directory::createDirectory($uploadedFolderPath);
            foreach ($_FILES[self::UPLOADED_KEY]['name'] as $key => $name) {
                $uploadfile = trim($uploadedFolderPath, '/')."/".basename($name);
                if (move_uploaded_file($_FILES[self::UPLOADED_KEY]['tmp_name'][$key], $uploadfile)) {
                    echo "File is valid, and was successfully uploaded.\n";
                } else {
                    echo "Possible file upload attack!\n";
                }

            }
        }
    }





    // kopie z Pes\Http\Factory\FilesFactory
    /**
     * Parse a non-normalized, i.e. $_FILES superglobal, tree of uploaded file data.
     *
     * @param array $uploadedFiles The non-normalized tree of uploaded file data.
     *
     * @return array A normalized tree of UploadedFile instances.
     */
    private static function parseUploadedFiles(array $uploadedFiles)
    {
        $parsed = [];
        foreach ($uploadedFiles as $field => $uploadedFile) {
            if (!isset($uploadedFile['error'])) {
                if (is_array($uploadedFile)) {
                    $parsed[$field] = static::parseUploadedFiles($uploadedFile);
                }
                continue;
            }

            $parsed[$field] = [];
            if (!is_array($uploadedFile['error'])) {
                $parsed[$field] = new UploadedFile(
                    $uploadedFile['tmp_name'],              // předávám filename
                    isset($uploadedFile['size']) ? $uploadedFile['size'] : null,
                        $uploadedFile['error'],
                    isset($uploadedFile['name']) ? $uploadedFile['name'] : null,
                    isset($uploadedFile['type']) ? $uploadedFile['type'] : null
                    );
            } else {
                $subArray = [];
                foreach ($uploadedFile['error'] as $fileIdx => $error) {
                    // normalise subarray and re-parse to move the input's keyname up a level
                    $subArray[$fileIdx]['name'] = $uploadedFile['name'][$fileIdx];
                    $subArray[$fileIdx]['type'] = $uploadedFile['type'][$fileIdx];
                    $subArray[$fileIdx]['tmp_name'] = $uploadedFile['tmp_name'][$fileIdx];
                    $subArray[$fileIdx]['error'] = $uploadedFile['error'][$fileIdx];
                    $subArray[$fileIdx]['size'] = $uploadedFile['size'][$fileIdx];

                    $parsed[$field] = static::parseUploadedFiles($subArray);
                }
            }
        }

        return $parsed;
    }

    ######### DATUMY ################
    protected function transformForHtml($key, $modelValue) {
        return isset($modelValue) ? $this->getNewValueForHtml($key, $modelValue) : '';
    }

    protected function transformForSql($modelValue, $key, $postValue) {
        return isset($modelValue) ? $this->getNewValueForSql($modelValue, $key, $postValue) : ($postValue!=='' ? $postValue : null);
    }

    private function getNewValueForHtml($key, $value) {
        if ($this->jeToProjektoroveDatum($key) AND $value) {
            $value = $this->transformDatumToRfc($value);
        }
        return $value;
    }

    private function getNewValueForSql($modelValue, $key, $postValue) {
        if ($this->jeToProjektoroveDatum($key) AND $postValue) {
            $postValue = $this->transformDatumToCzech($postValue);
        }
        return $postValue;
    }

    /**
     * Název sloupce obsahuje substring datum_
     * @param type $columnName
     * @return type
     */
    private function jeToProjektoroveDatum($columnName) {
        return (strpos($columnName, 'datum_')!==FALSE) ? TRUE : FALSE;
    }

    private function transformDatumToCzech($value) {
        $datetime = DateTime::createFromFormat('Y-m-d', $value);
        if ($datetime) {
            return $datetime->format('j.n.Y');
        } else {
            throw new UnexpectedValueException('Chybný vstupní formát datumu RFC: '.$value);
        }
    }

    private function transformDatumToRfc($value) {
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

