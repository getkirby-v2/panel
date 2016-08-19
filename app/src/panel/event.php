<?php

namespace Kirby\Panel;

use Kirby\Event as KirbyEvent;

class Event extends KirbyEvent {

  /**
   * Helper methods
   */
  public function panel() {
    return panel();
  }

}
