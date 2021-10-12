<?php
// Transformuje hodnoty ve flat tabulkách projektoru.
// Volá Transformer_Controller pro projekt zadaný pomocí id_projekt, jako transformační closure vybírá z kontejneru metodu DatumRfcToCzech 
// a předává logger - bude se tedy logovat

// error handler, exception handler a autoload
require_once 'Bootstrap.php';


$saveValues = FALSE;  // nebude se zapisovat do dazabáze
//$saveValues = TRUE;   // BUDE se zapisovat do databáze

(new Transformer_Controller())
        ->setSaveTransformedValuesToDatabase($saveValues)
        ->run(
        11, 
        Transformer_TransformingClosureContainer::DatumRfcToCzech(), 
        Framework_Logger_File::getInstance('Logs', 'Transformer.log')
    );

