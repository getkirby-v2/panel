<?php 

namespace Kirby\Panel\Models\Page;

use Exception;
use S;

use Kirby\Panel\Snippet;
use Kirby\Panel\View;
use Kirby\Panel\Models\Page;

class Editor {

  public $page;
  public $blueprint;
  public $form;

  public function __construct($page) {

    $this->page      = $page;
    $this->blueprint = $page->blueprint();

    $this->setForm();

  }

  public function setPage($id) {
  }

  public function setForm() {

    $page = $this->page;
    $form = panel()->form('pages/edit', $this->page, function($form) use($page) {

      // validate all fields
      $form->validate();

      // stop at invalid fields
      if(!$form->isValid()) {
        return panel()->alert(l('pages.show.error.form'));
      }

      try {

        $page->update($form->serialize());

        panel()->notify(l('saved'));

        if($page->isSite()) {
          return panel()->redirect('options');
        } else {
          return panel()->redirect($page);
        }

      } catch(Exception $e) {
        return panel()->alert($e->getMessage());
      }

    });
  
    return $this->form = $form;

  }

  public function page() {
    return $this->page;
  }

  public function form() {
    return $this->form;
  }

  public function subpages() {

    if(!$this->page->canShowSubpages()) {
      return null;
    }

    // fetch all subpages in the right order
    $children = $this->page->children();

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
      'addbutton'  => $this->page->addButton(),
      'pagination' => $children->pagination(),
    ));

  }

  public function files() {

    if(!$this->page->canShowFiles()) {
      return null;
    }

    return new Snippet('pages/sidebar/files', array(
      'page'  => $this->page,
      'files' => $this->page->files(),
    ));

  }

  public function sidebar() {

    // create the monster sidebar
    return new Snippet('pages/sidebar', array(
      'page'      => $this->page,
      'menu'      => $this->page->menu('sidebar'),
      'subpages'  => $this->subpages(),
      'files'     => $this->files(),
    ));

  }

  public function breadcrumb() {
    return new Snippet('pages/breadcrumb', array('page' => $this->page));      
  }

  public function topbar() {

    return new Snippet('pages/topbar', array(
      'breadcrumb' => $this->breadcrumb(),
      'search'     => $this->page->url('search'),
    ));

  }

  public function content() {

    return new View('pages/edit', array(
      'sidebar'  => $this->sidebar(),
      'form'     => $this->form(),
      'page'     => $this->page,
      'notitle'  => $this->page->hasNoTitleField(),
      'uploader' => new Snippet('uploader', array('url' => $this->page->url('upload')))
    ));

  }

}