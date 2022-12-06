<?php

/**
 * Description of NavigationLevel
 *
 * @author pes2704
 */
class Projektor2_Model_NavigationLevel {

    const TYPE_LIST = 'list';

    const TYPE_EXPORT = 'export';
    const TYPE_DETAIL = 'detail';

    private $type;
    private $httpQuery;
    private $title;

    public function getType() {
        return $this->type;
    }

    public function getHttpQuery() {
        return $this->httpQuery;
    }
    public function getTitle() {
        return $this->title;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setHttpQuery($httpQuery) {
        $this->httpQuery = $httpQuery;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

}
