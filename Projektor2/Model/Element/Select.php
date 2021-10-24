<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Projektor2_Model_Element_Select
 *
 * @author pes2704
 */
class Projektor2_Model_Element_Select {

    /*
     *      * 'selectId' string id atribut prvku select
     * 'selectName'
     * 'valuesArray' array pole návratových hodnot, jde o pole skalárů nebo objektů, slouží také pro generování jednotlivých elementů option
     * 'returnedObjectProperty' string jméno vlastnosti objektu použité pro návratovou hodnotu, pokud valuesArray je pole objektů
     * 'actualValue' string současná hodnota proměnné formuláře - slouží pro výběr příslušné option jako selected
     * 'innerTextCallable' callable je volán pro vygenerování zobrazovaných textů jednotlivých option vytvožených z položek valuesArray (např. array($this,'text_retezec_kurz'))
     * 'onChangeJsCode' string javascriptový kód volaný při změně hodnoty selectu (např, 'submitForm(this);' provede submit formuláře po ksždé změně hodnoty
     * 'readonly' mixed pokud je TRUE je select je pouze pro čtení
     * 'required' mixed pokud je TRUE je select requird, toto je funkční je pokud hodnoty "nevybraného" slectu (tedy první option) je vyhodnocována jako FALSE (napž. prázdný řetězec)
     */
    private $selectName;
    /**
     * @var iterable
     */
    private $values;
    private $actualValue;
    private $returnedObjectProperty;

    private $selectId='';
    private $readonly=false;
    private $disabled=false;
    private $required=false;
    private $display='block';
    private $size=1;
    private $onChangeJsCode='';
    private $innerTextCallable=null;

    /**
     *
     * @param string $selectName Atribut name prvku select (jméno proměnné formuláře)
     * @param iterable $values Návratové hodnoty, položky jou typu skalár nebo objekt, slouží pro generování jednotlivých elementů option
     * @param mixed $actualValue Aktuální hodnota proměnné formuláře, tedy hodnota před provedením výběru položky elementu select uživatelem - slouží pro označení příslušné option jako selected.
     *          Přitom se řídí podle hodnot jednotlivých option, jako selected je vybrána option se stejnou hodnotou. To praktické řešení, ale vyžaduje unikátní hodnoty jednotlivých options.
     * @param string $returnedObjectProperty Pokud valuesArray obsahuje objekty, je toto jméno vlastnosti objektu, jejíž hodnota bude použita jako hodnota jednotlivých voleb (options).
     *          Předpokladem je. že příslušná vlastnost objektu je public.
     */
    public function __construct($selectName, $values, $actualValue=null, $returnedObjectProperty=null) {
        $this->selectName = $selectName;
        $this->values = $values;
        $this->actualValue = $actualValue;
        $this->returnedObjectProperty = $returnedObjectProperty;
    }

    /**
     * Atribut name prvku select (jméno proměnné formuláře)
     * @return string
     */
    public function getSelectName() {
        return $this->selectName;
    }

    /**
     * Návratové hodnoty, položky jou typu skalár nebo objekt, slouží pro generování jednotlivých elementů option
     * @return iterable
     */
    public function getValues(): iterable {
        return $this->values;
    }

    /**
     * id atribut prvku select
     * @return string Default hodnota je prázdná řetězec
     */
    public function getSelectId() {
        return $this->selectId;
    }

    /**
     * pokud je TRUE je select je pouze pro čtení, to je dosaženo nastavení atributu disabled=true, v případě elementu Select je tak readonly ekvivalentem disabled.
     * @return bool Default hodnota je false
     */
    public function getReadonly() {
        return $this->readonly;
    }

    /**
     * pokud je TRUE je select je pouze pro čtení, v případě elementu Select je tak disabled ekvivalentem readonly.
     * @return bool Default hodnota je false
     */
    public function getDisabled() {
        return $this->disabled;
    }

    /**
     * Pokud je true, je select required, tedy vyžaduje výběr jiné než výchozí volby. Výchozí volbou je první option, podmínkou funkčnosti tété volby je, aby hodnota výchozí volby (option)
     * (tedy první option) byla vyhodnocována jako FALSE (napž. prázdný řetězec).
     *
     * @return bool Default hodnota je false
     */
    public function getRequired() {
        return $this->required;
    }

    /**
     * Hodnota atributu style elementu.
     * @return string Default hodnota je "block"
     */
    public function getDisplay() {
        return $this->display;
    }

    /**
     * Počet počet současně viditelných voleb (option), tedy počet řádků viditelných v oblasti elementu pro výběr.
     * @return integer
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Javascriptový kód volaný při změně hodnoty selectu, tedy při události "onChange".
     * Příklad: např. zadání hodnoty 'submitForm(this);' provede submit formuláře po každé změně hodnoty.
     *
     * @return string
     */
    public function getOnChangeJsCode() {
        return $this->onChangeJsCode;
    }

    /**
     * Aktuální hodnota proměnné formuláře, tedy hodnota před provedením výběru položky elementu select uživatelem - slouží pro označení příslušné option jako selected.
     * Přitom se řídí podle hodnot jednotlivých option, jako selected je vybrána option se stejnou hodnotou. To praktické řešení, ale vyžaduje unikátní hodnoty jednotlivých options.
     *
     * @return mixed
     */
    public function getActualValue() {
        return $this->actualValue;
    }

    /**
     * Pokud valuesArray obsahuje objekty, je toto jméno vlastnosti objektu, jejíž hodnota bude použita jako hodnota jednotlivých voleb (options).
     * Předpokladem je. že příslušná vlastnost objektu je public.
     *
     * @return string
     */
    public function getReturnedObjectProperty() {
        return $this->returnedObjectProperty;
    }

    /**
     * Callable, která bude volána při generování jednotlivých voleb (options) a jejíž návratová hodnota bede vložena jako text zobrazený pro volby (text option).
     *
     * To umožňuje např. generovat text z hodnot jednotlivých voleb, tedy např. z objektů, které mohou být hodnotami.
     * @return type
     */
    public function getInnerTextCallable() {
        return $this->innerTextCallable;
    }


    /**
     * Umožňuje nastavit nepovinný parametr - id atribut prvku select
     *
     * @param type $selectId
     * @return $this
     */
    public function setSelectId($selectId) {
        $this->selectId = $selectId;
        return $this;
    }

    /**
     * Umožňuje nastavit nepovinný parametr
     *
     * @param type $readonly
     * @return $this
     */
    public function setReadonly($readonly) {
        $this->readonly = $readonly;
        return $this;
    }

    /**
     *
     * @param type $disabled
     * @return $this
     */
    public function setDisabled($disabled) {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     *
     * @param type $required
     * @return $this
     */
    public function setRequired($required) {
        $this->required = $required;
        return $this;
    }

    /**
     *
     * @param type $display
     * @return $this
     */
    public function setDisplay($display) {
        $this->display = $display;
        return $this;
    }

    /**
     *
     * @param type $size
     * @return $this
     */
    public function setSize($size) {
        $this->size = $size;
        return $this;
    }

    /**
     *
     * @param type $onChangeJsCode
     * @return $this
     */
    public function setOnChangeJsCode($onChangeJsCode) {
        $this->onChangeJsCode = $onChangeJsCode;
        return $this;
    }

    /**
     *
     * @param type $innerTextCallable
     * @return $this
     */
    public function setInnerTextCallable($innerTextCallable) {
        $this->innerTextCallable = $innerTextCallable;
        return $this;
    }


}
