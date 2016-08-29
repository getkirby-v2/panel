<?php

namespace Kirby\Panel;

use Error;
use Kirby\Event as KirbyEvent;

class Event extends KirbyEvent {

  /**
   * Checks if the current user has permission for the event
   *
   * @param mixed $args Additional arguments for the permission callbacks
   * @param boolean $throw If true, throws if user has no permission
   * @return boolean
   */
  public function checkPermissions($args = [], $throw = false) {
    $user = $this->user();
    if(!$user) throw new Error('No user is logged in, cannot check permissions.');
    $result = $user->permission($this, $args);

    // set default error message if no custom one is set
    $message = $result->message();
    if(!$message) $message = l('permissions.error');

    if($throw && !$result->status()) throw new Error($message);
    return $result->status();
  }

  /**
   * Helper methods
   */
  public function panel() {
    return panel();
  }

}
