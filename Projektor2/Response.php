<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Response
 *
 * @author pes2704
 */
class Projektor2_Response {

    protected $cookies = array();
    protected $headers = array();
    protected $status;
    protected $body;

    public function addHeader($name, $value, $replace=true) {
        $this->headers[] = ['name'=>$name, 'value'=> $value, 'replace'=> $replace];
    }

    public function setStatus($status) {
        $this->status;
    }

    public function setCookie($name, $value=NULL, $expire=0, $path=NULL, $domain=NULL, $secure=FALSE, $httponly=FALSE) {
        $this->cookies[$name] = new Projektor2_Cookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    public function setBody($text) {
        $this->body = $text;
    }

    public function appendToBody($text) {
        $this->body .= $text;
    }

    public function send() {
        if (isset($this->status)) {
            header($this->status);
        }
        foreach ($this->headers as $header) {
            header($header['name'].": ".$header['value'], $header['replace'] ? true : false);
        }
        foreach ($this->cookies as $cookie) {
            setcookie($cookie->name, $cookie->value, $cookie->expire, $cookie->path, $cookie->domain, $cookie->secure, $cookie->httponly);
        }
        echo $this->body;
    }
}

?>
