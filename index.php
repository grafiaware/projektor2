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
ini_set('max_execution_time', 45);
######################################

$request = new Projektor2_Request();
$response = new Projektor2_Response();
//$app = new Projektor2_Application($request, $response);

// zjištění, zda je uživatel přihlášen
// pokud ano nastaví proměnnou $userid, pokud ne, dojde k přesměrování na login
//try {
    $logger = Framework_Logger_File::getInstance(Projektor2_AppContext::getLogsPath(), 'SessionStatus/'.date('Ymd').' SessionStatus.log');  // denní logy - jméno začíná "číslem" dne
    $sessionStatus = Projektor2_Model_SessionStatus::createSessionStatus($request, $response, $logger);
//}
//catch (Projektor2_Auth_Exception $e) {
//    header("Location: ./login.php?originating_uri=".$_SERVER['REQUEST_URI']);
//    $response->send();
//    exit;
//}

$pageController = new Projektor2_Controller_Page($sessionStatus, $request, $response);

$response->addHeader("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0");
$response->addHeader("Cache-Control", "post-check=0, pre-check=0", false );  // don't replace apache header
$response->addHeader("Pragma", "no-cache");

$response->setBody($pageController->getResult());
$sessionStatus->persistSessionStatus($request, $response);
$response->send();

