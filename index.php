<?php
ob_start();
require __DIR__ . '/vendor/autoload.php';
// exception handler
require_once 'Bootstrap.php';
// zajištění autoload pro Projektor
//require_once 'Projektor2/Autoloader.php';
//Projektor_Autoloader::register();
require_once 'Classes/PHPExcel.php';  // uvnitř v Classes/PHPExcel.php se provede PHPExcel_Autoloader::Register();

### DOČASNÉ ##########################
//ini_set('max_execution_time', 45);
######################################

$session = Projektor2_Session::getInstance();
$request = new Projektor2_Request();
$response = new Projektor2_Response();
//$app = new Projektor2_Application($request, $response);


$logger = new Projektor2_Logger_RequestLogger(
        // denní logy - jméno začíná "číslem" dne
        Framework_Logger_File::getInstance(Config_AppContext::getLogsPath(), 'SessionStatus/'.date('Ymd').' SessionStatus.log')
        );

$sessionStatus = Projektor2_Model_Status::create($session);
$sessionStatus->setLastGet($request);
$logger->log($sessionStatus, $request);

$pageController = new Projektor2_Controller_Page($sessionStatus, $request, $response);

$response->addHeader("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0");
$response->addHeader("Cache-Control", "post-check=0, pre-check=0", false );  // don't replace apache header
$response->addHeader("Pragma", "no-cache");

$response->setBody($pageController->getResult());
$sessionStatus->save($session);
$response->send();

