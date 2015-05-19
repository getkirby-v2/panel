<?php 

class PageStore {

  static public function data() {
    return s::get('pagestore', array());
  }

  static public function id($page) {
  
    $site = site();    
    if($site->multilang()) {
      return $site->language()->code() . '-' . sha1($page->id());
    } else {
      return sha1($page->id());      
    }

  }

  static public function fetch($page) {
    return (array)a::get(static::data(), static::id($page));    
  }

  static public function keep($page) {

    $blueprint = blueprint::find($page);
    $fields    = $blueprint->fields($page);

    // trigger the validation
    $form = new Form($fields->toArray());

    // fetch the data for the form
    $data = pagedata::createByInput($page, $form->serialize());

    static::update($page, $data);

  }

  static public function update($page, $data = array()) {
    $store = static::data();
    $store[static::id($page)] = $data;
    s::set('pagestore', $store);
    return $store;
  }

  static public function discard($page) {
    $store = static::data();
    unset($store[static::id($page)]);    
    s::set('pagestore', $store);
    return $store;
  }

  static public function flush() {
    s::set('pagestore', array());
  }

}