<?php

class UsersTest extends PanelWebTestCase {

  public function testIndex() {

    return true;

    $this->login();
    $this->url($this->panelURL . '/users');

    $this->assertEquals($this->panelURL . '/users', $this->url());

    $elements = $this->elements($this->using('css selector')->value('.users .item'));    
    $this->assertEquals(1, count($elements));

  }

  public function testCreate() {

    $this->login();
    $this->url($this->panelURL . '/users/add');
    $this->assertEquals($this->panelURL . '/users/add', $this->url());

    $this->byName('username')->value('editor');
    $this->byName('firstname')->value('Ed');
    $this->byName('lastname')->value('Itor');
    $this->byName('email')->value('editor@getkirby.com');
    $this->byName('password')->value('test');
    $this->byName('passwordconfirmation')->value('test');
    $this->byName('role')->value('editor');

    $this->byCssSelector('.main .form')->submit();

    $this->waitUntil(function () {
      if($this->url() == $this->panelURL . '/users') {
        return true;
      } else {
        return null;        
      }
    }, 5000);

    $elements = $this->elements($this->using('css selector')->value('.users .item'));    
    $this->assertEquals(2, count($elements));

  }

  public function testUpdate() {

    $this->login();
    $this->url($this->panelURL . '/users/editor/edit');
    $this->assertEquals($this->panelURL . '/users/editor/edit', $this->url());

    $firstname = $this->byName('firstname');
    $firstname->clear();
    $firstname->value('Edward');

    $this->byCssSelector('.main .form')->submit();

  }

  public function testDeleteLastAdmin() {

    $this->login();

    $this->url($this->panelURL . '/users/test/delete');
    $this->byCssSelector('.modal-content .form')->submit();        

    $this->assertEquals($this->panelURL . '/users/test/delete', $this->url());

    $this->url($this->panelURL . '/users');

    $elements = $this->elements($this->using('css selector')->value('.users .item'));    
    $this->assertEquals(2, count($elements));

  }

  public function testDelete() {

    $this->login();
    $this->url($this->panelURL . '/users/editor/edit');
    $this->assertEquals($this->panelURL . '/users/editor/edit', $this->url());

    $this->byCssSelector('[data-shortcut="#"]')->click();

    $this->waitUntil(function () {
      if($this->byCssSelector('.modal-content .form')) {
        return true;
      } else {
        return null;        
      }
    }, 5000);

    $this->byCssSelector('.modal-content .form')->submit();    

    $this->waitUntil(function () {
      if($this->url() == $this->panelURL . '/users') {
        return true;
      } else {
        return null;        
      }
    }, 5000);

    $elements = $this->elements($this->using('css selector')->value('.users .item'));    
    $this->assertEquals(1, count($elements));

  }

}