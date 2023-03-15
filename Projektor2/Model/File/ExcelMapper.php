<?php

use Pes\Utils\Directory;

class Projektor2_Model_File_ExcelMapper {

    const PATH_PREFIX = 'Excel/';

    const SQL_FORMAT = "Y-m-d";
    const TITLES_BACKGROUND_COLOR = 'ccccff';
    const PRVNI_RADEK_DAT = 1; //řádek s titulky - číslováno od jedničky
    const PRVNI_SLOUPEC_DAT = 0; //číslováno od nuly

    /**
     * Metoda vytvoří SQL view s zadaným názvem s použitím zadaného SQL kódu. Pokud již view se zadaným jménem existuje, přepíše ho.
     * V případě úspěchu vrací jméno vytvořeného view, v případě neúspěchu vrací prázdný řetězec.
     *
     * @param string $sqlViewName
     * @param string $sqlViewCreateCode
     * @return type
     */
    public static function createViewFromSql($sqlViewName, $sqlViewCreateCode) {
        $dbh = Config_AppContext::getDb();
        $query = "DROP VIEW IF EXISTS `$sqlViewName`";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $query = "CREATE VIEW `$sqlViewName` AS $sqlViewCreateCode";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        return $succ ? $sqlViewName : "";

    }

    /**
     *
     * @param type $viewName Jméno SQL pohledu
     * @param type $sheetName Jméno, které bude použito pro pojmenování listu s daty ve vytvořeném xls
     * @param type $usedViewParams Parametry, které byly použity při vytváření SQL view - připraveno pro vložení do xls, nepoužito
     * @return \Projektor2_Model_File_Excel
     */
    public static function createFromView($viewName, $sheetName=null, $usedViewParams=[]) {
        $locale = 'cs_CZ';
        $validLocale = PHPExcel_Settings::setLocale($locale);
        if (!$validLocale) {
                echo 'Nepodařilo se nastavit lokalizaci '.$locale." - zůstává nastavena výchozí en_us<br />\n";
        }

        $dbh = Config_AppContext::getDb();
        $query = "SHOW COLUMNS FROM ".$viewName;
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $showColumnsData = $sth->fetchAll(PDO::FETCH_ASSOC);

        $objPHPExcel = new PHPExcel();
        $objWorksheet = $objPHPExcel->getActiveSheet();
        PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
        $objPHPExcel->getActiveSheet()->setTitle($sheetName ?? $viewName);
        $objPHPExcel->getDefaultStyle()
            ->getNumberFormat()
            ->setFormatCode(
                PHPExcel_Style_NumberFormat::FORMAT_TEXT
            );

        //titulky sloupců
        foreach ($showColumnsData as $columnIndex => $dataField) {
            list($colType, $rest) = explode("(", $dataField['Type']);
            list($len, $rest) = explode(")", $rest);
            list($colLength, $rest) = explode(".", $len);
//            preg_match('#\((.*?)\)#', $row['Type'], $match);
            $column[$dataField['Field']] = ['index'=>$columnIndex, 'type'=>$colType, 'length'=>$colLength];
            $c = $columnIndex+self::PRVNI_SLOUPEC_DAT;
            $r = self::PRVNI_RADEK_DAT;
            $cell = $objWorksheet->getCellByColumnAndRow($c, $r);
            $cell->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $cell->getStyle()->getFont()->setBold(true);
            $cell->getStyle()->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB(self::TITLES_BACKGROUND_COLOR);
            $cell->setValue($dataField['Field']);
        }

        //data
        $query = "SELECT * FROM ".$viewName;
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $rowIndex=>$row) {
            foreach ($row as $columnName => $value) {
                $c = $column[$columnName]['index']+self::PRVNI_SLOUPEC_DAT;
                $r = $rowIndex+self::PRVNI_RADEK_DAT + 1;
                $cell = $objWorksheet->getCellByColumnAndRow($c, $r);
                if ($column[$columnName]['type']=="date") {
                    self::setCellFromDateType($cell, $value);
                } elseif (strpos($columnName, 'datum_')===0) {
                    self::setCellFromDatumColumn($cell, $value);
                } else {
                    $cell->setValue($value);
                }
            }
        }
        // pro nastavování šířek sloupců musí být autosize vypnuto (setAutosize(false))
        self::autosizeAll($objPHPExcel, true);

        $objPHPExcel->getProperties()->setCreator("Projektor ExportExcel");
        $objPHPExcel->getProperties()->setTitle("Projektor export - tabulka ".$viewName);
        //$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        return new Projektor2_Model_File_Excel($objPHPExcel, $viewName);
    }

    private static function setCellFromDateType(PHPExcel_Cell $cell, $value) {
        $datum = PHPExcel_Shared_Date::PHPToExcel(DateTime::createFromFormat(self::SQL_FORMAT, $value));
        $cell->setValue($datum);
        $cell->getStyle()->getNumberFormat()->setFormatCode("DD.MM.YYYY");
    }

    private static function setCellFromDatumColumn(PHPExcel_Cell $cell, $value) {
        $datum = PHPExcel_Shared_Date::PHPToExcel(DateTime::createFromFormat(self::SQL_FORMAT, $value));
        $cell->setValue($datum);
        $cell->getStyle()->getNumberFormat()->setFormatCode("DD.MM.YYYY");
    }

    private static function autosizeAll(PHPExcel $objPHPExcel, bool $value) {
        // https://stackoverflow.com/questions/16761897/phpexcel-auto-size-column-width
        // Auto-size columns for all worksheets
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            foreach ($worksheet->getColumnIterator() as $column) {
                $worksheet
                    ->getColumnDimension($column->getColumnIndex())
                    ->setAutoSize($value);
            }
        }
    }

    public static function save(Projektor2_Model_File_Excel $modelExcel, Projektor2_Model_Status $sessionStatus) {
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter = new PHPExcel_Writer_Excel5($modelExcel->objPHPExcel);
        try {
            $fullFileName = self::prepareAbsoluteFilePath($sessionStatus, $modelExcel->tabulka);
            $objWriter->save($fullFileName);
        } catch (Exception $e){
            return FALSE;
        }
        $modelExcel->documentFileName = $fullFileName;
        return TRUE;
    }

    /**
     * Generuje řetězec vhodný jako plné jméno souboru (s cestou). Pokud nnexistuje složka odpovídajíví zadané cestě vytvoří složky (adresář).
     *
     * @param Projektor2_Model_Status $sessionStatus
     * @param type $tabulka
     * @return type
     */
    private static function prepareAbsoluteFilePath(Projektor2_Model_Status $sessionStatus, $tabulka) {
        $dirName = Config_AppContext::getFileBaseFolder()
                .Config_AppContext::getRelativeFilePath($sessionStatus->getUserStatus()->getProjekt()->kod)
                .static::PATH_PREFIX;
        $normalizedPath = Directory::createDirectory($dirName);

        $basename = self::getBaseName($sessionStatus, $tabulka);
        return $normalizedPath.$basename;
    }

    /**
     * Generuje řetězec vhodný jako jméno souboru (base name).
     * @param Projektor2_Model_Status $sessionStatus
     * @param type $tabulka
     * @return type
     */
    private static function getBaseName(Projektor2_Model_Status $sessionStatus, $tabulka) {
        return $tabulka.'_'.date("Ymd_Hi").'.xls';
    }
}

