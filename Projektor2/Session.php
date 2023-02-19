<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Session
 *
 * @author Petr
 */
class Projektor2_Session {
    
    // instance of the class - singletor
    private static $instance;
    
    /**
     * private constructor
     */
    private function __construct() {}
    
    /**
     * (Re)starts the session.
     * @param array $options Otion for internal session_start() PHP function.
     * @return bool TRUE if the session has been initialized, else FALSE.
     */
    public function startSession(array $options = []): bool
    {
        if ( $this->sessionState ){
            $this->sessionState = session_start($options);
        }
        return $this->sessionState;
    }
   /**
    *    Returns THE instance of 'Session'.
    *    The session is automatically initialized if it wasn't.
    *    
    *    @return    object
    */
    
    public static function getInstance()
    {
        if ( !isset(self::$instance)){
            self::$instance = new self;
        }
        self::$instance->startSession();
        return self::$instance;
    }
    
   /**
    *    Destroys the current session.
    *    
    *    @return    bool    TRUE is session has been deleted, else FALSE.
    **/
    
    public function destroy()
    {
        if ( $this->sessionState){
            $this->sessionState = !session_destroy();
            unset( $_SESSION );
            return !$this->sessionState;
        }
        return FALSE;
    }
    
        public function __isset( $name ){
        return isset($_SESSION[$name]);
    }
    
    public function __unset( $name ){
        unset( $_SESSION[$name] );
    }
    
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }
    
    public function get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }
}
