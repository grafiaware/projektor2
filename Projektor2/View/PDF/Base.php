<?php
use Pdf\Renderer\Renderer;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Projektor2_View_PDF_Base implemntuje interface Projektor2_View_PDF_ViewPdfInterface
 *
 * @author pes2704
 */
abstract class Projektor2_View_PDF_Base extends Framework_View_Abstract implements Projektor2_View_PDF_ViewPdfInterface {
    const FPDF_FONTPATH = 'Projektor2/PDF/Fonts/';

    protected $fullFileName;
    protected $relativeDocumentFilePath;

    /**
     *
     * @var \Projektor2_Pdf_Renderer_Renderer
     */
    protected $pdfRenderer;

    protected $pdfString;

    /**
     * Tuto metodu musí potomci implementovat. Je volána v metodě $this->save().
     */
    abstract function createPDFObject();

    /**
     * Metoda ukládá vytvořené PDF do souboru.
     * @return bool TRUE pokud byl soubor s PDF vytvořen, jinak FALSE
     */
    public function save($relativeFilePath) {
        //TODO: Exception !! neexistuje $context["identifikator"]
        $this->relativeDocumentFilePath = $relativeFilePath;
        $this->fullFileName = Config_AppContext::getFileBaseFolder().$relativeFilePath;
        define('FPDF_FONTPATH', self::FPDF_FONTPATH);  //běhová konstanta potřebná pro fpdf
        $this->createPDFObject();
        if (file_exists($this->fullFileName))  	{
            unlink($this->fullFileName);
        }
        $this->pdfRenderer->Output($this->fullFileName, 'F');
        return $this->isSaved();
    }

    public function isSaved() {
        if (file_exists($this->fullFileName))  	{
            return TRUE;
        }
        return FALSE;
    }

    public function getFullFileName() {
        return $this->fullFileName;
    }

    public function render() {
        if (!defined('FPDF_FONTPATH')) {
            define('FPDF_FONTPATH', self::FPDF_FONTPATH);  //běhová konstanta potřebná pro fpdf
        }
        $this->createPDFObject();
        $this->pdfString = $this->pdfRenderer->Output($this->fullFileName, 'S');
        return $this->pdfString;
    }

    public function getNewWindowOpenerCode() {
// TODO opener code - upravit tak, aby opener code volal kontroler (přidat kontroler) pro download souboru -pak přesunou úložiště souborů mimo kořen webu
        $code =  '<script type ="text/javascript">
                    FullFileName="'.Config_AppContext::getHttpFileBasePath().$this->relativeDocumentFilePath.'";
                  </script>';
        return $code;
    }


}

?>
