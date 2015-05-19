<?php

class PagesController extends Controller {

  public function show($id) {

    try {
      $page = $this->page($id);      
    } catch(Exception $e) {
      $page = $this->page(dirname($id));
      // dirty work around to move to the parent page
      die('<script>window.location.href = "#/pages/show/' . $page->id() . '"</script>');
    }

    $blueprint = blueprint::find($page);
    $fields    = $blueprint->fields($page);
    $content   = $page->content()->toArray();
    $files     = null;
    $subpages  = null;
    $preview   = null;

    // create the preview link
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

    }

    // make sure the title is always there
    $content['title'] = $page->title();

    // merge with the kept snapshot
    $changes = PageStore::fetch($page);
    $content = array_merge($content, $changes);

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

    // create the subpages if they exist
    if($blueprint->pages()->max() !== 0 and $blueprint->pages()->hide() == false) {

      // fetch all subpages in the right order
      $children = api::subpages($page->children(), $blueprint);

      // add pagination to the subpages
      if($limit = $blueprint->pages()->limit()) {
        $children = $children->paginate($limit, array('page' => get('page')));
      }

      // create the snippet and fill it with all data
      $subpages = new Snippet('pages/sidebar/subpages', array(
        'title'      => l('pages.show.subpages.title'),
        'page'       => $page,
        'subpages'   => $children,
        'addbutton'  => !api::maxPages($page, $blueprint->pages()->max()),
        'pagination' => $children->pagination(),
      ));

    }

    // create the files
    if($blueprint->files()->max() !== 0 and $blueprint->files()->hide() == false) {

      $files = new Snippet('pages/sidebar/files', array(
        'page'  => $page,
        'files' => api::files($page, $blueprint),
      ));

    }

    // create the monster sidebar
    $sidebar = new Snippet('pages/sidebar', array(
      'page'      => $page,
      'preview'   => $preview,
      'deletable' => !$page->hasChildren() and $page->isDeletable() and $blueprint->deletable(),
      'subpages'  => $subpages,
      'files'     => $files,
    ));

    return view('pages/show', array(
      'topbar' => new Snippet('pages/topbar', array(
        'breadcrumb' => new Snippet('pages/breadcrumb', array('page' => $page)),
        'search'     => purl($page, 'search')
      )),
      'sidebar' => $sidebar,
      'form'    => $form,
      'changes' => $changes,
      'page'    => $page,
      'notitle' => !$form->fields()->get('title')
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

    $form = panel()->form('pages.add');
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

    if(api::maxPages($page, $blueprint->pages()->max())) {
      $form->fields = array(
        'info' => form::field('info', array(
          'label' => 'pages.add.error.max.headline',
          'text'  => 'pages.add.error.max.text'
        ))
      );
      $form->save     = false;
      $form->centered = true;
    }

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

    $page = $this->page($id);

    if($page->isHomePage() or $page->isErrorPage()) {
      goToErrorView('modal');
    }

    return view('pages/url', array(
      'page' => $page
    ));
  }

  public function toggle($id) {

    $page = $this->page($id);

    if($page->isErrorPage()) {
      goToErrorView('modal');
    }

    $form = panel()->form('pages.toggle');
    $form->save = l('change');
    $form->back = purl($page, 'show');

    if($page->isVisible()) {
      $form->fields->confirmation->text = l('pages.toggle.hide');      
    } else {
      $form->fields->confirmation->text = l('pages.toggle.publish');      
    }

    return view('pages/toggle', array(
      'page' => $page, 
      'form' => $form
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