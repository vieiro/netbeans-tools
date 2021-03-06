<?php

namespace Synergy\Model\Exception;

use Exception;

/**
 * Description of TribeAssignmentException
 *
 * @author vriha
 */
class AssignmentException extends Exception {

    public $title;
    public $message;
    public $location;

    public function __construct($title, $message, $location) {
        // parent::__construct($message, $code, $previous); PHP >= 5.3 
        parent::__construct($message, -1);
        $this->title = $title;
        $this->message = $message;
        $this->location = $location;
    }

}
