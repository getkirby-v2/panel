<?php

class Controller extends Obj {

  public function redirect() {    
    go(call('purl', func_get_args()));      
  }

}