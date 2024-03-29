<?php

/**
 * Description of SqlTemplateZajemci
 *
 * @author pes2704
 */
class Projektor2_Controller_Export_SqlTemplate_SqlTemplate {

    /**
     * @var Projektor2_Model_Status
     */
    protected $sessionStatus;
    /**
     * @var Projektor2_Request
     */
    protected $request;
    /**
     * @var Projektor2_Response
     */
    protected $response;
    protected $usedParams;

    public function __construct(Projektor2_Model_Status $sessionStatus, Projektor2_Request $request) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
    }

    /**
     * Interpoluje sql template.
     * Proměnné ze session generuje a interpoluje automaticky, ostatní proměnné je třeba zadat v asociativní poli params.
     * Proměnné ze session jsou generovány se jmény: 'idProjekt', 'idKancelar', 'idBeh', 'idZajemce', 'idSKurz'
     *
     * @param string $sqlFilepath Úplná cesta k souboru s SQL šablonou včetně přípony
     * @param array $params
     * @return string
     */
    public function getTemplate($sqlFilepath, array $params = []) {

        $template = file_get_contents($sqlFilepath);
        return $this->interpolate($template, "{{", "}}", $this->getData($params));
    }

    public function getUsedParams() {
        return $this->usedParams;
    }

    private function getData(array $params=[]) {
        $sessionData = [
            'idProjekt'=>$this->sessionStatus->getUserStatus()->getProjekt()->id,
            'idKancelar'=>$this->sessionStatus->getUserStatus()->getKancelar()->id,
            'idBeh'=>$this->sessionStatus->getUserStatus()->getBeh()->id,
            'idZajemce'=>$this->sessionStatus->getUserStatus()->getZajemce()->id,
            'idSKurz'=>$this->sessionStatus->getUserStatus()->getSKurz()->id_s_kurz
        ];
        $this->usedParams = array_merge(
                $sessionData,
                $this->request->paramArray(),
                $params
                );
        foreach ($this->usedParams as $key => $value) {
            if($value===null) {
                $this->usedParams[$key] = 'NULL';
            } elseif (!is_numeric ($value)) {
                $this->usedParams[$key] = "'".(string)$value."'";
            }
        }
        return $this->usedParams;
    }

    /**
     * Použije text souboru jako šablonu a nahradí slova v závorkách hodnotami pole dat s klíčem rovným nahrazovanému slovu.
     *
     * Pokud některá hodnota není definována nebo ji nelze převést na string - nahradí slovo v závorkách prázdným řetězcem a Hlásí user_error.
     *
     * @param type $data Array nebo \Traversable
     * @return string
     * @throws NoTemplateFileException
     */
    protected function interpolate($text, $leftBracket, $rightBracket, iterable $data=NULL) {
            if (isset($data)) {
            $replace = [];
            // sestav pole náhrad
            foreach ($data as $key => $val) {
                // ověř, že hodnota může být převedena na string
                if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                    $replace[$leftBracket . $key . $rightBracket] = $val;
                } else {
                    $replace[$leftBracket . $key . $rightBracket] = '';
                    user_error("Hodnota s klíčem $key není definována nebo hodnotu nelze převést na string.", E_USER_WARNING);
                }
            }
                // interpoluj náhrady do textu
                return strtr($text, $replace);
            } else {
                return $text;
            }
    }
}
