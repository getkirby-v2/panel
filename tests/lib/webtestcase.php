<?php 

class PanelWebTestCase extends PHPUnit_Extensions_Selenium2TestCase {

  protected $panelURL = 'http://sandbox.getkirby.com/panel';

  public function __construct() {

    parent::__construct();

    $roots = array();
    $roots['index']   = dirname(dirname(dirname(__DIR__)));
    $roots['content'] = $roots['index'] . DS . 'content';
    $roots['site']    = $roots['index'] . DS . 'site';
    $roots['kirby']   = $roots['index'] . DS . 'kirby';

    require_once($roots['kirby'] . DS . 'bootstrap.php');

    $this->roots = new Obj($roots);

    $this->setBrowser('firefox');
    $this->setBrowserUrl($this->panelURL);

  }

  protected function login() {

    $this->url($this->panelURL . '/login');

    $this->byName('username')->value('test');
    $this->byName('password')->value('test');

    $this->byCssSelector('.form')->submit();
     
  }

}