<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'bootstrap.php');

class SiteModelTest extends PanelTestCase {

  public function __construct() {

    parent::__construct();

    $this->removeContent();
    $this->removeAccounts();

    $this->user = $this->createAdmin();

  }

  protected function setUp() {
    $this->removeContent();
    $this->user->login('test');
  }

  protected function tearDown() {
    $this->user->logout();    
  }

  public function testBlueprint() {
    $this->assertInstanceOf('Blueprint', $this->site->blueprint());
  }

  public function testUrl() {

  }

  public function testChanges() {
    $this->assertInstanceOf('Changes', $this->site->changes());
  }

  public function testUpdate() {

    $this->site->update(array(
      'title' => 'Test Title'
    ));

    $this->assertEquals('Test Title', $this->site->title());

  }

  /**
   * @expectedException Exception
   * @expectedExceptionMessage The site cannot be deleted
   */
  public function testDelete() {
    $this->site->delete();
  }

}