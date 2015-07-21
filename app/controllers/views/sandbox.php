<?php

class SandboxController extends Controller {

  public function index() {

    dump(s::get());

    $store = new StructureStore('contact', 'emails');

    $first = $store->data()->first();

    /*
    $store->update($first->id(), array(
      'name'  => 'Bastian Allgeier',
      'email' => 'mail@bastian-allgeier.de',
    ));

    $store->add(array(
      'name' => 'Peter Lustig',
      'email' => 'mail@supercool.de'
    ));

    $store->delete();
  
    */

    var_dump($store->toArray());


    //$store->delete()->delete();

    exit();

  }

}