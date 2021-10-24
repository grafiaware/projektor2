<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CollectionFlatTable
 *
 * @author pes2704
 */
class Framework_Model_CollectionFlatTable implements \IteratorAggregate {
    protected $tableName;
    protected $idColumnName;
    protected $isCreatedNewMainObject;
    protected $mainObjectMapperClassName;

    protected $dbh;
    protected $attributes;
    protected $primaryKeyColumnName;

    /**
     * Prvky kolekce
     * @var Framework_Model_ItemFlatTable
     */
    private $item;
    private $isHydrated;

    public function __construct($tableName, $mainObject=null, $idColumnName=NULL, $mainObjectMapperClassName=NULL) {
        $this->tableName = $tableName;
        $this->idColumnName = $idColumnName;
        if ($mainObject) {
            $this->initializeMainObject($mainObject);
            $this->isCreatedNewMainObject = FALSE;
        } else {
            if (!$mainObjectMapperClassName) {
                throw new UnexpectedValueException('Není zadán hlavní objekt a není zadán ani mapper pro jeho vytvoření.');
            } else {
                $this->mainObjectMapperClassName = $mainObjectMapperClassName;
            }
        }
        $this->dbh = Projektor2_AppContext::getDb();
        // jedno načtení trvá cca 10ms, bez cache se jedna struktuta (struktura jedné tabulky) čte průměrně 5x
//        //Nacteni struktury tabulky, datovych typu a ost parametru tabulky
//        $query = "SHOW COLUMNS FROM ".$this->tableName;
//        $sth = $this->dbh->prepare($query);
//        $succ = $sth->execute();
//        $columnsInfo = $sth->fetchAll(PDO::FETCH_ASSOC);
//        foreach($columnsInfo as $columnInfo) {
//            $this->attributes[$columnInfo['Field']] = $columnInfo['Default'];
//            if ($columnInfo['Key']=="PRI") $this->primaryKeyColumnName = $columnInfo['Field'];
//        }
        $this->attributes = Framework_Database_Cache::getAttributes($this->dbh, $this->tableName);
        $this->primaryKeyColumnName = Framework_Database_Cache::getPrimaryKeyName($this->dbh, $this->tableName);
    }

    private function initializeMainObject($mainObject) {
        $this->mainObject = $mainObject;
        $mainObjectClassName = get_class($mainObject);  //proměnná jen kvůli syntaxi $mainObjectClassName::TABLE
        $this->mainObjectClassName = $mainObjectClassName;
        if ($this->idColumnName){
            $this->mainObjectIdColumnName = $this->idColumnName;
        } elseif ($mainObjectClassName::TABLE) {
            $this->mainObjectIdColumnName = 'id_'.$mainObjectClassName::TABLE;
            } else {
                throw new LogicException("Nelze vytvořit default název primárního klíče flat table. Parametr konstruktoru \$idColumnName nebyl nastaven a hlavní objekt $this->mainObjectClassName nemá konstantu TABLE, ze které lze odvodit default hodnotu." );
            }
    }

    private function createNewMainObject() {
        $mapperClassName = $this->mainObjectMapperClassName;
        $mainObject = $mapperClassName::create();
        $this->initializeMainObject($mainObject);
        $this->isCreatedNewMainObject = TRUE;
    }

    public function isCreatedNewMainObject() {
        return $this->isCreatedNewMainObject;
    }

    protected function hydrate() {
        if (!$this->isHydrated) {
            if(!isset($this->mainObject->id)){
                return $this;
            } else {
                $data = $this->select();
                if($data) {
                    foreach ($data as $row) {  //$this->attributes = $data;
                        $item = $this->createItem($this->mainObject);
                        $item->hydrate($row);   // nastaví item->isHydrated, ->isPersisted
                        $this->item[$this->provideCollectionKey($row)] = $item;
                    }
                }
                $this->isHydrated = TRUE;
            }
        }
        return $this;
    }

    /**
     * Možno přetížit a tím získat jinou kolekci - může být řazena podle jiného klíče něž podle "primárního klíče". Podmínkou je, aby
     * se jednalo v rámci kolekce o klíč unikátní.
     * @return type
     */
    private function select() {

        $whereBinds = $this->provideWhereBindParams();
        $query = 'SELECT '.implode(', ', array_keys($this->attributes)).' FROM '.$this->tableName.$this->createWhereExpression($whereBinds);
        $sth = $this->dbh->prepare($query);
        $succ = $sth->execute($whereBinds);
        $data = [];
        if ($succ) {
            $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
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

    /**
     *
     * @return array
     */
    protected function provideWhereBindParams(): array {
        return [$this->mainObjectIdColumnName=>$this->mainObject->id];
    }

    /**
     *
     * @return string
     */
    protected function provideCollectionKey($row) {
        return $row[$this->primaryKeyColumnName];
    }

    /**
     *
     * @return \Framework_Model_ItemFlatTable
     * @throws LogicException
     * @throws UnexpectedValueException
     */
    public function save() {
        if(!$this->mainObject->id){
            $this->createNewMainObject();
        }
        foreach ($this->item as $key => $item) {
            $item->save();
        }
        return $this;
    }

    /**
     *
     * @param mixed $id
     * @return Framework_Model_ItemFlatTable
     */
    public function getItem($id) {
        if ($this->isPersisted !== FALSE) {
            $this->hydrate();
        }
        return array_key_exists($id, $this->item) ? $this->item[$id] : null;
    }

    /**
     * Metoda vrací iterátor obsahující public vlastnosti objektu. Přetěžuje metodu rodiče.
     * @return \ArrayIterator
     */
    public function getIterator() {
        if ($this->isPersisted !== FALSE) {
            $this->hydrate();
        }
        return new ArrayIterator($this->item);
    }
}
