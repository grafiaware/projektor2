<?php
/**
 * Description of FileMapper
 *
 * @author pes2704
 */
class Projektor2_Model_File_CertifikatKurzMapper extends Framework_Model_FileMapper {

    /**
     * Vyytvoří file model certifikátu, vytvoří soubor a zapíše do něj zadaný obsah. Pokud obsah není zadán, soubor bude prázdný.
     * @param Projektor2_Model_Db_Projekt $projekt
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param string $certifikatVerze
     * @param string|null $content
     * @return type
     */
    public static function create(
            Projektor2_Model_Db_Projekt $projekt,
            Projektor2_Model_Db_Zajemce $zajemce,
            Projektor2_Model_Db_SKurz $sKurz,
            $certifikatVerze,
            $content = null
        ) {
        $filePath = Config_AppContext::getRelativeFilePath($projekt->kod).self::getRelativeFilePath($projekt, $zajemce, $sKurz, $certifikatVerze);
        $fileModel = static::createFileItem($filePath, $content);
        self::save($fileModel);
        return $fileModel;
    }

    /**
     * Vytvoří model s obsahem načteným ze souboru se zadanou relativní cestou.
     * @param type $relativeFilePath
     * @return \Projektor2_Model_File_CertifikatKurz
     */
    public static function findByRelativeFilepath($relativeFilePath) {
        $model = static::createFileItem($relativeFilePath);
        try {
            self::hydrate($model);
        } catch (\RuntimeException $exc) {
            throw new \RuntimeException("Nepodařilo se načíst obsah souboru certifikátu s cestou '$relativeFilePath'. Metoda hydrate hlásí: {$exc->getMessage()}.", 0, $exc);
            return NULL;
        }

        return $model;
    }

    /**
     *
     * @param type $relativeDocumentPath
     * @param type $content
     * @return \Projektor2_Model_File_CertifikatKurz
     */
    private static function createFileItem($relativeDocumentPath, $content=NULL) {
        return new Projektor2_Model_File_CertifikatKurz($relativeDocumentPath, $content);
    }

    /**
     * Generuje relativní cestu k souboru certifikátu. Jméno souboru (base name) skládá s použitím kódu projektu, druhu kurzu a identifikátoru zájemce.
     *
     * @param Projektor2_Model_Db_Projekt $projekt
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @return string
     */
    private static function getRelativeFilePath(
            Projektor2_Model_Db_Projekt $projekt,
            Projektor2_Model_Db_Zajemce $zajemce,
            Projektor2_Model_Db_SKurz $sKurz,
            $certificatVersion
        ) {
        // rozděluje soubory do podsložek s názvem rovným id kurzu
        $dirName = Config_Certificates::getCertificateVersionFolder($certificatVersion).$sKurz->id_s_kurz.'/';
        $basename = $projekt->kod.'_IP_Osvedceni_'.$sKurz->kurz_druh.' '.$zajemce->identifikator.'.pdf';;
        return $dirName.$basename;
    }
}
