<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Sjpk_Export extends Framework_View_Abstract {

    public function render() {
        $this->parts[] = '<h3>Export tabulkových přehledů</h3>';
        $this->parts[] = '<div class="left">
                                <ul id="menu">
                                    <hr>
                                    <li><a href="index.php?akce=seznam">Zpět na zobrazení registrací</a></li>';                                    
        $this->parts[] = '        </ul>
                        </div>';
        $this->parts[] = '<div class="content">';
            $this->parts[] = '
                            <form method="POST" action="index.php?akce=export" name="vyber_tabulky">
                                  Databázové tabulky: <br>
                                <select ID="dbtabulka" size="1" name="dbtabulka">
                                <option >------------</option>
                                <option value=v_sjpk_zajemci>Monitoring - všichni zájemci v projektu</option>
                                <option value=v_sjpk_kurzy>Monitoring - všechny kurzy v projektu</option>
                                <option value=v_mi_vstoupily>Monitoring - vstoupili do zadaného data monitoringu</option>
                                <option value=v_mi_vstoupily_souhrn_kancelare>Monitoring - vstoupili do zadaného data monitoringu souhrn za kanceláře</option>
                                <option value=v_mi_vstoupily_souhrn_celkem>Monitoring - vstoupili do zadaného data monitoringu - souhrn celkem</option>
                                </select><br>
                                <input type="submit" value="Export" name="E1">
                            </form>';
        $this->parts[] = '</div>';
        return $this;
    }

}

?>
