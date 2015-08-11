<?php

namespace Kirby\Panel\Models;

use C;
use Exception;
use Obj;
use S;
use Str;
use V;

use Kirby\Panel\Snippet;
use Kirby\Panel\Topbar;
use Kirby\Panel\Collections\Children;
use Kirby\Panel\Collections\Files;
use Kirby\Panel\Models\Page\AddButton;
use Kirby\Panel\Models\Page\Blueprint;
use Kirby\Panel\Models\Page\Menu;
use Kirby\Panel\Models\Page\Changes;
use Kirby\Panel\Models\Page\Editor;
use Kirby\Panel\Models\Page\Uploader;
use Kirby\Panel\Models\User\History;

class Page extends \Page {

  public function __construct($parent, $dirname) {
    parent::__construct($parent, $dirname);
  }

  public function blueprint() {

    if(isset($this->cache['blueprint'])) return $this->cache['blueprint'];

    $blueprint = $this->intendedTemplate();

    if(!Blueprint::exists($blueprint)) {
      $blueprint = $this->template();
    }

    return $this->cache['blueprint'] = new Blueprint($blueprint);

  }

  public function createNum($to = null) {

    $parent  = $this->parent();
    $visible = $parent->children()->visible();
    $params  = $parent->blueprint()->pages()->num();

    if($to == 'last') {
      $to = $visible->count() + 1;
    } else if($to == 'first') {
      $to = 1;
    } else if(is_null($to)) {
      $to = $this->num();
    }

    switch($params->mode()) {
      case 'zero':
        return 0;
        break;
      case 'date':
        if($to = $this->date($params->format(), $params->field())) {
          return $to;
        } else {
          return date($params->format());
        }
        break;
      default:

        if(!v::num($to)) return false;

        if($to <= 0) return 1;

        if($this->isInvisible()) {
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

  public function url($action = null) {
    if(empty($action)) {
      return parent::url();
    } else if($action == 'preview') {
      if($previewSetting = $this->blueprint()->preview()) {
        switch($previewSetting) {
          case 'parent':
            return $this->parent() ? $this->parent()->url() : $this->url();
            break;
          case 'first-child':
            return $this->children()->first() ? $this->children()->first()->url() : false;
            break;
          case 'last-child':
            return $this->children()->last()  ? $this->children()->last()->url() : false;
            break;
          default:
            return $this->url();
            break;
        }
      } else {
        return false;
      }
    } else {
      return panel()->urls()->index() . '/pages/' . $this->id() .  '/' . $action;            
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
    $data = $this->content()->toArray();

    // make sure the title is always there
    $data['title'] = $this->title();

    // add the changes to the content array
    $data = array_merge($data, $this->changes()->get());

    return $data;

  }

  public function getFormFields() {
    return $this->blueprint()->fields($this)->toArray();
  }

  public function children() {
    return new Children($this);
  }

  public function canSortFiles() {
    return $this->blueprint()->files()->sortable();
  }

  public function files() {
    return new Files($this);
  }

  public function addButton() {
    try {
      return new AddButton($this);
    } catch(Exception $e) {
      return false;
    }
  }

  public function menu($position = 'sidebar') {
    return new Menu($this, $position);
  }

  public function filterInput($input) {

    $data = array();

    foreach($this->content()->toArray() as $key => $value) {
      if(strtolower($key) == 'url_key') {
        // don't erase the url key
        continue;
      } else {
        $data[$key] = null;  
      }      
    }

    return array_merge($data, $input);

  }

  public function changes() {
    return new Changes($this);
  }

  public function maxSubpages() {
    $max = $this->blueprint()->pages()->max();
    // if max subpages is null, use the biggest 32bit integer
    // will never be reached anyway. Kirby is not made for that scale :)
    return is_null($max) ? 2147483647 : $max;
  }

  public function maxFiles() {
    $max = $this->blueprint()->files()->max();
    // see: maxSubpages
    return is_null($max) ? 2147483647 : $max;    
  }

  public function canHaveSubpages() {
    return $this->maxSubpages() !== 0;
  }

  public function canShowSubpages() {
    return ($this->pages()->hide() !== true and $this->canHaveSubpages());    
  }

  public function canHaveFiles() {
    return $this->maxFiles() !== 0;
  }

  public function canShowFiles() {
    return ($this->files()->hide() !== true and $this->canHaveFiles());    
  }

  public function canHaveMoreSubpages() {
    if(!$this->canHaveSubpages()) {
      return false;
    } else if($this->children()->count() >= $this->maxSubpages()) {
      return false;
    } else {
      return true;
    }
  }

  public function canHaveMoreFiles() {
    if(!$this->canHaveFiles()) {
      return false;
    } else if($this->files()->count() >= $this->maxFiles()) {
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

  public function move($uid) {

    if(!$this->canChangeUrl()) {
      throw new Exception('You cannot change the URL of this page');
    }

    $site    = panel()->site();
    $changes = $this->changes()->get();

    $this->changes()->discard();

    if($site->multilang() and $site->language()->code() != $site->defaultLanguage()->code()) {
      parent::update(array(
        'URL-Key' => $uid
      ));
    } else {
      parent::move($uid);
    }

    $this->changes()->update($changes);

    // hit the hook
    kirby()->trigger('panel.page.move', $this);
  
  }

  public function sort($to, $sibling = false) {

    if($this->isErrorPage()) {
      return $this->num();
    }

    // create a new valid sorting num
    $num = $this->createNum($to);

    // sort the page
    parent::sort($num);

    // clean the other page numbers
    if(!$sibling) {

      $this->sortSiblings($num);      

      // hit the hook
      kirby()->trigger('panel.page.sort', $this);

    }

    return $num;

  }

  public function hide() {
    parent::hide();
    $this->sortSiblings();
    kirby()->trigger('panel.page.hide', $this);
  }

  public function toggle($position) {
    if($this->isVisible()) {
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

    if($this->isHomePage()) {
      $error = 'pages.delete.error.home';
    } else if($this->isErrorPage()) {
      $error = 'pages.delete.error.error';
    } else if($this->hasChildren()) {
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
    return new Editor($this);    
  }

  public function sortSiblings($skip = null) {
    $to = 1;
    foreach(parent::siblings()->visible()->not($this) as $page) {
      if($to === $skip) $to++;
      $page->sort($to, true);
      $to++;
    }
  }

  public function isDraft() {
    if($this->isSite()) {
      return false;
    } else {
      return s::get('draft') == $this->id();      
    }
  }

  public function addToHistory() {
    panel()->user()->history()->add($this);
  }

  public function updateNum() {

    // make sure that the sorting number is correct
    if($this->isVisible()) {
      $num = $this->createNum();
      if($num !== $this->num()) {
        $this->sort($num);
      }
    }

    return $this->num();

  }

  public function updateUid() {

    // auto-update the uid if the sorting mode is set to zero
    if($this->parent()->blueprint()->pages()->num()->mode() == 'zero') {
      $uid = str::slug($this->title());
      $this->move($uid);
    }
    return $this->uid();

  }

  public function update($input = array()) {

    $data = $this->filterInput($input);

    $this->discardChanges();
    parent::update($data);

    // move the page if this is still a draft
    if($this->isDraft()) {
      parent::move($data['title']);
      s::set('draft', false);
    }

    $this->updateNum();
    $this->updateUid();
    $this->addToHistory();

    kirby()->trigger('panel.page.update', $this);

  }

  public function upload() {
    new Uploader($this);        
  }

  public function delete($force = false) {

    // delete the page
    parent::delete();

    // resort the siblings
    $this->sortSiblings();

    // remove unsaved changes
    $this->changes()->discard();

    // hit the hook
    kirby()->trigger('panel.page.delete', $this);

  }

  public function icon($position = 'left') {
    return icon($this->blueprint()->icon(), $position);
  }

  public function dragText() {
    if(c::get('panel.kirbytext') === false) {
      return '[' . $this->title() . '](' . $this->url() . ')';
    } else {
      return '(link: ' . $this->uri() . ' text: ' . $this->title() . ')';
    }
  }

  public function displayNum() {

    if($this->isInvisible()) {
      return '—';
    } else {
      switch($this->parent()->blueprint()->pages()->num()->mode()) {
        case 'zero':
          return str::substr($this->title(), 0, 1);
          break;
        case 'date':
          return date('Y/m/d', strtotime($this->num()));
          break;
        default:
          return intval($this->num());
          break;
      }
    }

  }

  public function topbar(Topbar $topbar) {

    foreach($this->parents() as $item) {
      $topbar->append($item->url('edit'), $item->title());
    }

    $topbar->append($this->url('edit'), $this->title());

    if($topbar->view == 'subpages/index') {
      $topbar->append($this->url('subpages'), l('subpages'));    
    }
   
    $topbar->html .= new Snippet('languages');
    $topbar->html .= new Snippet('searchtoggle', array(
      'search' => $this->url('search'),
      'close'  => $topbar->view == 'pages/search' ? $this->url() : false
    ));    

  }

}