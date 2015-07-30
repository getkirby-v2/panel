<?php

class PageModel {

  public $source;
  public $blueprint;

  public function __construct($id) {

    if(is_a($id, 'Page')) {
      $this->source = $id;
    } else if(empty($id) or $id == '/') {
      $this->source = site();
    } else if(is_string($id)) {
      $this->source = page($id);      
    } else {
      throw new Exception('Invalid page model source');
    }

    if(!$this->source) {
      throw new Exception('The page could not be found: ' . $id);
    }

    $this->blueprint = blueprint::find($this->source);

  }

  public function source() {
    return $this->source;
  }

  public function parent() {
    return new PageModel($this->source->parent());
  }

  public function blueprint() {
    return $this->blueprint;
  }

  public function createNum($to = null) {

    $parent  = $this->parent();
    $visible = $parent->children()->visible();
    $params  = $parent->blueprint()->pages()->num();

    if($to == 'last') {
      $to = $visible->count() + 1;
    } else if(is_null($to)) {
      $to = $this->source->num();
    }

    switch($params->mode()) {
      case 'zero':
        return 0;
        break;
      case 'date':
        if($to = $this->source->date($params->format(), $params->field())) {
          return $to;
        } else {
          return date($params->format());
        }
        break;
      default:

        if(!v::num($to)) return false;

        if($to <= 0) return 1;

        if($this->source->isInvisible()) {
          $limit = $visible->count() + 1;
        } else {
          $limit = $visible->count();
        }

        if($limit < $to) {
          $to = $limit;
        }

        return intval($to);
        break;
    }    

  }

  public function url($action = 'edit') {

    if(empty($action)) $action = 'edit';

    if($this->source->isSite()) {
      if($action == 'edit') {
        return panel()->urls()->index() . '/options';
      } else {    
        return panel()->urls()->index() . '/site/' . $action;
      }
    } else {
      return panel()->urls()->index() . '/pages/' . $this->source->id() .  '/' . $action;      
    }

  }

  public function previewUrl() {
    // create the preview link
    if($previewSetting = $this->blueprint->preview()) {
      switch($previewSetting) {
        case 'parent':
          return $this->source->parent() ? $this->source->parent()->url() : $this->source->url();
          break;
        case 'first-child':
          return $this->source->children()->first() ? $this->source->children()->first()->url() : false;
          break;
        case 'last-child':
          return $this->source->children()->last()  ? $this->source->children()->last()->url() : false;
          break;
        default:
          return $this->source->url();
          break;
      }
    } else {
      return false;
    }
  }

  public function form($action, $callback) {    
    return panel()->form('pages/' . $action, $this, $callback);
  }

  public function getFormData() {

    if($this->isDraft()) {
      return array();
    }

    // get the latest content from the text file
    $data = $this->source->content()->toArray();

    // make sure the title is always there
    $data['title'] = $this->source->title();

    // add the changes to the content array
    $data = array_merge($data, $this->getChanges());

    return $data;

  }

  public function getFormFields() {
    return $this->blueprint->fields($this->source)->toArray();
  }

  public function breadcrumb() {
    return $this->source->parents()->flip()->map(function($page) {
      return new static($page);
    });
  }

  public function subpages($type = null) {

    $pages     = $this->children();
    $blueprint = $this->blueprint();
    $sort      = $blueprint->pages()->sort();

    if($type) {
      $pages = $pages->$type();
    }

    switch($sort) {
      case 'flip':
        $pages = $pages->flip();
        break;
      default;
        $parts = str::split($sort, ' ');
        if(count($parts) > 0) {
          $pages = call(array($pages, 'sortBy'), $parts);
        }
        break;
    }

    // convert all files to file models
    return $pages->map(function($page) {
      return new PageModel($page);
    });

  }

  public function canSortFiles() {
    return $this->blueprint->files()->sortable();
  }

  public function file($filename) {
    return new FileModel($this, $filename);
  }

