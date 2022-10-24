<?php

/**
 * Description of SqlTemplateZajemci
 *
 * @author pes2704
 */
class Projektor2_Controller_Export_SqlTemplate_SqlTemplate {

    /**
     * @var Projektor2_Model_SessionStatus
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

    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Request $request) {
        $this->sessionStatus = $sessionStatus;
        $this->request = $request;
    }

    /**
     * Interpoluje sql template.
     * Proměnné ze session generuje a interpoluje automaticky, ostatní proměnné je třeba zadat v asociativní poli params.
     * Proměnné ze session jsou generovány se jmény: 'idProjekt', 'idKancelar', 'idBeh', 'idZajemce', 'idSKurz'
     *
     * @param string $sqlFilename Jméno souboru s SQL šablonou včetně přípony, soubor se musí nacháte v podsložce Templates složky, ve které je definována tato třída
     * @param array $params
     * @return string
     */
    public function getTemplate($sqlFilename, array $params = []) {

        $template = file_get_contents(__DIR__."/Templates/$sqlFilename");
        return $this->interpolate($template, "{{", "}}", $this->getData($params));
    }

    public function getUsedParams() {
        return $this->usedParams;
    }

    private function getData(array $params=[]) {
        $sessionData = [
            'idProjekt'=>$this->sessionStatus->projekt->id,
            'idKancelar'=>$this->sessionStatus->kancelar->id,
            'idBeh'=>$this->sessionStatus->beh->id,
            'idZajemce'=>$this->sessionStatus->zajemce->id,
            'idSKurz'=>$this->sessionStatus->sKurz->id_s_kurz
        ];
        $this->usedParams = array_merge(
                $sessionData,
                $this->request->paramArray(),
                $params
                );
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
