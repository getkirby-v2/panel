<?php

class HistoryTest extends PanelTestCase {

  public function __construct() {

    parent::__construct();

    $this->removeAccounts();
    $this->removeContent();

    $this->user    = $this->createAdmin();
    $this->history = $this->user->history();
    $this->page    = $this->site->children()->create('test', 'test');

  }

  protected function setUp() {
    s::restart();
  }

  public function testConstruct() {
    $this->assertInstanceOf('Kirby\\Panel\\Models\\User\\History', $this->history);
  }

  public function testAddWithoutLogin() {
    $this->history->add($this->page);
    $this->assertEquals(array(), $this->history->get());
  }

  public function testInvalidPage() {
    $this->user->login('test');
    $this->history->add('doesnotexist');
    $this->assertEquals(array(), $this->history->get());
  }

  public function testAdd() {
    $this->user->login('test');
    $this->history->add($this->page);
    $this->assertEquals(array('test'), $this->history->get());
  }

}