<?php
/**
 *
 * @author pes2704
 */
abstract class Projektor2_View_PDF_Common extends Projektor2_View_PDF_Base{
    // formát řetězce obsahujícího datum pro MySQL, shodný s formátem dle RFC3339
    const SQL_FORMAT = "Y-m-d";
    const CS_FORMAT = "d.m.Y";
    const CS_FORMAT_BEZ_NUL = "j. n. Y";
    

    protected function initialize() {
        $pdfdebug = Projektor2_PDFContext::getDebug();
        $pdfdebug->debug(0);
        $this->pdf = new Projektor2_PDF_PdfCreator();
        $this->pdf->AddFont('Times','','times.php');
        $this->pdf->AddFont('Times','B','timesbd.php');
        $this->pdf->AddFont("Times","BI","timesbi.php");
        $this->pdf->AddFont("Times","I","timesi.php");
        $this->pdf->AddFont('Arial','','arial.php');
        $this->pdf->AddFont('Arial','B','arialbd.php');
        $this->pdf->AddFont("Arial","BI","arialbi.php");
        $this->pdf->AddFont("Arial","I","ariali.php");
        $this->pdf->AddPage();   //uvodni stranka
    }



    protected function completeHeader($logoFileName=NULL, $x, $y, $sirka, $vyska, $zarovnani='C' ) {
        $pdfhlavicka = Projektor2_PDFContext::getHlavicka();
        $pdfhlavicka->zarovnani($zarovnani);
        $pdfhlavicka->vyskaPisma(14);
        if ($logoFileName) {
            if (is_readable($logoFileName)) {
                $pdfhlavicka->obrazek($logoFileName, $x, $y, $sirka, $vyska);
            } else {
                throw new UnexpectedValueException('Zadán neexistující soubor s obrázkem do hlavičky dokumentu: '.$logoFileName.'.');
            }
        }
    }
    protected function completeFooter( $textPaticky=NULL, $cislovani=TRUE) {
        $pdfpaticka = Projektor2_PDFContext::getPaticka();
        if ($textPaticky) {
            $pdfpaticka->Odstavec($textPaticky);
        }
        $pdfpaticka->zarovnani("C");
        $pdfpaticka->vyskaPisma(6);
        $pdfpaticka->cislovani = $cislovani;
        $pdfpaticka->OdsazeniDole(13);
    }



    protected function tiskniTitul(array $textyTitulu, $naStredStrany=FALSE) {
        if ($naStredStrany) {
            $this->pdf->Ln(125-count($textyTitulu)*20);
        }
        $titulka1 = new Projektor2_PDF_Blok;
        $titulka1->MezeraPredNadpisem(1);
        $titulka1->ZarovnaniNadpisu("C");
        $titulka1->VyskaPismaNadpisu(14);
        foreach ($textyTitulu as $textTitulu) {
            $titulka1->Nadpis($textTitulu);
            $this->pdf->TiskniBlok($titulka1);
            $titulka1->MezeraPredNadpisem(3);
        }
        if ($naStredStrany) {
            $this->pdf->AddPage();   //uvodni stranka
        }
    }

    protected function tiskniPodpisCertifikat() {
        $podpisy = new Projektor2_PDF_Blok();
        $podpisy->VyskaPismaTextu(12);
        $podpisy->ZarovnaniTextu('C');
        $podpisy->PridejOdstavec("......................................................");
        $podpisy->PridejOdstavec($this->context['signerName'], '');
        $this->pdf->TiskniBlok($podpisy);

        $position = new Projektor2_PDF_Blok();
        $position->VyskaPismaTextu(10);
        $position->ZarovnaniTextu('C');
        $position->PridejOdstavec($this->context['signerPosition'],"");
        $this->pdf->TiskniBlok($position);
    }

