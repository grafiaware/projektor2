<?php
/**
 * Description of FileMapper
 *
 * @author pes2704
 */
class Projektor2_Model_File_CizinecZadostMapper extends Framework_Model_FileMapper {

    public static function create(Projektor2_Model_Db_Projekt $projekt, Projektor2_Model_Db_Flat_ZaCizinecFlatTable $zaCizinecFlatTable, $relativePath, $content) {
        if (!is_string($content)) {
            throw new UnexpectedValueException('Obsah dokumentu musí být řetězec.');
        }
        return static::createFileItem(
                Projektor2_AppContext::getRelativeFilePath($projekt->kod)
                .self::getRelativeFilePath($projekt, $zaCizinecFlatTable, $relativePath), $content);
    }

    /**
     * Vytvoří model s obsahem načteným ze souboru se zadanou relativní cestou.
     * @param type $relativeFilePath
     * @return \Projektor2_Model_File_CertifikatKurz
     */
    public static function findByRelativeFilepath($relativeFilePath) {
        $model = static::createFileItem($relativeFilePath);
        try {
            $model = self::hydrate($model);
        } catch (RuntimeException $exc) {
            throw new RuntimeException('Nepodařilo se načíst obsah souboru certifikátu s cestou "'.$relativeFilePath.'". Metoda hydrate hlásí: '.$exc->getMessage());
            return NULL;
        }

        return $model;
    }

    private static function createFileItem($relativeDocumentPath, $content=NULL) {
        return new Projektor2_Model_File_CizinecZadost($relativeDocumentPath, $content);
    }

    /**
     * Generuje relativní cestu k souboru certifikátu. Jméno souboru (base name) skládá s použitím kódu projektu, druhu kurzu a identifikátoru zájemce.
     * @param Projektor2_Model_Db_Projekt $projekt
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @return type
     */
    public static function getRelativeFilePath(Projektor2_Model_Db_Projekt $projekt, Projektor2_Model_Db_Flat_ZaCizinecFlatTable $zaCizinecFlatTable, $relativePath) {
        // rozděluje soubory do podsložek s názvem rovným id kurzu
        $dirName = Projektor2_AppContext::getCertificateTypeFolder($certificateType).$sKurz->id_s_kurz.'/';
        $basename = $projekt->kod.'_IP_Osvedceni_'.$sKurz->kurz_druh.' '.$zajemce->identifikator.'.pdf';;
        return $dirName.$basename;
    }
}
