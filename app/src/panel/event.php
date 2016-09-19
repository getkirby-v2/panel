<?php

namespace Kirby\Panel;

use ReflectionClass;
use Error;
use Exception;
use Str;
use Kirby\Event as KirbyEvent;

class Event extends KirbyEvent {

  public $panel;
  public $language;
  public $state;

  public function __construct($type, $target = [], $state = null) {

    // if the event type contains a state
    if(str::contains($type, ':')) {
      list($type, $state) = str::split($type, ':');
    }

    parent::__construct($type, $target);

    $this->panel       = panel();
    $this->site        = $this->panel->site();
    $this->user        = $this->site->user();
    $this->language    = $this->site->language();
    $this->translation = $this->panel->translation();
    $this->state       = $state;

  }

  public function panel() {
    return $this->panel;
  }

  public function language() {
    return $this->language;
  }

  public function translation() {
    return $this->translation;
  }

  public function state($state = null) {
    if($state !== null) {
      $this->state = $state;
      return $this;
    } else {
      return $this->state;      
    }
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

}