<?php

use Pes\Utils\Directory;

/**
 * Description of Projektor2_Controller_Formular_Base
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_FlatTable extends Projektor2_Controller_Formular_Base {

    const PLAN_FT = 'planFT';
    const DOTAZNIK_FT = 'dotaznikFT';
    const PLAN_KURZ = 'planKurz';
    const UKONC_FT = 'ukoncFT';
    const ZAM_FT = 'zamFT';
    const CIZINEC_FT = 'cizinecFT';

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
            $uploadedFolderPath = "filesUploadFromProjektor/";
            $this->saveUploaded($uploadedFolderPath);
            // ukládání dat modelů flat table
            $this->createFormModels();  // pokud není $this->sessionStatus->zajemce vytvoří při volání flat table->save() nový zájemce
            $this->setModelsFromPost($this->request->postArray());
            $this->saveModels();
        } else { // request == GET
            $this->createFormModels();  // pokud není $this->sessionStatus->zajemce vytvoří při volání flat table->save() nový zájemce
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
        $context = [];
        foreach ($this->models as $modelSign => $model) {
            if ($model instanceof Framework_Model_CollectionFlatTable) {
                $context[$modelSign] = $this->createContextFromCollectionFlatTable($modelSign, $model, $transformValuesForHtml);
            } elseif ($model instanceof Framework_Model_ItemFlatTable) {
                $context[$modelSign] = $this->createContextFromItemFlatTable($modelSign, $model, $transformValuesForHtml);
            } else {
                throw new \LogicException("Model ".get_class($model)." není Framework_Model_CollectionFlatTable ani Framework_Model_ItemFlatTable.");
            }
        }
        return $context;
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
}

