<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Head extends Framework_View_Abstract {

    public function render() {
        $this->parts[] = '<head>
                <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
                <meta content="IE=edge" http-equiv="X-UA-Compatible">
                <title>Grafia.cz | Projektor </title>
                <link rel="SHORTCUT ICON" href="favicon/favicon.ico"/>
                <link rel="stylesheet" type="text/css" href="css/styles.css">
                <link rel="stylesheet" type="text/css" href="css/zaznamy.css">
                <link rel="stylesheet" type="text/css" href="css/form.css">
                <link rel="stylesheet" type="text/css" href="css/hint.css">
                <link rel="stylesheet" type="text/css" href="css/test.css">
                <link rel="stylesheet" type="text/css" href="css/highlight.css" />
                <script src="js/projektor/fieldset.js"></script>
                <script src="js/projektor/projektor.js"></script>';

        $this->parts[] = '</head>';
        return $this;
        }

}

?>
