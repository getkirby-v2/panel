<?php

class SiteModel extends Site {

  public $blueprint = null;

  public function __construct(Kirby $kirby) {

    parent::__construct($kirby);
    $this->blueprint = blueprint::find($this);

  }

  public function blueprint() {
    return $this->blueprint;
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
    return $this->blueprint->fields($this)->toArray();
  }

  public function canSortFiles() {
    return $this->blueprint->files()->sortable();
  }

  public function files() {
    return new FilesCollection($this);    
  }

  public function children() {
    return new ChildrenCollection($this);
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
    return new PageEditor($this);    
  }

  public function upload() {
    return new PageUploader($this);        
  }

  public function topbar(Topbar $topbar) {

    if($topbar->view == 'options/index') {
      $topbar->append(purl('options'), l('metatags'));
    }

    if($topbar->view == 'subpages/index') {
      $topbar->append($this->url('subpages'), l('subpages'));    
    }
   
    $topbar->html .= new Snippet('languages');
    $topbar->html .= new Snippet('searchtoggle', array(
      'search' => $this->url('search'),
      'close'  => $topbar->view == 'pages/search' ? $this->url() : false
    ));    

  }

  public function users() {
    return new UsersCollection();
  }

  public function user($username = null) {
    if(is_null($username)) return UserModel::current();
    try {
      return new UserModel($username);
    } catch(Exception $e) {
      return null;
    }
  }

  public function delete($force = false) {
    throw new Exception('The site cannot be deleted');
  }

}