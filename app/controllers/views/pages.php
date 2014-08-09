<?php

class PagesController extends Controller {

  public function show($id) {

    $page      = $this->page($id);
    $blueprint = blueprint::find($page);
    $fields    = $blueprint->fields();
    $content   = $page->content()->toArray();
    $subpages  = api::subpages($page->children(), $blueprint);
    $files     = api::files($page, $blueprint);

    if($previewSetting = $blueprint->preview()) {

      switch($previewSetting) {
        case 'parent':
          $preview = $page->parent() ? $page->parent()->url() : $page->url();
          break;
        case 'first-child':
          $preview = $page->children()->first() ? $page->children()->first()->url() : false;
          break;
        case 'last-child':
          $preview = $page->children()->last()  ? $page->children()->last()->url() : false;
          break;
        default:
          $preview = $page->url();
          break;
      }

    } else {
      $preview = false;
    }

    foreach($fields as $field) {
      $field->page = $page;
    }

    if($limit = $blueprint->pages()->limit()) {
      $subpages = $subpages->paginate($limit, array('page' => get('page')));
    }

    // make sure the title is always there
    $content['title'] = $page->title();

    // create the form
    $form = new Form($fields->toArray(), $content);

    // check for untranslatable fields
    if(site()->language() != site()->defaultLanguage()) {

      foreach($form->fields() as $field) {
        if($field->translate() == false) {
          $field->readonly = true;
          $field->disabled = true;
        }
      }

    }


    return view('pages/show', array(
      'topbar' => new Snippet('pages/topbar', array(
        'menu'       => new Snippet('menu'),
        'breadcrumb' => new Snippet('pages/breadcrumb', array('page' => $page)),
        'search'     => purl($page, 'search')
      )),
      'sidebar' => new Snippet('pages/sidebar', array(
        'page'       => $page,
        'files'      => $files,
        'blueprint'  => $blueprint,
        'subpages'   => $subpages,
        'preview'    => $preview,
        'pagination' => $subpages->pagination(),
        'deletable'  => !$page->hasChildren() and $page->isDeletable() and $blueprint->deletable()
      )),
      'form' => $form,
      'page' => $page
    ));

  }

  public function add($id = '/') {

    $page      = $this->page($id);
    $blueprint = blueprint::find($page);
    $templates = $blueprint->pages()->template();
    $options   = array();
    $back      = array(
      'subpages' => purl('subpages/index/' . $page->id()),
      'page'     => purl($page, 'show')
    );

    $form = app::form('pages.add');
    $form->save = l('add');
    $form->back = a::get($back, get('to'));

    foreach($templates as $template) {
      $options[$template->name()] = $template->title();
    }

    $select = form::field('select', array(
      'name'     => 'template',
      'label'    => l('pages.add.template.label'),
      'options'  => $options,
      'required' => true
    ));

    if($templates->count() == 1) {
      $select->readonly = true;
      $select->value    = $templates->first()->name();
    }

    $form->fields()->append('template', $select);

    return view('pages/add', array(
      'page' => $page,
      'form' => $form
    ));

  }

  public function delete($id) {

    $page      = $this->page($id);
    $error     = null;
    $blueprint = blueprint::find($page);
    $back      = array(
      'subpages' => purl('subpages/index/' . $page->parent()->id()),
      'page'     => purl($page, 'show')
    );

    if($page->isHomePage()) {
      $errortype = 'home';
    } else if($page->isErrorPage()) {
      $errortype = 'error';
    } else if($page->hasChildren()) {
      $errortype = 'children';
    } else if(!$blueprint->deletable()) {
      $errortype = 'blocked';
    } else {
      $errortype = null;
    }

    if($errortype) {
      $error = array(
        'headline' => l::get('pages.delete.error.' . $errortype . '.headline'),
        'text'     => l::get('pages.delete.error.' . $errortype . '.text'),
      );
    } else {
      $error = null;
    }

    return view('pages/delete', array(
      'page'  => $this->page($id),
      'back'  => a::get($back, get('to')),
      'error' => $error
    ));

  }

  public function url($id) {
    return view('pages/url', array(
      'page' => $this->page($id)
    ));
  }

  public function search($id = '/') {

    $page = $this->page($id);

    return view('pages/search', array(
      'topbar' => new Snippet('pages/search/topbar', array(
        'menu'       => new Snippet('menu'),
        'breadcrumb' => new Snippet('pages/breadcrumb', array('page' => $page)),
        'close'      => $page->isSite() ? purl('/') : purl($page, 'show')
      )),
      'page' => $page
    ));

  }

  protected function page($id = '/') {

    $page = $id == '/' ? site() : page($id);

    if($page) {
      return $page;
    } else {
      throw new Exception('The page could not be found');
    }

  }

}