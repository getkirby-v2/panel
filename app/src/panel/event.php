<?php

namespace Kirby\Panel;

use ReflectionClass;
use Error;
use Exception;
use Kirby\Event as KirbyEvent;

class Event extends KirbyEvent {

  public function __construct($type, $data = []) {
    $this->panel    = panel();
    $this->site     = $this->panel->site();
    $this->language = $this->site->language();
    parent::__construct($type, $data);
  }

  /**
   * Checks if the current user has permission for the event
   */
  public function check() {

    $user = $this->user();

    if(!$user) {
      throw new Error('No user is logged in, cannot check permissions.');
    }

    $result = $user->permission($this);

    // set default error message if no custom one is set
    $message = $result->message();

    if(!$message) {
      $message = l('permissions.error');
    }

    if(!$result->status()) {
      throw new Error($message);
    }
    
    return true;

  }

  /**
   * Checks if an event is allowed
   * 
   * @return boolean
   */
  public function isAllowed() {
    try {
      $this->check();
      return true;
    } catch(Exception $e) {
      return false;
    }
  }

  /**
   * Checks if an event is denied
   * 
   * @return boolean
   */
  public function isDenied() {
    return !$this->isAllowed();
  }

  /**
   * Helper methods
   */
  public function panel() {
    return panel();
  }

}