<?php 

class PageEditor {

  public $draft = false;
  public $page;
  public $blueprint;
  public $fields;
  public $changes;
  public $content;
  public $preview = false;
  public $form;

  public function __construct($id = '/') {

    $this->setPage($id);
    $this->setBlueprint();
    $this->setFields();
    $this->setChanges();
    $this->setContent();
    $this->setPreview();
    $this->setForm();

  }

  public function setPage($id) {

    $this->page = $id == '/' ? site() : page($id);

    if(!$this->page) {
      throw new Exception('The page could not be found');
    }

    if($this->page->isSite()) {
      $this->draft = false;
    } else {
      $this->draft = s::get('draft') == $this->page->uri();      
    }

  }

  public function setBlueprint() {
    $this->blueprint = blueprint::find($this->page);      
  }

  public function setFields() {
    $this->fields = $this->blueprint->fields($this->page);
  }

  public function setChanges() {
    $this->changes = PageStore::fetch($this->page);          
  }

  public function setContent() {

    if($this->draft) {
      return $this->content = array();
    }

    $this->content = $this->page->content()->toArray();

    // make sure the title is always there
    $this->content['title'] = $this->page->title();

    // add the changes to the content array
    $this->content = array_merge($this->content, $this->changes);

  }

  public function setPreview() {

    // create the preview link
    if($previewSetting = $this->blueprint->preview()) {

      switch($previewSetting) {
        case 'parent':
          $this->preview = $this->page->parent() ? $this->page->parent()->url() : $this->page->url();
          break;
        case 'first-child':
          $this->preview = $this->page->children()->first() ? $this->page->children()->first()->url() : false;
          break;
        case 'last-child':
          $this->preview = $this->page->children()->last()  ? $this->page->children()->last()->url() : false;
          break;
        default:
          $this->preview = $this->page->url();
          break;
      }

    }

  }

  public function update($form) {

    $page = $this->page();

    // validate all fields
    $form->validate();

    // fetch the data for the form
    $data = pagedata::createByInput($page, $form->serialize());

    // stop at invalid fields
    if(!$form->isValid()) {
      panel()->alert(l('pages.show.error.form'));
    }

    try {

      PageStore::discard($page);

      $page->update($data);

      // move the page if this is still a draft
      if($this->draft) {
        $page->move($data['title']);
        s::set('draft', false);
      }

      // make sure that the sorting number is correct
      if($page->isVisible()) {
        $num = api::createPageNum($page);
        if($num !== $page->num()) {
          if($num > 0) {
            $page->sort($num);
          } 
        }
      }

      // get the blueprint of the parent page to find the 
      // correct sorting mode for this page
      $parentBlueprint = blueprint::find($page->parent());

      // auto-update the uid if the sorting mode is set to zero
      if($parentBlueprint->pages()->num()->mode() == 'zero') {
        $uid = str::slug($page->title());
        $page->move($uid);
      }

      history::visit($page->id());

      kirby()->trigger('panel.page.update', $page);
      panel()->notify(l('saved'));

      if($page->isSite()) {
        go(purl('options'));
      } else {
        go(purl($page, 'show'));
      }

    } catch(Exception $e) {
      $form->alert($e->getMessage());
    }

  }

  public function setForm() {

    // create the form
    $this->form = new Form($this->fields->toArray(), $this->content);

    $this->form->centered = true;
  
    // set the keep api    
    $this->form->data('keep', purl($this->page, 'keep'));

    // remove the cancel button
    $this->form->buttons->cancel = '';

    // set the autofocus on the title field
    $this->form->fields->title->autofocus = true;

    // add the changes alert
    if(!empty($this->changes)) {
      $this->form->buttons->append('changes', $this->changesAlert());      
    }

    // set the form action
    $this->form->on('submit', function($form) {
      $this->update($form);
    });

    // check for untranslatable fields
    if(site()->language() != site()->defaultLanguage()) {

      foreach($this->form->fields() as $field) {
        if($field->translate() == false) {
          $field->readonly = true;
          $field->disabled = true;
        }
      }

    }

    return $this->form;

  }

  public function page() {
    return $this->page;
  }

  public function preview() {
    return $this->preview;
  }

  public function changes() {
    return $this->changes;
  }

  public function form() {
    return $this->form;
  }

  public function deletable() {
    return (!$this->page->hasChildren() and $this->page->isDeletable() and $this->blueprint->deletable());
  }

  public function noTitle() {
    return !$this->form->fields()->get('title');
  }

  public function subpages() {

    if($this->blueprint->pages()->max() === 0 or $this->blueprint->pages()->hide() === true) {
      return null;
    }

    // fetch all subpages in the right order
    $children = api::subpages($this->page->children(), $this->blueprint);

    // add pagination to the subpages
    if($limit = $this->blueprint->pages()->limit()) {
      $sessionId  = 'pagination.' . $this->page->cacheId();
      $pageNumber = get('page', s::get($sessionId, 1));
      $children   = $children->paginate($limit, array('page' => $pageNumber));
      s::set($sessionId, $pageNumber);
    }

    // create the snippet and fill it with all data
    return new Snippet('pages/sidebar/subpages', array(
      'title'      => l('pages.show.subpages.title'),
      'page'       => $this->page,
      'subpages'   => $children,
      'templates'  => $this->blueprint->pages()->template(),
      'addbutton'  => !api::maxPages($this->page, $this->blueprint->pages()->max()),
      'pagination' => $children->pagination(),
    ));

  }

  public function files() {

    if($this->blueprint->files()->max() === 0 or $this->blueprint->files()->hide() === true) {
      return null;
    }

    return new Snippet('pages/sidebar/files', array(
      'page'  => $this->page,
      'files' => api::files($this->page, $this->blueprint),
    ));

  }

  public function sidebar() {

    // create the monster sidebar
    return new Snippet('pages/sidebar', array(
      'page'      => $this->page(),
      'preview'   => $this->preview(),
      'deletable' => $this->deletable(),
      'subpages'  => $this->subpages(),
      'files'     => $this->files(),
    ));

  }

  public function changesAlert() {

    // display unsaved changes
    $changes = new Brick('div');
    $changes->addClass('text marginalia');
    $changes->attr('style', 'margin-top: 1.5rem');
    $changes->append(l('pages.show.changes.text') . '<br>');
    $changes->append('<a href="' . purl($this->page, 'discard') . '">' . l('pages.show.changes.button') . '</a>');

    return $changes;

  }

  public function breadcrumb() {
    return new Snippet('pages/breadcrumb', array('page' => $this->page));      
  }

  public function topbar() {

    return new Snippet('pages/topbar', array(
      'breadcrumb' => $this->breadcrumb(),
      'search'     => purl($this->page, 'search')
    ));

  }

  public function content() {

    $form = $this->form();

    return view('pages/show', array(
      'sidebar' => $this->sidebar(),
      'form'    => $form,
      'changes' => $this->changes(),
      'page'    => $this->page(),
      'notitle' => $this->noTitle(),
      'draft'   => $this->draft,
    ));

  }

}