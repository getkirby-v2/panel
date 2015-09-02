<?php

class AuthTest extends PanelWebTestCase {

  public function testLoginAndLogout() {

    $this->url($this->panelURL);

    $this->assertEquals($this->panelURL . '/login', $this->url());
    $this->assertEquals('Kirby Starterkit | Panel', $this->title());

    $this->login();

    $this->assertEquals($this->panelURL . '/', $this->url());

    $this->url($this->panelURL . '/logout');
    $this->assertEquals($this->panelURL . '/login', $this->url());

  }  

}