    protected function celeJmeno() {
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'CJC':
                $sigFlattable = Projektor2_Controller_Formular_FlatTable::CIZINEC_FT;
                break;
            default:
                $sigFlattable = Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT;
                break;
        }
        $prefixFT = $sigFlattable.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;
        $celeJmeno = $this->context[$sigFlattable][$prefixFT."titul"]." ".  $this->context[$sigFlattable][$prefixFT ."jmeno"]." ".  $this->context[$sigFlattable][$prefixFT ."prijmeni"];
        if ($this->context[$sigFlattable][$prefixFT ."titul_za"]) {
            $celeJmeno = $celeJmeno.", ". $this->context[$sigFlattable][$prefixFT ."titul_za"];
        }
        return $celeJmeno;
    }

    protected function celaAdresa($ulice='', $mesto='', $psc='') {
        $celaAdresa = '';
        if ($ulice) {
            $celaAdresa .= $ulice;
            if  ($mesto) {
                $celaAdresa .=  ", ".$mesto;
            }
            if  ($psc) {
                $celaAdresa .= ", ".$psc;
            }
        } else {
            if  ($mesto)  {
                $celaAdresa .= $mesto;
                if  ($psc) {
                    $celaAdresa .= ", " .$psc;
                }
            } else {
                if  ($psc) {
                    $celaAdresa .= $psc;
                }
            }
        }
        return $celaAdresa;
    }

    protected function datumBezNul($datum) {
        $datum = DateTime::createFromFormat(self::SQL_FORMAT, $datum);
        if($datum==false) {
            $datum = DateTime::createFromFormat(self::CS_FORMAT, $datum);
        }
        return $datum->format(self::CS_FORMAT_BEZ_NUL);

        
//        $tokens = explode('.', $datum);
//        foreach ($tokens as $key=>$value) {
//            $tokens[$key] = (int) $value;
//        }
//        return \implode('.', $tokens);
    }


    //-------------------------------------------------------------------------

    protected function setHeaderFooter($textPaticky=NULL, $cislovani=TRUE) {
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AP':
                self::completeHeader( "./img/loga/loga_AP_BW.png", 0, 5, 165,14 );
                self::completeFooter( $textPaticky
                                    . "\nProjekt Alternativní práce v Plzeňském kraji CZ.1.04/2.1.00/70.00055 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);
                break;
            case 'AGP':
                self::completeHeader( "./img/loga/logo_agp_bw.png", 0, 5, 165,26 );
                self::completeFooter( $textPaticky , $cislovani);
                break;
            case 'HELP':
                self::completeHeader("./img/loga/loga_HELP50+_BW.png", 0, 5, 165,11);
                self::completeFooter( $textPaticky
                                    . "\n Projekt Help 50+ CZ.1.04/3.3.05/96.00249 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);
                break;
            case 'SJZP':
                self::completeHeader("./img/loga/loga_OPLZZ_BW.jpg", 0, 5, 125,18);
                self::completeFooter( $textPaticky
                                    . "\n Projekt S jazyky za prací v Karlovarském kraji CZ.1.04/2.1.01/D8.00020 je financován "
                                    . "z ESF prostřednictvím OP LZZ a ze státního rozpočtu ČR.", $cislovani);
                break;
            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CKP':
            case 'PKP':
                self::completeHeader("./img/loga/loga_OP_Z&UP_PMS_BW.jpg", 0, 5, 110, 16, 'L');
                self::completeFooter( $textPaticky, $cislovani);
                break;
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'MB':
                self::completeHeader("./img/loga/logo_OPZ.png", 0, 5, 60, 22, 'L');
                $texts = Config_Certificates::getCertificateTexts($this->sessionStatus);
                self::completeFooter( $textPaticky . $texts['financovan'], $cislovani);
                break;
            case 'CJC':
                // nez proj. loga - akreditované kurzy
//                self::completeHeader( "./img/loga/logo_CJC_BW.png", 0, 5, 165,26 );
                self::completeFooter( $textPaticky , $cislovani);
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - nanastaveno HeaderFooter pro projekt.');
                break;
        }
    }
    protected function setHeaderFooterPms($textPaticky=NULL, $cislovani=TRUE) {
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {

            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CKP':
            case 'PKP':
                self::completeHeader("./img/loga/loga_OP_Z&UP_PMS_BW.jpg", 5, 15, 110, 16, 'L');
                self::completeFooter( $textPaticky, $cislovani);
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - nanastaveno HeaderFooter pro projekt.');
                break;
        }
    }

    protected function tiskniGrafiaUdaje() {
        $grafia = new Projektor2_PDF_Blok;
        $grafia->Odstavec("Grafia, společnost s ručením omezeným");
        $grafia->PridejOdstavec("zapsaná v obchodním rejstříku vedeném Krajským soudem v Plzni, odd. C, vl. 3067");
        $grafia->PridejOdstavec("sídlo: Plzeň, Budilova 4, PSČ 301 21");
        $grafia->PridejOdstavec("zastupující: Mgr. Jana Brabcová, jednatelka společnosti");
        $grafia->PridejOdstavec("IČ: 47714620");
        $grafia->PridejOdstavec("DIČ: CZ 47714620");
        $grafia->PridejOdstavec("bankovní spojení: ČSOB");
        $grafia->PridejOdstavec("č. účtu:  275795033/0300");
        $grafia->PridejOdstavec("zapsán v obchodním rejstříku vedeném Krajským soudem v Plzni, v oddílu C vložka 3067");
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AGP':
            case 'AP':
            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CKP':
            case 'PKP':
            case 'CJC':
                $grafia->PridejOdstavec("jako dodavatel (dále jen „Dodavatel“)");
                break;
            case 'HELP':
            case 'SJZP':
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'MB':
                $grafia->PridejOdstavec("jako příjemce podpory (dále jen „Příjemce“)");
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - nenastavene GrafiaUdaje pro projekt.');
                break;
        }
        $grafia->mezeraMeziOdstavci(1.5);
        $grafia->Radkovani(1);
        $this->pdf->TiskniBlok($grafia);
    }


    protected function tiskniOsobniUdaje() {
        $signDotaznik = Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT;
        $prefixDotaznik = $signDotaznik.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;
        $osobniUdaje = new Projektor2_PDF_Blok;
        $osobniUdaje->MezeraMeziOdstavci(1.5);
        $osobniUdaje->Radkovani(1);

        $osobniUdaje->Odstavec("jméno, příjmení, titul: ".$this->celeJmeno());
        $osobniUdaje->PridejOdstavec("bydliště: ".$this->celaAdresa($this->context[$signDotaznik][$prefixDotaznik."ulice"], $this->context[$signDotaznik][$prefixDotaznik."mesto"], $this->context[$signDotaznik][$prefixDotaznik."psc"]));
        $celaAdresa2 = $this->celaAdresa($this->context[$signDotaznik][$prefixDotaznik ."ulice2"], $this->context[$signDotaznik][$prefixDotaznik."mesto2"], $this->context[$signDotaznik][$prefixDotaznik ."psc2"]);
        if  ($celaAdresa2) {
            $osobniUdaje->PridejOdstavec("adresa dojíždění odlišná od místa bydliště: ".$celaAdresa2);
        }
        $osobniUdaje->PridejOdstavec("nar.: " . $this->datumBezNul($this->context[$signDotaznik][$prefixDotaznik ."datum_narozeni"]));
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AP':
                $osobniUdaje->PridejOdstavec("identifikační číslo účastníka: ".$this->context["identifikator"]);
                $osobniUdaje->PridejOdstavec("identifikační značka účastníka: ".$this->context["znacka"]);
                $osobniUdaje->PridejOdstavec("(dále jen „Účastník“)");
                break;
            case 'AGP':
                $osobniUdaje->PridejOdstavec("identifikační číslo zájemce: ".$this->context["identifikator"]);
                $osobniUdaje->PridejOdstavec("(dále jen „Zájemce“)");
                break;
            case 'HELP':
            case 'SJZP':
            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'VDTP':
            case 'PDU':
            case 'MB':
            case 'CJC':
            case 'CKP':
            case 'PKP':
                $osobniUdaje->PridejOdstavec("identifikační číslo účastníka: ".$this->context["identifikator"]);
                $osobniUdaje->PridejOdstavec("(dále jen „Účastník“)");
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - nenastavene OsobniUdaje pro projekt.');
                break;
        }
        $this->pdf->TiskniBlok($osobniUdaje);
    }

    protected function tiskniPodpisy($modelSmlouva) {
        $podpisy = new Projektor2_PDF_SadaBunek();
        $podpisy->PridejBunku('', '', FALSE, 20);
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AP':
            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CJC':
            case 'CKP':
            case 'PKP':
                $podpisy->PridejBunku("Účastník:", '', FALSE, 100);
                $podpisy->PridejBunku("Dodavatel:","",TRUE);
                break;
            case 'AGP':
                $podpisy->PridejBunku("Zájemce:", '', FALSE, 100);
                $podpisy->PridejBunku("Dodavatel:","",TRUE);
                break;
            case 'HELP':
            case 'SJZP':
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'MB':
                $podpisy->PridejBunku("Účastník:", '', FALSE, 100);
                $podpisy->PridejBunku("Příjemce:","",TRUE);
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene Podpisy ');
                break;
        }
        $podpisy->NovyRadek(0,2);
        $podpisy->PridejBunku('', '', FALSE, 15);
        $podpisy->PridejBunku("......................................................", '', FALSE, 100);
        $podpisy->PridejBunku("......................................................","",TRUE);
        $podpisy->PridejBunku('', '', FALSE, 20);
        $podpisy->PridejBunku($this->celeJmeno($modelSmlouva), '', FALSE, 100);
        $podpisy->PridejBunku($this->context['user_name'], '', TRUE);
        $podpisy->PridejBunku('', '', FALSE, 120);
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AP':
            case 'AGP':
            case 'HELP':
                $podpisy->PridejBunku("okresní poradce projektu","",TRUE);
                break;
            case 'SJZP':
                $podpisy->PridejBunku("koordinátor projektu","",TRUE);
                break;
            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CKP':
            case 'PKP':
                $podpisy->PridejBunku("administrátor programu","",TRUE);
                break;
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'MB':
                $podpisy->PridejBunku("poradce projektu","",TRUE);
                break;
            case 'CJC':
                $podpisy->PridejBunku("pracovník sekce vzdělávání","",TRUE);
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene Podpisy ');
                break;
        }
        $this->pdf->TiskniSaduBunek($podpisy, 0, 1);
    }


     //vola se v AP!!!!!!!!!!
    protected function tiskniPodpisUcastnik($modelSmlouva) {
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AP':
                $podpisy = new Projektor2_PDF_SadaBunek();
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("Účastník:", '',TRUE);
                $podpisy->NovyRadek(0,4);
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("......................................................", '',TRUE);
                $podpisy->PridejBunku('', '', FALSE, 115);
                $podpisy->PridejBunku($this->celeJmeno($modelSmlouva), '', TRUE);
                $this->pdf->TiskniSaduBunek($podpisy, 0, 1);
            break;

            default:
                 throw new RuntimeException('Nepodarilo se vytvorit pdf - nenastavene PodpisUcastnik pro projekt.');
                break;
        }
    }

    //vola se v AGP!!!!!!!!!  a HELP!!!!!!!!!! a SJZP!!!!!!!!!!!!!!!!!!!!!!!
    protected function tiskniPodpis($modelSmlouva) {
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AGP':
            case 'HELP':
            case 'SJZP':
            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'VDTP':
            case 'PDU':
            case 'MB':
            case 'CJC':
            case 'CKP':
            case 'PKP':
                $podpisy = new Projektor2_PDF_SadaBunek();
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("Účastník:", '',TRUE);
                $podpisy->NovyRadek(0,4);
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("......................................................", '',TRUE);
                $podpisy->PridejBunku('', '', FALSE, 115);
                $podpisy->PridejBunku($this->celeJmeno($modelSmlouva), '', TRUE);
                $this->pdf->TiskniSaduBunek($podpisy, 0, 1);
                break;
            default:
                throw new RuntimeException('Nepodarilo se vytvorit pdf - nenastavene Podpis pro projekt.');
                break;
        }

    }


    //vola se v AP!!!!!!!!!!
    protected function tiskniPodpisPoradce($modelSmlouva) {
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AP':
                $podpisy = new Projektor2_PDF_SadaBunek();
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("Dodavatel:", '',TRUE);
                $podpisy->NovyRadek(0,4);
                $podpisy->PridejBunku('', '', FALSE, 110);
                $podpisy->PridejBunku("......................................................", '',TRUE);
                $podpisy->PridejBunku('', '', FALSE, 115);
                $podpisy->PridejBunku($this->context['user_name'], '', TRUE);

                $this->pdf->TiskniSaduBunek($podpisy, 0, 1);
            break;

            default:
                break;
        }
    }

    protected function tiskniMistoDatum($modelSmlouva, $datum) {
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            case 'AGP':
            case 'AP':
            case 'HELP':
            case 'SJZP':
            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CKP':
            case 'PKP':
                $mistoDatum = new Projektor2_PDF_SadaBunek();
                $mistoDatum->MezeraPredSadouBunek(8);
                $mistoDatum->PridejBunku('', '', FALSE, 0);  //odsazeni zleva
                $mistoDatum->PridejBunku("Konzultační centrum: ", $this->context['kancelar_plny_text'], TRUE);
                $mistoDatum->NovyRadek(0,1);
                $mistoDatum->PridejBunku('', '', FALSE, 0);
                $mistoDatum->PridejBunku("Dne ", $this->datumBezNul($datum),1);
                $this->pdf->TiskniSaduBunek($mistoDatum, 0, 1);
                break;
            case 'SJPK':
            case 'SJPO':
            case 'SJLP':
            case 'MB':
            case 'CJC':
                $mistoDatum = new Projektor2_PDF_SadaBunek();
                $mistoDatum->MezeraPredSadouBunek(6);
                $mistoDatum->PridejBunku('', '', FALSE, 0);  //odsazeni zleva
                $mistoDatum->PridejBunku("Poradenské centrum: ", $this->context['kancelar_plny_text'], TRUE);
                $mistoDatum->NovyRadek(0,1);
                $mistoDatum->PridejBunku('', '', FALSE, 0);
                $mistoDatum->PridejBunku("Dne ",$this->datumBezNul($datum),1);
                $this->pdf->TiskniSaduBunek($mistoDatum, 0, 1);
                break;
            default:
                 throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene MistoDatum ');
                break;
        }
    }


    protected function tiskniMistoDatumPms($modelSmlouva, $datum) {
        switch ($this->sessionStatus->getUserStatus()->getProjekt()->kod) {
            // jen pro PMS
            case 'VZP':
            case 'ZPM':
            case 'SPP':
            case 'RP':
            case 'VDTP':
            case 'PDU':
            case 'CKP':
            case 'PKP':
                $mistoDatum = new Projektor2_PDF_SadaBunek();
                $mistoDatum->MezeraPredSadouBunek(8);
//                $mistoDatum->PridejBunku('', '', FALSE, 0);  //odsazeni zleva
//                $mistoDatum->PridejBunku("Konzultační centrum: ", $this->context['kancelar_plny_text'], TRUE);
                $mistoDatum->NovyRadek(0,2);
                $mistoDatum->PridejBunku('', '', FALSE, 70);
                $mistoDatum->PridejBunku('Otisk razítka', '', FALSE, 70);
                $mistoDatum->PridejBunku('', $this->context['signerPosition'], TRUE, 70);
                $mistoDatum->NovyRadek(0,3);
                $mistoDatum->PridejBunku('', '', FALSE, 136);
                $mistoDatum->PridejBunku(".........................................", '', TRUE, 70);
                $mistoDatum->PridejBunku('', '', FALSE, 10);
                $mistoDatum->PridejBunku("Dne ",$this->datumBezNul($datum), FALSE, 70);
                $mistoDatum->PridejBunku('', '', FALSE, 60);
                $mistoDatum->PridejBunku('', $this->context['signerName'], TRUE, 70);
                $mistoDatum->NovyRadek(0,1);
                $this->pdf->TiskniSaduBunek($mistoDatum, 0, 1);
                break;
            default:
                 throw new RuntimeException('Nepodarilo se vytvorit pdf - neosetrene MistoDatum ');
                break;
        }

//        $podpisy = new Projektor2_PDF_Blok();
//        $podpisy->VyskaPismaTextu(12);
//        $podpisy->ZarovnaniTextu('C');
//        $podpisy->PridejOdstavec("......................................................");
//        $podpisy->PridejOdstavec($this->context['signerName'], '');
//        $podpisy->PridejOdstavec($this->context['signerPosition'],"");
//
//        $this->pdf->TiskniBlok($podpisy);

    }

}
