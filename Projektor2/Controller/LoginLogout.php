<?php
/**
 * Description of Projektor2_Controller_Login
 *
 * @author pes2704
 */
class Projektor2_Controller_LoginLogout extends Projektor2_Controller_Abstract {

    const LOGIN_NAME_FIELD = 'projektor_name';
    const LOGIN_PASSWORD_FIELD = 'projektor_password';

    private $warning;

    /**
     *
     * @return boolean True pokud je uýivatel přihlášen
     */
    private function performLoginPostActions() {
        if ($this->request->isPost()) {
            if ($this->request->get('akce') == 'login') {
                $name = $this->request->post(self::LOGIN_NAME_FIELD);
                $password = $this->request->post(self::LOGIN_PASSWORD_FIELD);
                $userid = Projektor2_Auth_Authentication::check_credentials($name,$password);
                if($userid){
                    $user = Projektor2_Model_Db_SysUserMapper::get($userid);
                    // nový user status
                    $this->sessionStatus->setUserStatus(new Projektor2_Model_UserStatus($user));
                    if($this->request->post('id_projekt')) {
                        switch ($this->request->post('id_projekt')) {
                            case 'ß':
                                break;
        //                    case '*':
        //                            $p = TRUE;
        //                        break;
                            default:
                                if(is_numeric($this->request->post('id_projekt'))) {
                                    $projekt = Projektor2_Model_Db_ProjektMapper::findById($this->request->post('id_projekt'));
                                    if ($projekt) {
                                        $this->sessionStatus->getUserStatus()->setProjekt($projekt);
                                        $loggedIn = TRUE;
                                    }
                                }
                                break;
                        }
                        if (!isset($loggedIn) OR $loggedIn!=TRUE) {
                            $this->warning = "Prosím vyberte projekt ke kterému se chcete přihlásit a přihlašte se znovu !";
                            $this->sessionStatus->getUserStatus()->setProjekt();
                        }
                    }
                } else {
                    $this->warning = "Přihlášení se nezdařilo.";
                }
            }
        }
        return (isset($loggedIn) AND $loggedIn) ? TRUE : FALSE;
    }

    /**
     *
     * @param Projektor2_Auth_Cookie $authCookie
     * @return type TRUE pokud došlo k odhlášení uživatele
     */
    private function performLogoutPostActions() {
        if ($this->request->isPost()) {
            if ($this->request->get('akce') == 'logout') {
                // smazání user status
                $this->sessionStatus->setUserStatus(null);
                $loggedOut = TRUE;
            }
            return (isset($loggedOut) AND $loggedOut) ? TRUE : FALSE;
        }
    }

    public function getResult() {
        if ($this->sessionStatus->getUserStatus()) {  //uživatel přihlášen
            $loggedOut = $this->performLogoutPostActions();  // POST request na logout
            if ($loggedOut) {
                $parts[] = $this->createLoginView();
            } else {
                // je přihlášen a neodhlásil se
                $parts[] = $this->createLogoutView();
                if ($this->sessionStatus->getUserStatus()->getProjekt()) {
                    $performContinue = TRUE;
                } else {
                    $performContinue = FALSE;
                }
            }
        } else {
            $loggedIn = $this->performLoginPostActions(); // POST request na login a byl úspěšný
            if ($loggedIn) {
                $parts[] = $this->createLogoutView();
                $performContinue = TRUE;
            } else {
                $parts[] = $this->createLoginView();
            }
        }
        // podmínka pro pokračování
        if (isset($performContinue) AND $performContinue===TRUE) {
            $layoutController = new Projektor2_Controller_Layout($this->sessionStatus, $this->request, $this->response);
            $parts[] = $layoutController->getResult();
        }
        $view = new Projektor2_View_HTML_Element_Div($this->sessionStatus, array('htmlParts'=>$parts));
        return $view;
    }

    private function createLoginView() {
        $projekty = Projektor2_Model_Db_ProjektMapper::findAll();

        return new Projektor2_View_HTML_Login($this->sessionStatus,
                        array('projekty'=>$projekty,
//                            'id_projekt'=>isset($this->sessionStatus->getUserStatus()->getProjekt()->id) ? $this->sessionStatus->getUserStatus()->getProjekt()->id : NULL,
                            'warning'=>$this->warning)
                        );
    }

    private function createLogoutView() {
        $connectionInfoController = new Projektor2_Controller_ConnectionInfo($this->sessionStatus, $this->request, $this->response);
        $context['contextControllerResult'] = $connectionInfoController->getResult();
        return new Projektor2_View_HTML_Logout($this->sessionStatus, $context);
    }
}
