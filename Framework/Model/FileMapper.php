<?php
/**
 * Description of FileMapper
 *
 * @author pes2704
 */
abstract class Framework_Model_FileMapper {

    protected $fileLength;

    /**
     * Metoda ukládá dokument do souboru v souborovém systému. Soubor vytvoří, již existující vždy přepíše. Do souboru vloží obsah
     * bez kontroly délky, pokud je obsah modelu prázdný nebo null, vytvoří soubor s nulovou délkou.
     * Pokud neexistuje složka (adresář), do kterého se má soubor uložit, pokusí se složku vytvořit (s oprávněním 0777)
     *
     * @param Projektor2_Model_File_ItemAbstract $model
     *
     * @throws BadFunctionCallException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public static function save(Projektor2_Model_File_ItemAbstract $model) {
        $path_parts = pathinfo($model->filePath);
        if (!is_dir($path_parts['dirname'])) {  //pokud není složka, vytvoří ji
            if (!mkdir($path_parts['dirname'], 0777, TRUE)) {
                throw new BadFunctionCallException('Nepodařilo se vytvořit složku: '.$path_parts['dirname']);
            }
        }
        if ($model->filePath != $path_parts['dirname'].'/'.$path_parts['basename']) {
            throw new UnexpectedValueException('Chybná syntaxe názvu souboru ve vlastnosti modelu '.get_class($model).'. Chybný název souboru: '.$model->filePath);
        }
        $fileResource = fopen($model->filePath, 'w+'); //pokud soubor existuje, přepíše ho, pokud ne, vytvoří ho
        if (!$fileResource) {   // fopen -> FALSE on error a E_WARNING
            throw new Exception('Nepodařilo se otevřít soubor "'.$model->filePath.'". Chyba: '.error_get_last()['message']);
        }
        $model->filelength = fwrite($fileResource, $model->content ?? '');
        if (self::isSaved($model)) {
            $model->isPersisted = TRUE;
            $model->changed = FALSE;
        } else {
            if($fileResource) {
                fclose($fileResource);
                unlink($fileResource);
            }
            throw new RuntimeException('Neznámá chyba! Soubor '.$model->filePath.' se nepodařilo uložit.');
        }
    }

    /**
     * Smaže soubor uvedený v modelu, pokud uspěje, smaže vlastnosti modelu filePath a relativeDocumentPath
     *
     * @param Projektor2_Model_File_ItemAbstract $model
     * @throws BadFunctionCallException
     * @throws UnexpectedValueException
     * @throws Exception
     * @throws RuntimeException
     */
    public static function delete(Projektor2_Model_File_ItemAbstract $model) {
        $path_parts = pathinfo($model->filePath);
        if (!is_dir($path_parts['dirname'])) {  //pokud není složka, vytvoří ji
            throw new BadFunctionCallException('Nepodařilo se nalézt složku: '.$path_parts['dirname']);
        }
        if ($model->filePath != $path_parts['dirname'].'/'.$path_parts['basename']) {
            throw new UnexpectedValueException('Chybná syntaxe názvu souboru ve vlastnosti modelu '.get_class($model).'. Chybný název souboru: '.$model->filePath);
        }
        $fileResource = fopen($model->filePath, 'r+'); //otevře pro čtení i zápis - jen ověřuji
        if (!$fileResource) {   // fopen -> FALSE on error a E_WARNING
            throw new Exception('Nepodařilo se ověřit soubor "'.$model->filePath.'". Chyba: '.error_get_last()['message']);
        }
        fclose($fileResource);
        if (!unlink($fileResource)) {
            throw new RuntimeException('Neznámá chyba! Soubor '.$model->filePath.' se nepodařilo uložit.');
        }
        $model->filePath = '';
        $model->relativeDocumentPath = '';
    }

    /**
     * Metoda načte obsah souboru v souborové systému do obsahu modelu a nastaví ostatní vlastnosti modelu.
     * @param Projektor2_Model_File_ItemAbstract $model
     * @return \Projektor2_Model_File_ItemAbstract Model s načteným obsahem
     * @throws RuntimeException
     */
    public static function hydrate(Projektor2_Model_File_ItemAbstract $model) {
        if (substr(trim($model->filePath), -1) == "/") {
            throw new RuntimeException('Při pokusu o načtení obsahu ze souboru '.$model->filePath
                    .' cesta neobsahuje název souboru.');
        }
        $path_parts = pathinfo($model->filePath);
        if (!isset($path_parts['dirname'])) {
            throw new RuntimeException('Při pokusu o načtení obsahu certifikátu ze souboru se nepodařilo zjistit složku a název souboru '
                    . 'z vlastnosti modelu:'.$model->filePath);
        }
        if (!is_dir($path_parts['dirname'])) {
            throw new RuntimeException('Při pokusu o načtení obsahu ze souboru '.$model->filePath
                    .' neexistuje složka: '.$path_parts['dirname']);
        }

        $fileResource = fopen($model->filePath, 'r'); //jen ke čtení
        if (!$fileResource) {
            throw new RuntimeException('Při pokusu o načtení obsahu ze souboru '.$model->filePath.
                    ' se nepodařilo načíst soubor.');
        }
        $length = filesize($model->filePath);
        if ($length == 0) {
            throw new RuntimeException('Při pokusu o načtení obsahu ze souboru '.$model->filePath
                    .'nebyl načten žádný obsah ze souboru, soubor má nulovou délku.');
        }
        $ret = fread($fileResource, $length);
        if ($ret === FALSE) {
            throw new RuntimeException('Při pokusu o načtení obsahu ze souboru '.$model->filePath
                    .'nebyl z neznámého důvodu načten žádný obsah ze souboru. Možná soubor není čitelný nebo nemáte oprávnění.');
        } else {
            $model->content = $ret;
            $model->filelength = strlen($ret);
            if (self::isHydrated($model)) {  //přísné ověřování
                $model->isHydrated = TRUE;
            } else {
                throw new RuntimeException('Neznámá chyba! Soubor '.$model->filePath.' se podařilo načíst a přesto je obsah modelu jiný než obsah souboru.');
            }
            $model->changed = FALSE;
        }
        return $model;
    }

    /**
     * Metoda ověří, jestli je obsah modelu souboru v souborovém systému.
     * @param Projektor2_Model_File_ItemAbstract $model
     * @return boolean
     */
    public static function isSaved(Projektor2_Model_File_ItemAbstract $model) {
        return self::verify($model);
    }

    /**
     * Metoda ověří, jestli jestli obsah souboru v souborovém systému je obsahem modelu.
     * @param type $model
     * @return type
     */
    public static function isHydrated($model) {
        return self::verify($model);
    }

    /**
     * Zjistí jestli existuje soubor, nezměnil se obsah modelu od posledního uložení a nezměnil se obsah souboru od posledního uložení.
     * Změnu obsahu zjišťuji jen podle změny délky (počtu bytů).
     * @param type $model
     * @return boolean
     */
    private static function verify($model) {
        if (file_exists($model->filePath)
            AND strlen($model->content)===$model->filelength
            AND $model->filelength==filesize($model->filePath)) {
            return TRUE;
        }
        return FALSE;
    }
}
