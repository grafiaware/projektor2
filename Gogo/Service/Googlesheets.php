<?php
namespace Gogo\Service;

use Google\Client;
use Google\Service\Sheets;
use Pes\Debug\Table;

use UnexpectedValueException;

/**
 * Description of Googlesheet
 *
 *         // credentials.json is the key file we downloaded while setting up our Google Sheets API
 *         $path = 'credentials.json';
 *
 *
 * @author pes2704
 */
class Googlesheets {

    private $credentialsJsonFilename;

    /**
     *
     * @var Sheets
     */
    private $sheetsService;

    /**
     *
     * @param type $credentialsJsonFilename credentials.json is the key file we downloaded while setting up our Google Sheets API
     * @throws UnexpectedValueException Soubor '$credentialsJsonFilename' neexistuje nebo není čitelný.
     */
    public function __construct($credentialsJsonFilename) {
        if(!is_readable($credentialsJsonFilename)) {
            throw new UnexpectedValueException("Soubor '$credentialsJsonFilename' neexistuje nebo není čitelný.");
        }
        $this->credentialsJsonFilename = $credentialsJsonFilename;
        $this->sheetsService = $this->createGoogleSheetsService();
    }

    /**
     *
     * @return Sheets
     */
    private function createGoogleSheetsService() {

        // configure the Google Client
        $client = new Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig($this->credentialsJsonFilename);

        // configure the Sheets Service
        return new Sheets($client);
    }

    /**
     *
     * @return Sheets
     */
    public function getSheets(): Sheets {
        return $this->sheetsService;
    }

}
