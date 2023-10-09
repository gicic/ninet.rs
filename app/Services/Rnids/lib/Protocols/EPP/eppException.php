<?php
namespace EppRegistrar\EPP;

class eppException extends \Exception {
    private $reason;
    private $id;
    public $code;

    public function __construct($message = "", $code = 0, \Exception $previous = null, $reason = null, $id = null) {
        $this->reason = $reason;
        $this->id = $id;
        $this->code = $code;
        parent::__construct($message, $code, $previous);
    }

    public function getId() {
        return $this->id;
    }


    public function getReason() {
        return $this->reason;
    }
    
    public function getResponseCode() {
        return $this->code;
    }
}

