<?php
/**
 * verze 2.1 - je potomkem Framework_Model_ItemAbstract nikoli Persistable Item
 */
abstract class Framework_Model_ItemFlatTable extends Framework_Model_DbItemAbstract {
    protected $tableName;
    protected $mainObjectIdColumnName;
    protected $id;
    protected $mainObject;
    protected $mainObjectClassName;
    protected $idColumnName;
    protected $mainObjectMapperClassName;

    protected $dbh;
    protected $attributes;
    protected $changed;
    protected $primaryKeyColumnName;

    protected $isHydrated = false;
    protected $isPersisted = false;

    /**
     * Konstruktor přetěžuje rodičovský konstruktor. Může být volán s parametrem $mainObject.
     * Pro první zapsání dat objektu flat table do databáze (insert) musí být main objekt nastaven. Lze ho dodatečně
     * nastavit metodou setMainObject().
     *
     * @param string $tableName Název db tabulky
     * @param string $mainObject
     * @param string $idColumnName Název sloupce s primárním klíčem db tabulky $table_name. Pokud parametr není zadán,
     *          metoda použije default hodnotu složenou z prefixu 'id_' a názvu tabulky (např. pro název tabulky 'osoba' použije !id_osoba'
     * @param string $mainObjectMapperClassName Název třídy mapperu, který vytvoří nový main object k pravě vytvářenímu objektu flat table
     * @throws UnexpectedValueException
     */
    public function __construct($tableName, $mainObject=null, $idColumnName=NULL) {
        $this->tableName = $tableName;
        $this->idColumnName = $idColumnName;
        if (isset($mainObject)) {
            $this->initializeMainObject($mainObject);
        }
        $this->dbh = Config_AppContext::getDb();
        // jedno načtení trvá cca 10ms, bez cache se jedna struktuta (struktura jedné tabulky) čte průměrně 5x
        $this->attributes = Framework_Database_Cache::getAttributes($this->dbh, $this->tableName);
        $this->primaryKeyColumnName = Framework_Database_Cache::getPrimaryKeyName($this->dbh, $this->tableName);
    }

    ########################
    # public
    ########################

    public function  setMainObject($mainObject) {
        $this->initializeMainObject($mainObject);
    }

