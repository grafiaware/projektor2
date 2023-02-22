<?php

/**
 * Description of RequestLogger
 *
 * @author pes2704
 */
class Projektor2_Logger_RequestLogger {
    /**
     *
     * @var Framework_Logger_File
     */
    private $logger;

    public function __construct(Framework_Logger_File $logger) {
        $this->logger = $logger;
    }

    public function log(Projektor2_Model_Status $status, Projektor2_Request $request) {
        $part[] = date('Y-m-d H:i:s');
        if ($status->getUserStatus()) {
            $part[] = $status->getUserStatus()->getUser()->username;
            $part[] = $status->getUserStatus()->getProjekt()->kod;
            $part[] = $status->getUserStatus()->getKancelar()->kod;
            $part[] = $status->getUserStatus()->getBeh()->beh_cislo;
            $part[] = $status->getUserStatus()->getZajemce()->id;
            $part[] = $status->getUserStatus()->getZajemce()->identifikator;
            $part[] = $status->getUserStatus()->getSKurz()->id_s_kurz;
        }
        if ($request->isGet()) {
            $part[] = 'GET';
            $part[] = preg_replace("/\s+/u", " : ", print_r($request->getArray(), true));
        } elseif($request->isPost()) {
            $part[] = 'POST';
            $part[] = preg_replace("/\s+/u", " : ", print_r($request->getArray(), true));
//            $part[] = preg_replace("/\s+/u", " : ", print_r($request->postArray(), true));
        } else {
            $part[] = 'METHOD NOT RECOGNIZED';
        }
//        $part[] = $request->isGet() ?  : ($request->isPost() ? 'POST' : 'METHOD NOT RECOGNIZED');
//        $part[] = preg_replace("/\s+/u", " : ", print_r($request->getArray(), true));
//        $part[] = preg_replace("/\s+/u", " : ", print_r($request->postArray(), true));
        $this->logger->log(implode(' | ', $part));
    }
}
