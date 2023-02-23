<?php
/**
 * Kontejner na globalni promenne
 * @author Petr Svoboda
 */

abstract class Config_Ukonceni
{

############# UKONČENÍ PROJEKTU #############
    /**
     * Vrací pole pro formulář ukončení projektu
     * @param string $kod
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getUkonceniProjektu($kod) {
        switch ($kod) {
        ######## AP #################
            case 'AP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>TRUE
                    );
                break;
        ######## HELP #################
            case 'HELP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SJZP #################
            case 'SJZP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## VZP #################
            case 'VZP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SJZP PK KK #################
            case 'SJPK':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## ZPM #################
            case 'ZPM':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SPP #################
            case 'SPP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## RP #################
            case 'RP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SJPO #################
            case 'SJPO':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SJLP #################
            case 'SJLP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## VDTP #################
            case 'VDTP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## PDU #################
            case 'PDU':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## MB #################
            case 'MB':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
            case 'CJC':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## CKP PKP #################
            case 'CKP':
            case 'PKP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování programu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení programu ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v programu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování vzdělávacího programu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
            default:
                throw new UnexpectedValueException('Není definováno pole s hodnotami pro ukončení projektu '.$kod);
        }
    }
}