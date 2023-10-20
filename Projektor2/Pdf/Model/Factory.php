<?php
namespace Pdf\Model;

use Pdf\Model\Debug;
use Pdf\Model\Hlavicka;
use Pdf\Model\Paticka;
/**
 * Kontejner na statickou hlavičku a patičku PDF stránky
 * @author Petr Svoboda
 *
 */
abstract class Factory
{
    private static $hlava;
    private static $pata;
    private static $deb;

    /**
     * Statická funkce, při prvním volání vytvoří nový objekt PDF_Hlavicka, při každém dalším volání vrací již jednou vytvořený objekt
     * @return Hlavicka
     */
    public static function getHeaderModel(): Hlavicka {
        if(!self::$hlava) {
            self::$hlava = new Hlavicka();
        }
        return self::$hlava;
    }

    /**
     * Statická funkce, pči prvním volání vytvoří nový objekt PDF_Paticka, při každém dalším volání vrací již jednou vytvořený objekt
     * @return Paticka
     */
    public static function getFooterModel(): Paticka {
        if(!self::$pata) {
            self::$pata = new Paticka();
        }
        return self::$pata;
    }

    public static function getDebugModel(): Debug
    {
        if(!self::$deb) {
            self::$deb = new Debug();
        }
        return self::$deb;
    }
}
