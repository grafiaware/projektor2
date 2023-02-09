<?php
use Pes\Text\Html;

/**
 * Třída Projektor2_View_HTML_HeSmlouva zabaluje původní PHP4 kód do objektu. Funkčně se jedná o konponentu View,
 * na základě dat předaných konstruktoru a šablony obsažené v metodě display() generuje HTML výstup
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Formular_Cizinec extends Projektor2_View_HTML_FormularPHP4 {
    /**
     * Metoda obsahuje php kod (ve stylu PHP4), který užívá PHP jako šablonovací jazyk. Na základě dat zadaných v konstruktoru
     * do paramentru $context metoda generuje přímo html výstup. Metoda nemá návratovou hodnotu.
     */
    public function display() {
        $signCizinec = Projektor2_Controller_Formular_FlatTable::CIZINEC_FT;
        $prefixCizinec = $signCizinec.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;
        $signDotaznik = Projektor2_Controller_Formular_FlatTable::DOTAZNIK_FT;
        $prefixDotaznik = $signDotaznik.Projektor2_Controller_Formular_FlatTable::MODEL_SEPARATOR;

        $poleDotaznik = $this->context[$signDotaznik];
        $poleCizinec = $this->context[$signCizinec];

        $projektTitulek = strtoupper($this->sessionStatus->projekt->text);

        $html[] = Html::tag("h3", [], "REGISTRACE V PROGRAMU $projektTitulek");
        ##########
//        $html[] = $this->context['uk_hint_script'];
        include 'hint/ukHintScript.php';

        $html[] =
            Html::tag("form", ["method"=>"POST", "enctype"=>"multipart/form-data", "action"=>"index.php?osoby=form&form&form=cizinec"],
                #### p pro table generovanou z json ############
                Html::tag("fieldset", [],
                    Html::tag("legend", [], "Vyhledání osoby v údajích Google form"),
                    Html::input($prefixCizinec."person_json", "", $poleCizinec, ["id"=>"person_json", "type"=>"hidden"]),
                    Html::tag("p", ["id"=>"person"])
                ),
                ####################
                Html::tag("fieldset", [],
                    Html::tag("legend", [], "Osobní údaje"),
                    Html::tag("p", [],
                        Html::input($prefixDotaznik.'titul', "Titul:", $poleDotaznik, ["type"=>"text", "size"=>"3", "maxlength"=>"10"]),
                        Html::input($prefixDotaznik.'jmeno', "Jméno:", $poleDotaznik, ["type"=>"text", "size"=>"20", "maxlength"=>"50", "required"=>true]),
                        #### hint mobil ############
                        Html::input($prefixDotaznik.'prijmeni', "Začněte psát příjmení:", $poleDotaznik,
                                ["id"=>"name_input", "type"=>"text", "size"=>"20", "maxlength"=>"50",
                                "list"=>"name_hints_list", "onkeyup"=>"showHint('name_hints_list', 'name', this.value)"]),
                        Html::tag("datalist", ["id"=>"name_hints_list"]),
                        // type="button" neodesílá form
                        Html::tag("button",
                                ["type"=>"button", "onclick"=>"showPerson('name_input', 'name')"],
                                "Najdi osobu z Google formuláře podle příjmení"),
                        ################
//                        $this->context['uk_hint_prijmeni'],
//                        Html::input($prefixDotaznik.'prijmeni', "Příjmení:", $poleDotaznik, ["type"=>"text", "size"=>"20", "maxlength"=>"50", "required"=>true]),
                        Html::input($prefixDotaznik.'titul_za', "Titul za:", $poleDotaznik, ["type"=>"text", "size"=>"3", "maxlength"=>"10"]),
                        Html::select($prefixDotaznik.'pohlavi', "Pohlaví:", ["", "muž", "žena"], $poleDotaznik, ["id"=>"pohlavi", "required"=>true]),  // id pro javascript
                    ),
                    Html::tag("p", [],
                        Html::input($prefixDotaznik.'datum_narozeni', "Datum narození:", $poleDotaznik, ["id"=>"datum_narozeni", "type"=>"date", "size"=>"8", "maxlength"=>"10", "required"=>true]),  // id pro javascript
                        Html::input($prefixDotaznik.'misto_narozeni', "Místo narození pro certifikáty:", $poleDotaznik, ["id"=>"misto_narozeni", "type"=>"text", "size"=>"30", "maxlength"=>"50", "required"=>true]),
                        Html::input($prefixDotaznik.'rodne_cislo', "Rodné číslo v ČR:", $poleDotaznik, ["id"=>"rodne_cislo", "type"=>"text", "size"=>"20", "maxlength"=>"50", "readonly"=>true]),  // readonly - generuje javascript
                    )
                ),
                Html::tag("fieldset", [],
                    Html::tag("legend", [], "Bydliště a kontaktní údaje"),
                    Html::tag("fieldset", [],
                        Html::tag("legend", [], "Bydliště v ČR"),
                        Html::tag("p", [],
                            Html::input($prefixCizinec.'obec_pobytu', "Obec pobytu v ČR:", $poleCizinec, ["type"=>"text", "size"=>"20", "maxlength"=>"50"]),  //, "required"=>true])
                        )
                    ),
                    Html::tag("fieldset", [],
                        Html::tag("legend", [], "Vhodné místo konání kurzů"),
                        Html::tag("p", [],
                            Html::select($prefixCizinec."obec_pro_kurz", "Město:", ["", "Plzeň", "Klatovy", "Karlovy Vary", "jiné"], $poleCizinec, []),  //"required"=>true]),
                            Html::input($prefixCizinec.'pozadavky_kurz', "Požadavky na konání kurzu:", $poleCizinec, ["type"=>"text", "size"=>"100", "maxlength"=>"200"])
                        )
                    ),
                    Html::tag("fieldset", [],
                        Html::tag("legend", [], "Telefon a email"),
                        Html::tag("p", [],
                        #### hint mobil ############
                        Html::input($prefixDotaznik.'mobilni_telefon', "Začněte psát telefonní číslo:", $poleDotaznik,
                                ["id"=>"phone_input", "type"=>"tel", "size"=>"15", "maxlength"=>"15",
                                "list"=>"phone_hints_list", "onkeyup"=>"showHint('phone_hints_list', 'phone', this.value)"]),
                        Html::tag("datalist", ["id"=>"phone_hints_list"]),
                        // type="button" neodesílá form
                        Html::tag("button",
                                ["type"=>"button", "onclick"=>"showPerson('phone_input', 'phone')"],
                                "Najdi osobu z Google formuláře podle telefonu"),
                        ################

//                                $this->context['uk_hint_mobil'],
//                            Html::input($prefixDotaznik.'mobilni_telefon', "Mobilní telefon:", $poleDotaznik, ["type"=>"tel", "size"=>"15", "maxlength"=>"15"]),  //, "required"=>true]),

                              Html::input($prefixDotaznik.'dalsi_telefon', "Další telefon:", $poleDotaznik, ["type"=>"tel", "size"=>"15", "maxlength"=>"15"]),
                            Html::input($prefixDotaznik.'popis_telefon', "Popis:", $poleDotaznik, ["type"=>"text", "size"=>"40", "maxlength"=>"100"])
                        ),
                        Html::tag("p", [],
                            Html::input($prefixDotaznik.'mail', "e-mail:", $poleDotaznik, ["type"=>"email", "size"=>"40"])
                        )
                    )
                ),
                Html::tag("fieldset", [],
                    Html::tag("legend", [], "Údaje ÚP"),

                    Html::tag("fieldset", [],
                        Html::tag("legend", [], "Vysílající ÚP"),
                        Html::tag("p", [],
                            Html::tag("div", [],
                                Html::select($prefixDotaznik."z_up", "Vysílající úřad práce:", ["", "Plzeň-město", "Plzeň-jih", "Plzeň-sever", "Klatovy", "Cheb", "jiné"], $poleDotaznik, [])
                            )
                        )
                    ),
                    Html::tag("fieldset", [],
                        Html::tag("legend", [], "Registrace ÚP"),
                        Html::tag("div", ["class"=>"fieldsetcontainer c1c3"],
                            Html::tag("div", ["class"=>"leftcolumn"],
                                Html::radio(
                                    $prefixCizinec.'faze',
                                    $this->context['faze'],
                                    $poleCizinec
                                )
                            ),
                            Html::tag("div", ["class"=>"rightcolumn"], $this->context['registrace_up'])
                        )
                    ),
                    Html::tag("fieldset", [],
                        Html::tag("legend", [], "Žádosti o rekvalifikace"),
                        Html::tag("div", [],
                            Html::checkbox(
                                [
                                    "Zájem o zvolenou rekvalifikaci jako zákemce"=>[$prefixCizinec."rk_zadost_1"=>"Zájem o zvolenou rekvalifikaci jako zákemce"],
                                    "Zájem o zvolenou rekvalifikaci jako uchazeč"=>[$prefixCizinec."rk_zadost_2"=>"Zájem o zvolenou rekvalifikaci jako uchazeč"]
                                ],
                                $poleCizinec
                            )
                        ),
                            Html::tag("div", ["class"=>"rightcolumn"], $this->context['rekvalifikace_up'])
                    )
                ),
                Html::tag("p", [],
                    Html::input($prefixDotaznik.'datum_vytvor_smlouvy', "Datum registrace Grafia", $poleDotaznik, ["type"=>"date", "size"=>"8", "maxlength"=>"10", "required"=>true])
                ),

                Html::tag("p", [],
                    Html::input("B1", "", ["B1"=>"Uložit"], ["type"=>"submit", "size"=>"8", "maxlength"=>"10"])
                ),
                $poleDotaznik[$prefixDotaznik.'id_zajemce'] ?
                    Html::tag("p", [],
                        Html::input("pdf", "", ["pdf"=>"Tisk"], ["type"=>"submit", "size"=>"8", "maxlength"=>"10"])
                    )
                    : ''
            );

        echo implode(PHP_EOL, $html);
  ?>



<script>
    let dr = document.getElementById("datum_narozeni");
    let po = document.getElementById("pohlavi");
    dr.addEventListener("change", function(){
        let poValue = document.getElementById("pohlavi").value;
        let thisDate = this.valueAsDate;
        let rc = thisDate.toLocaleDateString('cx-CZ').replace(/\s+/g, '') + ' ' + (poValue=='muž' ? 'M' : (poValue=='žena' ? 'Ž' : '') );
        console.log(rc);
        document.getElementById("rodne_cislo").value=rc;
    });
    po.addEventListener("change", function(){
        let thisDate = document.getElementById("datum_narozeni").valueAsDate;
        let poValue = this.value;
        let rc = thisDate.toLocaleDateString('cx-CZ').replace(/\s+/g, '') + ' ' + (poValue=='muž' ? 'M' : (poValue=='žena' ? 'Ž' : '') );
        console.log(rc);
        document.getElementById("rodne_cislo").value=rc;
    });
</script>
<?php
    }
}