  public function files() {

    $page  = $this;
    $files = $this->source->files();

    if($this->canSortFiles()) {
      $files = $files->sortBy('sort', 'asc');
    } 

    if($this->blueprint->files()->sort() == 'flip') {
      $files = $files->flip();
    }

    // convert all files to file models
    return $files->map(function($file) use($page) {
      return new FileModel($page, $file);
    });

  }

  public function addButton() {

    if($this->canHaveMoreSubpages()) {
      $button = new Obj;
      if($this->blueprint()->pages()->template()->count() > 1) {
        $button->url   = $this->url('add');
        $button->modal = true;
      } else {
        $button->url   = $this->url('add/' . $this->blueprint()->pages()->template()->first()->name());
        $button->modal = false;
      }
      return $button;
    } else {
      return false;
    }

  }

  public function menu($position = 'sidebar') {
    return new PageMenu($this, $position);
  }

  public function createSubpage($template, $uid = null, $title = null) {

    if(empty($template)) {
      throw new Exception(l('pages.add.error.template'));
    }

    $uid       = empty($uid) ? str::random(32) : $uid;
    $blueprint = blueprint::find($template);
    $data      = array();

    foreach($blueprint->fields() as $key => $field) {
      $data[$key] = $field->default();        
    }

    // make sure to fill the title field properly
    if(!empty($title)) {
      $data['title'] = $title;
    } else if(empty($data['title'])) {
      $data['title'] = '(' . l('untitled') . ')';
    }

    // create the new page and convert it to a page model
    $page = new PageModel($this->source->children()->create($uid, $template, $data));

    // subpage builder
    foreach((array)$page->blueprint()->pages()->build() as $build) {
      $missing = a::missing($build, array('title', 'template', 'uid'));
      if(!empty($missing)) continue;
      $page->createSubpage($build['template'], $build['uid'], $build['title']);
    }

    s::set('draft', $page->id());

    return $page;

  }

  public function filterInput($input) {

    $data = array();

    foreach($this->source->content()->toArray() as $key => $value) {
      if(strtolower($key) == 'url_key') {
        // don't erase the url key
        continue;
      } else {
        $data[$key] = null;  
      }      
    }

    return array_merge($data, $input);

  }

  public function getChanges() {
    return PageStore::fetch($this->source);
  }

  public function keepChanges() {
    return PageStore::keep($this->source);
  }

  public function updateChanges($changes) {
    PageStore::update($this->source, $changes);    
  }

  public function discardChanges() {
    return PageStore::discard($this->source);
  }

  public function maxSubpages() {
    $max = $this->blueprint->pages()->max();
    // if max subpages is null, use the biggest 32bit integer
    // will never be reached anyway. Kirby is not made for that scale :)
    return is_null($max) ? 2147483647 : $max;
  }

  public function maxFiles() {
    $max = $this->blueprint->files()->max();
    // see: maxSubpages
    return is_null($max) ? 2147483647 : $max;    
  }

  public function canHaveSubpages() {
    return $this->maxSubpages() !== 0;
  }

  public function canShowSubpages() {
    return ($this->source->pages()->hide() !== true and $this->canHaveSubpages());    
  }

  public function canHaveFiles() {
    return $this->maxFiles() !== 0;
  }

  public function canShowFiles() {
    return ($this->source->files()->hide() !== true and $this->canHaveFiles());    
  }

  public function canHaveMoreSubpages() {
    if(!$this->canHaveSubpages()) {
      return false;
    } else if($this->source->children()->count() >= $this->maxSubpages()) {
      return false;
    } else {
      return true;
    }
  }

  public function canHaveMoreFiles() {
    if(!$this->canHaveFiles()) {
      return false;
    } else if($this->source->files()->count() >= $this->maxFiles()) {
      return false;
    } else {
      return true;
    }    
  }

  public function canChangeUrl() {
    if($this->isHomePage() or $this->isErrorPage()) {
      return false;
    } else {
      return true;
    }
  }

  public function changeUrl($uid) {

    $changes = $this->getChanges();

    $this->discardChanges();

    if(site()->multilang() and site()->language()->code() != site()->defaultLanguage()->code()) {
      $this->source->update(array(
        'URL-Key' => $uid
      ));
    } else {
      $this->source->move($uid);
    }

    $this->updateChanges($changes);

    // hit the hook
    kirby()->trigger('panel.page.move', $this->source);
  
  }

