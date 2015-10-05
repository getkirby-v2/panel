<?php

class SiteModelTest extends PanelTestCase {

  protected function setUp() {

    parent::setUp();

    $this->user = $this->createAdmin();
    $this->user->login('test');

  }

  public function testBlueprint() {
    $this->assertInstanceOf('Kirby\\Panel\\Models\\Page\\Blueprint', $this->site->blueprint());
  }

  public function testUrl() {

    $this->assertEquals('/', $this->site->url());
    $this->assertEquals('/panel/options', $this->site->url('edit'));

  }

  public function testChanges() {
    $this->assertInstanceOf('Kirby\\Panel\\Models\\Page\\Changes', $this->site->changes());
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