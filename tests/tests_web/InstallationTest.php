<?php

class InstallationTest extends PanelWebTestCase {

  protected function setUp() {
    dir::clean($this->roots->site . DS . 'accounts');
  }

  public function testInstallation() {

    $this->url($this->panelURL . '/');

    $this->assertEquals($this->panelURL . '/install', $this->url());

    $this->byName('username')->value('test');
    $this->byName('email')->value('mail@test.com');
    $this->byName('password')->value('test');

    $this->byCssSelector('.form')->submit();

    $this->assertEquals($this->panelURL . '/', $this->url());

  }

}