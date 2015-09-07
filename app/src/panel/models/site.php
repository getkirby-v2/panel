<?php

namespace Kirby\Panel\Models;

use Exception;
use Kirby;
use Kirby\Panel\Snippet;
use Kirby\Panel\Topbar;
use Kirby\Panel\Collections\Files;
use Kirby\Panel\Collections\Children;
use Kirby\Panel\Collections\Users;
use Kirby\Panel\Models\Page\AddButton;
use Kirby\Panel\Models\Page\Blueprint;
use Kirby\Panel\Models\Page\Changes;
use Kirby\Panel\Models\Page\Editor;
use Kirby\Panel\Models\Page\Uploader;

class Site extends \Site {

  public function __construct(Kirby $kirby) {
    parent::__construct($kirby);
  }

  public function blueprint() {
    if(isset($this->cache['blueprint'])) return $this->cache['blueprint'];
    return $this->cache['blueprint'] = new Blueprint('site');
  }

  public function changes() {
    return new Changes($this);
  }

  public function url($action = null) {

    if(empty($action)) {
      return parent::url();
    }

    if($action == 'edit') {
      return panel()->urls()->index() . '/options';
    } else if($action == 'preview') {
      return $this->url();
    } else {    
      return panel()->urls()->index() . '/site/' . $action;
    }

  }

  public function form($action, $callback) {    
    return panel()->form('pages/' . $action, $this, $callback);
  }

  public function getFormData() {

    // get the latest content from the text file
    $data = $this->content()->toArray();

    // make sure the title is always there
    $data['title'] = $this->title();

    return $data;

  }

  public function getFormFields() {
    return $this->blueprint()->fields($this)->toArray();
  }

  public function canSortFiles() {
    return $this->blueprint()->files()->sortable();
  }

  public function files() {
    return new Files($this);    
  }

  public function children() {
    return new Children($this);
  }

  public function filterInput($input) {
    $data = array();
    foreach($this->content()->toArray() as $key => $value) {
      $data[$key] = null;  
    }
    return array_merge($data, $input);
  }

  public function update($input = array()) {

    $data = $this->filterInput($input);

    $this->changes()->discard();

    parent::update($data);

    kirby()->trigger('panel.site.update', $this);

  }

  public function editor() {
    return new Editor($this);    
  }

  public function upload() {
    return new Uploader($this);        
  }

  public function addButton() {
    try {
      return new AddButton($this);
    } catch(Exception $e) {
      return false;
    }
  }

  public function topbar(Topbar $topbar) {

    if($topbar->view == 'options/index') {
      $topbar->append(purl('options'), l('metatags'));
    }

    if($topbar->view == 'subpages/index') {
      $topbar->append($this->url('subpages'), l('subpages'));    
    }
   
    $topbar->html .= new Snippet('languages');

  }

  public function users() {
    return new Users();
  }

  public function user($username = null) {
    if(is_null($username)) return User::current();
    try {
      return new User($username);
    } catch(Exception $e) {
      return null;
    }
  }

  public function delete($force = false) {
    throw new Exception('The site cannot be deleted');
  }

}