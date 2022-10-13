<?php
use Pes\Text\Html;

class Projektor2_View_HTML_Formular_SKurz extends Projektor2_View_HTML_FormularPHP4 {

    public function display() {
        $sign = Projektor2_Controller_Formular_SKurz::S_KURZ;
        $prefix = $sign.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        $pole = $this->context[$sign]; // jen jeden model


        $html[] = Html::tag("h3", [], "KURZ");
        // form je readonly pomocí css - class lock
        $html[] = Html::tagNopair("br");
        $html[] =
            Html::tag("form", [
//                "class"=>"lock",
                "method"=>"POST", "enctype"=>"multipart/form-data", "action"=>"index.php?akce=kurzy&kurzy=kurz&kurz=detail_kurzu"],
                $this->context['uk_hint_fieldset'],
                Html::tag("fieldset", [],
                    Html::tag("legend", [], "Údaje pro plánování kurzu"),
                    Html::input($prefix.'projekt_kod', "Kód projektu:", $pole, ["type"=>"text", "size"=>"8", "maxlength"=>"20"]),
                    Html::input($prefix.'kancelar_kod', "Kód kanceláře:", $pole, ["type"=>"text", "size"=>"10", "maxlength"=>"20"]),
                    Html::input($prefix.'kurz_druh', "Druh kurzu:", $pole, ["type"=>"text", "size"=>"8", "maxlength"=>"20"]),

                    Html::input($prefix.'kurz_cislo', "Číslo kurzu:", $pole, ["type"=>"text", "size"=>"8", "maxlength"=>"20"]),
                    Html::input($prefix.'beh_cislo', "Číslo běhu:", $pole, ["type"=>"text", "size"=>"8", "maxlength"=>"20"]),
                    Html::input($prefix.'kurz_lokace', "Lokace kurzu:", $pole, ["type"=>"text", "size"=>"5", "maxlength"=>"5"]),
                    Html::input($prefix.'kurz_zkratka', "Zkratka kurzu:", $pole, ["type"=>"text", "size"=>"8", "maxlength"=>"20"]),

                    Html::input($prefix.'date_zacatek', "Datum začátku:", $pole, ["type"=>"date", "size"=>"8", "maxlength"=>"10"]),
                    Html::input($prefix.'date_konec', "Datum konce:", $pole, ["type"=>"date", "size"=>"8", "maxlength"=>"10"]),
                    Html::input($prefix.'dodavatel', "Dodavatel kurzu:", $pole, ["type"=>"text", "size"=>"60", "maxlength"=>"120"]),
                    Html::input($prefix.'valid', "Platný:", $pole, ["type"=>"text", "size"=>"1", "maxlength"=>"1"])
                ),
                Html::tag("fieldset", [],
                    Html::tag("legend", [], "Akreditace kurzu"),
                    Html::input($prefix.'kurz_nazev', "Název kurzu:", $pole, ["type"=>"text", "size"=>"120", "maxlength"=>"120"]),
                    Html::input($prefix.'kurz_pracovni_cinnost', "Pracovní činnost:", $pole, ["type"=>"text", "size"=>"120", "maxlength"=>"120"]),
                    Html::input($prefix.'kurz_akreditace', "Akreditace:", $pole, ["type"=>"text", "size"=>"120", "maxlength"=>"120"]),
                    Html::textarea($prefix.'kurz_obsah', "Obsah kurzu:", $pole, ["type"=>"textarea", "size"=>"3000", "maxlength"=>"3000", "wrap"=>"soft", "readonly"=>true]),
                    Html::input($prefix.'pocet_hodin', "Počet hodin celkem:", $pole, ["type"=>"text", "size"=>"8", "maxlength"=>"10"]),
                    Html::input($prefix.'pocet_hodin_distancne', "Počet hodin distančně:", $pole, ["type"=>"text", "size"=>"8", "maxlength"=>"10"]),
                    Html::input($prefix.'pocet_hodin_praxe', "Počet hodin praxe:", $pole, ["type"=>"text", "size"=>"8", "maxlength"=>"10"])
                ),

                Html::tag("p", [],
                    Html::input("save", "", ["save"=>"Uložit"], ["type"=>"submit", "size"=>"8", "maxlength"=>"10"])
                )
            );
        echo implode(PHP_EOL, $html);
    }
}
// [id] => 1567
//    [razeni] => 1
//    [projekt_kod] => CJC
//    [kancelar_kod] => CJC_TST
//    [kurz_druh] => RKJAZ
//    [kurz_cislo] => 1
//    [beh_cislo] => 1
//    [kurz_lokace] => PM
//    [kurz_zkratka] => CJA1
//    [kurz_nazev] => Český jazyk pro cizince - základní kurz
//    [kurz_pracovni_cinnost] => Český jazyk pro cizince - základní kurz
//    [kurz_akreditace] => Vzdělávací program akreditován MŠMT dne 31. 5. 2022 pod čj. : MSMT-13830/2022-3
//    [kurz_obsah] => Osobní údaje, rodina ............................................. 4 hod./0 hod.\r\nBydlení .......................................................... 2 hod./0 hod.\r\nStravování ....................................................... 2 hod./0 hod.\r\nDenní režim ...................................................... 2 hod./0 hod.\r\nVolný čas ........................................................ 3 hod./0 hod.\r\nPráce ............................................................ 6 hod./0 hod.\r\nPéče o zdraví, zdravotní pojištění ............................... 8 hod./0 hod.\r\nNakupování a služby .............................................. 8 hod./0 hod.\r\nCestování ........................................................ 8 hod./0 hod.\r\nVzdělávání ....................................................... 8 hod./0 hod.\r\nStyk s úřady ..................................................... 8 hod./0 hod.\r\nStyk s policií a složkami záchranného systému .................... 8 hod./0 hod.\r\nOkolní prostředí a příroda ....................................... 8 hod./0 hod.\r\nKontakt s majoritní společností .................................. 8 hod./0 hod.\r\n
//    [pocet_hodin] => 60
//    [pocet_hodin_distancne] =>
//    [pocet_hodin_praxe] =>
//    [date_zacatek] => 01.09.2022
//    [date_konec] => 19.09.2022
//    [dodavatel] => Grafia, s.r.o.
//    [valid] => 1
