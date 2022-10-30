<?php
namespace Gogo\Viewmodel;

//use Google\Service\Sheets\ValueRange;

/**
 * Description of Hint
 *
 * @author pes2704
 */
class Person extends ViewmodelAbstract {

    private $headers;

    private $values;

    /**
     *
     * @param array $headers Pole titulků sloupců.
     */
    public function setHeaders(array $headers) {
        $this->headers = $headers;
    }

    /**
     *
     * @param array $values Pole hodnot jednoho řádku.
     */
    public function setResponseValues(array $values) {
        $this->values = $values;
    }

    /**
     * Zkombinuje header a row values a vygeneruje JSON s dvojicemi 'header' a 'value'.
     *
     * Pole headers a response values musí být předem zadány voláním setHeaders() a setResponseValues().
     * Metoda se prioritně řídí položkami pole headers, vyýsledný JSON vždy obsahuje včechny položky obsažené v poli headers.
     * Pokud pole values neobsahuje položku odpovídající některé položce headers, metoda jako hodnotu pro json použije hodnotu parametru defaultValue.
     *
     * @param string $defaultValue
     * @return string JSON
     * @throws LogicException Nejsou zadány response values.
     * @throws LogicException Nejsou zadány headers.
     */
    public function getPersonJson($defaultValue="-----") {
        if (!$this->values) {
            throw new LogicException("Nejsou zadány response values.");
        }
        if (!$this->headers) {
            throw new LogicException("Nejsou zadány headers.");
        }
        foreach ($this->headers as $col => $header) {
            if (array_key_exists($col, $this->values)) {
                $arrayPerson[] = ["header"=>$header, "value"=>$this->values[$col]];
            } else {
                $arrayPerson[] = ["header"=>$header, "value"=>"-----"];
            }
        }
        $jsonPerson = json_encode($arrayPerson, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);  // JSON_UNESCAPED_UNICODE pro zobrazení v html
        return $jsonPerson;
    }

}