    /**
     * Getter, vrací jen existující vlastnosti.
     * @param type $name
     * @return type
     */
    public function __get($name){
        $this->hydrate();
        if(array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
    }

    /**
     * Setter, přetěžuje setter rodiče. Nastavuje jen hodnoty existujících atributů, nepřidává další.
     * 
     * Hodnotu vstupního parametru převede na odpovídající typ podle typu databázového sloupce.
     * 
     * V případě, že $name neodpovídá existující vlastnosti metoda jen tiše skončí. Jedinou výjimkou je pokus o nastavení atributu
     * odpovídajícího id objektu, v takovém případě metoda vyhodí výjimku.
     * 
     * @param type $name
     * @param type $value
     * @return void
     * @throws UnexpectedValueException
     */
    public function __set($name,$value){
        $this->hydrate();
        if ($name == $this->primaryKeyColumnName) {
            throw new UnexpectedValueException("Chybný parametr metody __set(). Nelze nastavovat vlastnost '$name' odpovídající primárnímu klíči tabulky '$this->tableName");
        } elseif(!array_key_exists($name, $this->attributes)) {
            throw new UnexpectedValueException("Chybný parametr metody __set(). Nelze nastavovat vlastnost '$name', tabulka '$this->tableName' nemí atribut s takovým jménem.");            
        }
        $this->changeAttribute($name, $value);
    }
    
    private function changeAttribute($name, $value) {
        // v attributes je typ přečtený z db (findAll) - int je integer, ostatní string nebo null
        // value je z POST -> vždy string
        // tato nerovnost je splněna např. pokud v db je int 1 a value je string '1', zapíše se changed a updatuje se
        // => podle typu hodnoty attributes udělat cast value a pak porovnat nebo použít jen porovnání !=
        // ?? pro porovnání != , atribut null a value '' - to je případ dosud nazadané hodnoty - ve formuláři mám hidden pole - typicky kurz fieldset
        // a pokouším se zapsat prázdný string do sloupce, který může být například datetime - exception
        
        if (isset($value)) {
            $castedValue = $this->castValueByAttributeType($name, $value);
            if (!isset($this->attributes[$name]) || ($this->attributes[$name]!==$castedValue)) {
                $this->changed[$name] = $castedValue;
                $this->attributes[$name] = $castedValue;        
            }
        } else {
            if (isset($this->attributes[$name])) {
                $this->changed[$name] = 'NULL';
                $this->attributes[$name] = $value; 
            }
        }
            
    }
    
    /**
     * Očekává, že položky $this->attributes jsou typu, který odpovídá typi sloupce v databázi.
     * To je splněno, v konstruktoru se atributy "nastaví" voláním Framework_Database_Cache::getAttributes()
     * 
     * @param type $name
     * @param type $value
     * @return type
     */
    private function castValueByAttributeType($name, $value) {
        // typ atributu se sice nastaví v konstruktoru, ale pokud hodnota, kterou je hydratován je null, typ se ztratí
        // TODO: oddělené pole pro typ atributů (podle db), pole pro hodnoty atributů a changed -> cast podle pole typů
        if (!isset($this->attributes[$name])) {
            // attribut je null - tj. neznám jeho typ - metoda se volá jen pokud $value není null, atribut a changed bude nastaveno
            if ($value==='') {
                return null;  // tady předpoládám, že pokud atrubit je null a z formuláře přišel prázdný string, znamená to, že nebyla zadána žádná hodnota (nepočítám s regulérním možností zadání prízdného řetězce)
            } else {
                return $value;  
            }
        } elseif (is_string($this->attributes[$name])) {
            if ($value instanceof \DateTime) { 
                /** @var DateTime $value */
                return $value->format('Y-m-d');
            } else {
                return (string) $value;
            }
        } elseif (is_int($this->attributes[$name])) {
            return (int) $value;
        } elseif (is_float($this->attributes[$name])) {
            return (float) $value;
        }
    }

    public function setPersisted($persisted = false) {
        $this->isPersisted = $persisted;
    }

    /**
     * Pokud nejsou ještě nastaveny atributy (item není hydrated) a je nastaven main object (již je zapsáno v db)
     * Nastaví hodnoty atributů 
     * - pokud je zadán parametr data, nastaví atributy podle zadanáho parametru - takto se metoda volá při hydratování kolekce, 
     *   kdy jsou všechna data načtena najednou jako pole
     * - pokud není zadán parametr data, pokusí se přečíst záznam z databáze a hydratuje takto získanými daty
     * 
     * @param type $data
     * @return $this
     */
    public function hydrateItem($data) {
        if ($this->isHydrated) {
                    throw new LogicException("Nelze hydratovat Item externími daty. Objekt ".get_class()." byl již hydtatován.");
        } elseif ($data) {
            $this->hydrateAttributes($data);
            $this->isPersisted = true;
        }
        $this->isHydrated = true;                        
        return $this;
    }
    
    protected function hydrate() {
        if (!$this->isHydrated) {
            if(isset($this->mainObject->id)){  // mainOnject nemá id = není zapsáno v db, je zbytečné číst
                $data = $this->select();
                if ($data) {
                    $this->hydrateAttributes($data);
                    $this->isPersisted = true;
                }
            }
            $this->isHydrated = true;
        }
        return $this;        
    }

    private function hydrateAttributes($data) {
        foreach ($data as $name => $value) {  // nastaví jen položky, které nebyly již měněny
            if (!isset($this->changed[$name])) {
                $this->attributes[$name] = $value;
            }
        }
        $this->id = $this->attributes[$this->primaryKeyColumnName];
    }
    
    /**
     *
     * @return \Framework_Model_ItemFlatTable
     * @throws LogicException
     * @throws UnexpectedValueException
     */
    public function save() {
        if($this->isHydrated) {  //isHydrated se mění na true při __get, __set, getIterator a insert - pokud item není hydrated, není třeba nic zapisovat
            if ($this->isPersisted) {
                $this->update();
            } else {
                if (!isset($this->mainObject)) {
                    throw new LogicException("Není nastaven main object v objektu ".get_class().". Nelze ukládat data potomkovského flat table objektu bez exitujícího main objektu.");
                }
                if (!array_key_exists($this->mainObjectIdColumnName, $this->attributes)) {
                    throw new UnexpectedValueException("Nenalezen očekávaný atribut pro zapsání hodnoty id hlavního objektu s názvem '$this->mainObjectIdColumnName'. Pravděpodobně neexistuje takový sloupec v tabulce '$this->tableName'.");
                }
                $this->insert();
            }
        }
        return $this;
    }

    public function getMainObject() {
        return $this->mainObject;
    }

    public function isCreatedNewMainObject() {
        return $this->isCreatedNewMainObject;
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function getPrimaryKeyColumnName() {
        return $this->primaryKeyColumnName;
    }

    /**
     * Metoda vrací iterátor obsahující public vlastnosti objektu. Přetěžuje metodu rodiče.
     * @return \ArrayIterator
     */
    public function getIterator() {
        $this->hydrate();
        return new ArrayIterator($this->attributes);
    }

    ########################

    /**
     * Připraví jméno sloupce pro zapsání hodnoty primárního klíče hlavního objektu do potomkovské objektu flat
     * @param type $mainObject
     * @throws LogicException
     */
    private function initializeMainObject($mainObject) {
        $mainObjectClassName = get_class($mainObject);  //proměnná jen kvůli syntaxi $mainObjectClassName::TABLE
        if (isset($this->idColumnName ) AND $this->idColumnName){
            $this->mainObjectIdColumnName = $this->idColumnName;
        } elseif ($mainObjectClassName::TABLE) {
            $this->mainObjectIdColumnName = 'id_'.$mainObjectClassName::TABLE;
        } else {
            throw new LogicException("Nelze vytvořit default název primárního klíče flat table. Parametr konstruktoru \$idColumnName nebyl nastaven a hlavní objekt $this->mainObjectClassName nemá konstantu TABLE, ze které lze odvodit default hodnotu." );
        }
        $this->mainObject = $mainObject;
    }



    private function select() {
//!! tato podmínka vybírá v případě vazby 1:N (planKurz) recordset se všemi kurzy (pro kolekci) a následné fetch vrací vždy jen první položku
//!! primární klíč v tomto případě není $this->mainObject->id

    $whereParams = array($this->mainObjectIdColumnName=>$this->mainObject->id);
        $query = 'SELECT '.implode(', ', array_keys($this->attributes)).' FROM '.$this->tableName.$this->createWhereExpression($whereParams);
        $sth = $this->dbh->prepare($query);
        $succ = $sth->execute($whereParams);
        $data = [];
        if ($succ) {
            $data = $sth->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }


    /**
     *
     * @throws RuntimeException
     */
    private function update() {
        if ($this->changed) {
            $set = [];
            foreach (array_keys($this->changed) as $col) {
                    $set[] = $col . " = :" . $col;
            }
            $whereParams = array($this->primaryKeyColumnName=>$this->attributes[$this->primaryKeyColumnName]);
            $query = "UPDATE ".  $this->tableName." SET ".implode(", ", $set).$this->createWhereExpression($whereParams);
            $sth = $this->dbh->prepare($query);
            try {
                $data = array_merge($this->changed, $whereParams);
                $sth->execute($data);
            } catch (\PDOException $e) {
                throw new \RuntimeException("Nepodařilo se provést příkaz $query.", 0,$e);
            }
            $this->changed = array();
        }
    }

    /**
     *
     * @throws RuntimeException
     */
    private function insert() {
            $this->attributes[$this->mainObjectIdColumnName] = $this->mainObject->id;
            $this->changed[$this->mainObjectIdColumnName] = $this->mainObject->id;

            $cols = implode(', ', array_keys($this->changed));
            $values = ':'.implode(', :', array_keys($this->changed));
            $query = "INSERT INTO ".$this->tableName." (".$cols.")  VALUES (" .$values.")";
            $sth = $this->dbh->prepare($query);
            try {
                $sth->execute($this->changed);
            } catch (\PDOException $e) {
                throw new \RuntimeException("Nepodařilo se provést příkaz $query.", 0, $e);
            }
            $this->id = $this->dbh->lastInsertId();
            $this->attributes[$this->primaryKeyColumnName] = $this->id;
            $this->changed = array();
            $this->isPersisted = true;
            $this->isHydrated = true;
    }

    private function createWhereExpression($whereBind, $boolOperator = "AND") {
        if($whereBind) {
            $whereConditions = array();
            foreach (array_keys($whereBind) as $col) {
                $whereConditions[] = $col . " = :" . $col;
            }
            $expr = ' WHERE '.implode(" ".$boolOperator." ", $whereConditions);
        }
        return $expr;
    }

}