  public function sort($to) {

    if($this->isErrorPage()) {
      return $this->source->num();
    }

    // create a new valid sorting num
    $num = $this->createNum($to);

    // sort the page
    $this->source->sort($num);

    // clean the other page numbers
    $this->sortSiblings($num);

    // hit the hook
    kirby()->trigger('panel.page.sort', $this->source);

    return $num;

  }

  public function hide() {
    $this->source->hide();
    $this->sortSiblings();
    kirby()->trigger('panel.page.hide', $this->source);
  }

  public function toggle($position) {

    if($this->source->isVisible()) {
      $this->hide();
    } else {
      $this->sort($position);          
    }

  }

  public function hasNoTitleField() {
    $fields = $this->getFormFields();
    return empty($fields['title']);
  }

  public function isDeletable($exception = false) {

    if($this->source->isHomePage()) {
      $error = 'pages.delete.error.home';
    } else if($this->source->isErrorPage()) {
      $error = 'pages.delete.error.error';
    } else if($this->source->hasChildren()) {
      $error = 'pages.delete.error.children';
    } else if(!$this->blueprint()->deletable()) {
      $error = 'pages.delete.error.blocked';
    } else {
      return true;
    }

    if($exception) {
      throw new Exception($error);      
    } else {
      return false;
    }

  }

  public function editor() {
    return new PageEditor($this->source->id());    
  }

  public function sortSiblings($skip = null) {
    $to = 1;
    foreach($this->source->siblings()->visible()->not($this->source) as $page) {
      if($to === $skip) $to++;
      $pagemodel = new PageModel($page);
      $page->sort($pagemodel->createNum($to));
      $to++;
    }
  }

  public function isDraft() {
    if($this->source->isSite()) {
      return false;
    } else {
      return s::get('draft') == $this->source->id();      
    }
  }

  public function addToHistory() {
    history::visit($this->source->id());    
  }

  public function updateNum() {

    // make sure that the sorting number is correct
    if($this->source->isVisible()) {
      $num = $this->createNum();
      if($num !== $this->source->num()) {
        $this->sort($num);
      }
    }

    return $this->source->num();

  }

  public function updateUid() {
    // auto-update the uid if the sorting mode is set to zero
    if($this->parent()->blueprint()->pages()->num()->mode() == 'zero') {
      $uid = str::slug($this->source->title());
      $this->source->move($uid);
    }
    return $this->source->uid();
  }

  public function update($input) {

    $data = $this->filterInput($input);

    $this->discardChanges();
    $this->source->update($data);

    // move the page if this is still a draft
    if($this->isDraft()) {
      $this->source->move($data['title']);
      s::set('draft', false);
    }

    $this->updateNum();
    $this->updateUid();
    $this->addToHistory();

    kirby()->trigger('panel.page.update', $this->source);

  }

  public function upload() {
    new PageUploader($this->source);        
  }

  public function delete() {

    // delete the page
    $this->source->delete();

    // resort the siblings
    $this->sortSiblings();

    // remove unsaved changes
    $this->discardChanges();

    // hit the hook
    kirby()->trigger('panel.page.delete', $this->source);

  }

  public function icon($position = 'left') {
    return icon($this->blueprint()->icon(), $position);
  }

  public function dragText() {
    if(c::get('panel.kirbytext') === false) {
      return '[' . $this->source->title() . '](' . $this->source->url() . ')';
    } else {
      return '(link: ' . $this->source->uri() . ' text: ' . $this->source->title() . ')';
    }
  }

  public function displayNum() {

    if($this->source->isInvisible()) {
      return '—';
    } else {
      switch($this->parent()->blueprint()->pages()->num()->mode()) {
        case 'zero':
          return str::substr($this->source->title(), 0, 1);
          break;
        case 'date':
          return date('Y/m/d', strtotime($this->source->num()));
          break;
        default:
          return intval($this->source->num());
          break;
      }
    }

  }

  public function __call($method, $args = null) {
    return call(array($this->source, $method), $args);
  }

}